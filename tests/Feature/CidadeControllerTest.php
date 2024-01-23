<?php
namespace Tests\Feature;

use App\Models\Cidade;
use Tests\TestCase;

class CidadeControllerTest extends TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    $this->artisan('migrate:fresh');
  }

  public function testGetCities()
  {
    $response = $this->get('/api/cidades');
    $response->assertStatus(404);

    Cidade::factory()->create();

    $response = $this->get('/api/cidades');
    $response->assertStatus(200);
    $response->assertJsonCount(1);

    Cidade::factory()->create();
    $response = $this->get('/api/cidades');
    $response->assertStatus(200);
    $response->assertJsonCount(2);
  }
}
