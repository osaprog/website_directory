<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use App\Models\Vote;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesApplication;
use Tests\TestCase;

class WebsiteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, CreatesApplication;
    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_guest_can_view_websites()
    {
        $response = $this->getJson('/api/websites');

        $response->assertStatus(200);
    }

    public function test_user_can_add_website()
    {
        $user = User::factory()->create()->assignRole('user');

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/websites', [
            'name' => 'Test Website',
            'url' => 'https://test.com',
            'description' => 'A test website',
            'categories' => [1],
        ]);

        $response->assertStatus(201);
    }

    public function test_admin_can_delete_website()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $website = Website::factory()->create();

        $this->actingAs($admin, 'sanctum');

        $response = $this->deleteJson('/api/websites/' . $website->id);

        $response->assertStatus(200);
    }
}
