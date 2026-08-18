<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_platform_users_cannot_open_platform_dashboard(): void
    {
        $user = User::factory()->create(['platform_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_platform_admin_can_open_platform_dashboard(): void
    {
        $user = User::factory()->create(['platform_admin' => true]);

        $this->actingAs($user)->get('/admin')->assertOk();
    }
}
