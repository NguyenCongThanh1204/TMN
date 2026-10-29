<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CloudinaryImageUrlTest extends TestCase
{
    public function test_cloudinary_url_uses_large_default_transform(): void
    {
        $url = cloudinary_image_url('https://res.cloudinary.com/demo/image/upload/v123/projects/cover.webp');

        $this->assertSame(
            'https://res.cloudinary.com/demo/image/upload/w_1600/f_auto/q_auto:best/v123/projects/cover.webp',
            $url
        );
    }

    public function test_cloudinary_url_replaces_existing_quality_and_width_transforms(): void
    {
        $url = cloudinary_image_url(
            'https://res.cloudinary.com/demo/image/upload/w_800/f_auto/q_auto/v123/projects/cover.webp',
            1200
        );

        $this->assertSame(
            'https://res.cloudinary.com/demo/image/upload/w_1200/f_auto/q_auto:best/v123/projects/cover.webp',
            $url
        );
    }

    public function test_non_cloudinary_url_is_unchanged(): void
    {
        $url = 'https://example.com/images/cover.webp';

        $this->assertSame($url, cloudinary_image_url($url));
    }
}
