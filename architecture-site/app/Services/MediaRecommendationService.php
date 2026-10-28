<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MediaFolder;
use App\Models\PostCategory;
use App\Models\PostMedia;
use Illuminate\Support\Collection;

/**
 * Lightweight keyword-based media recommendation engine.
 *
 * Scoring priority (highest to lowest):
 *  5 — Exact match in image keywords
 *  4 — Partial match between title tokens and image keywords
 *  3 — Article category name matches folder name
 *  2 — Match in caption or alt_text
 *  1 — Match in description or file_path
 *
 * Works entirely offline — no AI API required.
 * Supports Vietnamese accent normalization and common synonym mapping.
 */
class MediaRecommendationService
{
    /**
     * Common Vietnamese ↔ English synonym pairs for architecture / recruitment domain.
     * Keys are normalized Vietnamese fragments; values are English equivalents to
     * expand the search token set so both languages are matched.
     *
     * @var array<string, list<string>>
     */
    private const SYNONYMS = [
        'tuyen dung' => ['recruitment', 'hiring', 'hr'],
        'recruitment' => ['tuyen dung', 'tuyen_dung'],
        'du an' => ['project', 'projects'],
        'project' => ['du an', 'du_an', 'cong trinh'],
        'cong trinh' => ['project', 'construction'],
        'van phong' => ['office', 'offices'],
        'office' => ['van phong', 'van_phong'],
        'kien truc' => ['architecture', 'architectural'],
        'architecture' => ['kien truc', 'kien_truc'],
        'xay dung' => ['construction', 'building'],
        'construction' => ['xay dung', 'xay_dung'],
        'tin tuc' => ['news'],
        'news' => ['tin tuc', 'tin_tuc'],
        'hoat dong' => ['activity', 'activities', 'events'],
        'company' => ['cong ty', 'doanh nghiep'],
        'cong ty' => ['company'],
        'chung cu' => ['apartment', 'residential'],
        'nha o' => ['house', 'residential', 'housing'],
        'residential' => ['chung cu', 'nha o', 'nha_o'],
    ];

