<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MediaFolder extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('name');
    }

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class, 'folder_id');
    }

    /**
     * Find the folder that corresponds to a post, matching its slug first, then its title.
     */
    public static function findForPost(?string $slug, ?string $title): ?self
    {
        $slugs = array_values(array_unique(array_filter([
            $slug,
            filled($title) ? Str::slug($title) : null,
        ])));

        if ($slugs === [] && blank($title)) {
            return null;
        }

        $candidates = static::query()
            ->where(function ($query) use ($slugs, $title): void {
                $query->whereIn('slug', $slugs);

                if (filled($title)) {
                    $query->orWhere('name', $title);
                }
            })
            ->get();

        return $candidates->first(fn (self $folder): bool => $folder->slug === $slug)
            ?? $candidates->first(fn (self $folder): bool => $folder->name === $title)
            ?? $candidates->first();
    }
}
