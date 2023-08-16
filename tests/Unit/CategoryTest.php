<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testListCategories()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('GET', '/api/category');

        $response->assertOk();
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Successfully"]);
    }

    public function testFoundCategory()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('GET', '/api/category/1');

        $response->assertOk();
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Successfully"]);
    }

    public function testCreateCategory()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('POST', '/api/category', [
            'name' => 'Gerente',
        ]);

        $response->assertOk();
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Successfully"]);
        $response->assertJsonPath('data.name', 'Gerente');
    }

    public function testUpdateCategory()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('PUT', '/api/category/1', [
            'name' => 'Gerente',
        ]);

        $response->assertOk();
        $response->assertJson(['message' => "Category Updated"]);
        $response->assertJson(['status' => true]);
        $response->assertJsonPath('data.name', 'Gerente');
    }

    public function testDeleteCategory()
    {
        $user = User::factory()->create();
    
        $delete = $this->actingAs($user)->json('DELETE', '/api/category/1');

        $delete->assertOk();
        $delete->assertJson(['status' => true]);
        $delete->assertJson(['message' => "Category Deleted"]);
    }
}
