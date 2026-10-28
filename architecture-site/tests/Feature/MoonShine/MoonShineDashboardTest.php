<?php

namespace Tests\Feature\MoonShine;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MoonShine\Laravel\Models\MoonshineUser;
use Tests\TestCase;

class MoonShineDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_the_dashboard(): void
    {
        $user = MoonshineUser::factory()->create();

        $this->actingAs($user, 'moonshine')
            ->get(route('moonshine.index'))
            ->assertOk();
    }
}
