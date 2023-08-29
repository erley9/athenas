<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClientTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testListClients()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('GET', '/api/client');

        $response->assertOk();
    }

    public function testFoundClient()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('GET', '/api/client/1');

        $response->assertOk();
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Successfully"]);
    }

    public function testCreateClient()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('POST', '/api/client', [
            'name' => 'Jose rodrigues',
            'cpf' => '43443453405',
            'email' => 'jose123456@gmail.com',
            'category' => 1
        ]);

        $response->assertOk();
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Successfully"]);
        $response->assertJsonPath('data.name', 'Jose rodrigues');
        $response->assertJsonPath('data.email', 'jose123456@gmail.com');
    }

    public function testUpdateClient()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('PUT', '/api/client/1', [
            'name' => 'Jose maria',
            'cpf' => '43443453403',
            'email' => 'josemaria@gmail.com',
            'category' => 2
        ]);

        $response->assertOk();
        $response->assertJson(['message' => "Client Updated"]);
        $response->assertJson(['status' => true]);
        $response->assertJsonPath('data.name', 'Jose maria');
        $response->assertJsonPath('data.email', 'josemaria@gmail.com');
    }

    public function testDeleteClient()
    {
        $user = User::factory()->create();

        $delete = $this->actingAs($user)->json('DELETE', '/api/client/1');

        $delete->assertOk();
        $delete->assertJson(['status' => true]);
        $delete->assertJson(['message' => "Client Deleted"]);
    }

}