    /**
     * Recommend media for an article based on title, category, and optional content.
     *
     * @param  array{title?: string, category_id?: int|string|null, content?: string}  $context
     * @return Collection<int, array{media: PostMedia, score: int, reasons: list<string>}>
     */
    public function recommend(array $context, int $limit = 12): Collection
    {
        $title = (string) ($context['title'] ?? '');
        $categoryId = isset($context['category_id']) ? (int) $context['category_id'] : null;
        $content = (string) ($context['content'] ?? '');

        if (blank($title) && $categoryId === null && blank($content)) {
            return collect();
        }

        // Build token sets -------------------------------------------------------
        $titleTokens = $this->expandWithSynonyms($this->tokenize($title));
        $contentTokens = $this->expandWithSynonyms($this->tokenize($content));

        // Determine category name and matching folder IDs -------------------------
        $categoryName = $this->resolveCategoryName($categoryId);
        $categoryTokens = $categoryName ? $this->tokenize($categoryName) : [];
        $folderIds = $categoryName ? $this->matchingFolderIds($categoryName, $categoryTokens) : [];

        // Load all media with their folder, eager-loaded (no N+1) ----------------
        $allMedia = PostMedia::query()
            ->with('folder')
            ->whereNotNull('file_path')
            ->get();

        // Score each media item ---------------------------------------------------
        $scored = $allMedia
            ->map(function (PostMedia $media) use ($titleTokens, $contentTokens, $categoryTokens, $folderIds): array {
                [$score, $reasons] = $this->score($media, $titleTokens, $contentTokens, $categoryTokens, $folderIds);

                return ['media' => $media, 'score' => $score, 'reasons' => $reasons];
            })
            ->filter(fn (array $item): bool => $item['score'] > 0)
            ->sortByDesc('score')
            ->take($limit)
            ->values();

        return $scored;
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Score a single media record against the article context.
     *
     * @param  list<string>  $titleTokens
     * @param  list<string>  $contentTokens
     * @param  list<string>  $categoryTokens
     * @param  list<int>  $folderIds
     * @return array{0: int, 1: list<string>}
     */
    private function score(
        PostMedia $media,
        array $titleTokens,
        array $contentTokens,
        array $categoryTokens,
        array $folderIds,
    ): array {
        $score = 0;
        $reasons = [];

        $imageKeywords = $media->parsedKeywords();
        $searchableText = $media->searchableText();

        // ── Level 5: exact keyword match ─────────────────────────────────────
        foreach ($titleTokens as $token) {
            if ($token !== '' && in_array($token, $imageKeywords, true)) {
                $score += 5;
                $reasons[] = "Matches keyword: {$token}";
            }
        }

        // ── Level 4: partial keyword match ───────────────────────────────────
        foreach ($titleTokens as $token) {
            if ($token === '') {
                continue;
            }
            foreach ($imageKeywords as $kw) {
                if ($kw !== $token && str_contains($kw, $token)) {
                    $score += 4;
                    $reasons[] = "Partial keyword match: {$token}";
                    break;
                }
            }
        }

        // ── Level 3: category ↔ folder match ──────────────────────────────
        if ($folderIds && $media->folder_id && in_array($media->folder_id, $folderIds, true)) {
            $score += 3;
            $reasons[] = 'Matches category folder: '.($media->folder?->name ?? '');
        }

        // ── Level 2: title tokens in caption / alt_text ──────────────────
        $captionText = mb_strtolower((string) $media->caption.' '.(string) $media->alt_text);
        foreach ($titleTokens as $token) {
            if ($token !== '' && str_contains($captionText, $token)) {
                $score += 2;
                $reasons[] = "Matches caption/alt: {$token}";
                break; // one boost per caption match
            }
        }

        // ── Level 1: description / file_path / content tokens ─────────────
        foreach ($titleTokens as $token) {
            if ($token !== '' && str_contains($searchableText, $token)) {
                $score += 1;
                // only add reason once
                if (! in_array('Matches description', $reasons, true)) {
                    $reasons[] = 'Matches description or filename';
                }
                break;
            }
        }

        // ── Bonus: content tokens in searchable text ──────────────────────
        foreach ($contentTokens as $token) {
            if ($token !== '' && str_contains($searchableText, $token)) {
                $score += 1;
                break;
            }
        }

        // Deduplicate reasons
        $reasons = array_values(array_unique($reasons));

        return [$score, $reasons];
    }

    /**
     * Tokenize a string into normalized, de-accented lowercase tokens.
     *
     * @return list<string>
     */
    private function tokenize(string $text): array
    {
        if (blank($text)) {
            return [];
        }

        // Strip HTML tags from content blobs
        $text = strip_tags($text);

        // Normalize Vietnamese accents to ASCII equivalents
        $text = $this->removeVietnameseAccents($text);

        // Lower-case and split on non-alphanumeric runs
        $tokens = preg_split('/[^a-z0-9]+/u', mb_strtolower($text), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        // Remove very short tokens (< 2 chars) and duplicates
        $tokens = array_values(array_unique(
            array_filter($tokens, static fn (string $t): bool => mb_strlen($t) >= 2)
        ));

        return $tokens;
    }

    /**
     * Expand a token list by appending known synonyms.
     *
     * @param  list<string>  $tokens
     * @return list<string>
     */
    private function expandWithSynonyms(array $tokens): array
    {
        $expanded = $tokens;

        foreach ($tokens as $token) {
            $synonymGroups = self::SYNONYMS[$token] ?? [];
            foreach ($synonymGroups as $syn) {
                $expanded[] = $syn;
            }
        }

        return array_values(array_unique($expanded));
    }

    /**
     * Remove Vietnamese diacritics to produce ASCII-comparable strings.
     */
    private function removeVietnameseAccents(string $str): string
    {
        $accents = [
            'á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ặ', 'ằ', 'ẳ', 'ẵ',
            'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'đ',
            'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ',
            'í', 'ì', 'ỉ', 'ĩ', 'ị',
            'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ',
            'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ',
            'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự',
            'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ',
        ];
        $replacements = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'a', 'a', 'a', 'a', 'a', 'a', 'd',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
        ];

        return str_replace($accents, $replacements, $str);
    }

    /**
     * Resolve a human-readable category name from its ID.
     */
    private function resolveCategoryName(?int $categoryId): ?string
    {
        if ($categoryId === null) {
            return null;
        }

        /** @var PostCategory|null $cat */
        $cat = PostCategory::find($categoryId);

        return $cat?->name;
    }

    /**
     * Find folder IDs whose names match the category tokens.
     *
     * @param  list<string>  $categoryTokens
     * @return list<int>
     */
    private function matchingFolderIds(string $categoryName, array $categoryTokens): array
    {
        $normalizedCategoryName = $this->removeVietnameseAccents(mb_strtolower($categoryName));

        return MediaFolder::all()
            ->filter(function (MediaFolder $folder) use ($normalizedCategoryName, $categoryTokens): bool {
                $normalizedFolderName = $this->removeVietnameseAccents(mb_strtolower($folder->name));

                // Exact or substring match on the folder name
                if (str_contains($normalizedFolderName, $normalizedCategoryName) ||
                    str_contains($normalizedCategoryName, $normalizedFolderName)) {
                    return true;
                }

                // Token-level overlap
                $folderTokens = $this->tokenize($folder->name);

                return count(array_intersect($categoryTokens, $folderTokens)) > 0;
            })
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();
    }
}
