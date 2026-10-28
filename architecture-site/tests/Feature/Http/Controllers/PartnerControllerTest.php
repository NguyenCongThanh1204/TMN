<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PartnerControllerTest extends TestCase
{
    public function test_index_renders_partners_that_have_logos(): void
    {
        config(['pagecache.enabled' => false]);
        Schema::dropIfExists('partners');
        Schema::create('partners', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
        DB::table('partners')->insert([
            [
                'name' => 'Test Construction Partner',
                'logo' => 'partners/test-logo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Partner Without Logo',
                'logo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/partners');

        $response->assertOk()
            ->assertSee('Test Construction Partner')
            ->assertSee('alt="Test Construction Partner"', false)
            ->assertDontSee('Partner Without Logo');
    }
}
