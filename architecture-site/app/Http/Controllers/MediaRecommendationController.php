<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PostMedia;
use App\Services\MediaRecommendationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Returns AI-free image recommendations for an article being written.
 *
 * POST /manager/media-library/recommendations
 * Auth: moonshine
 */
class MediaRecommendationController extends Controller
{
    public function __invoke(Request $request, MediaRecommendationService $service): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:500'],
            'category_id' => ['nullable', 'integer'],
            'content' => ['nullable', 'string', 'max:20000'],
        ]);

        $recommendations = $service->recommend($validated, limit: 12);

        $results = $recommendations->map(function (array $item): array {
            /** @var PostMedia $media */
            $media = $item['media'];

            return [
                'id' => $media->id,
                'file_path' => $media->file_path,
                'url' => $media->url,
                'thumbnail_url' => $media->thumbnail_url,
                'caption' => $media->caption,
                'alt_text' => $media->alt_text,
                'keywords' => $media->keywords,
                'folder_name' => $media->folder?->name,
                'score' => $item['score'],
                'reasons' => $item['reasons'],
            ];
        });

        return response()->json([
            'data' => $results->values(),
            'total' => $results->count(),
        ]);
    }
}
