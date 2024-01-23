<?php
namespace Tests\Feature;

use App\Models\Cidade;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
  private $EXISTANT_CITY_ID;
  public function setUp(): void
  {
    parent::setUp();
    $this->artisan('migrate:fresh');
    $cidade = Cidade::factory()->create();
    $this->EXISTANT_CITY_ID = $cidade->id;
  }

  public function testCreateNewProducts()
  {
    $requestProduct = ['nome' => 'Produto 1', 'valor' => 10.00, 'estoque' => 10, 'cidade_id' => $this->EXISTANT_CITY_ID];
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);

    $requestProduct['nome'] = "outra coisa";
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
  }

  public function testDoNotCreateInvalidCities()
  {
    $requestProduto = [
      'cod' => 100,
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTANT_CITY_ID + 1
    ];
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(400);
    $requestProduto['cidade_id'] = null;
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(400);
  }

  public function testDoNotCreateInvalidFieldsExceptCity()
  {
    $requestProduct = [
      'cod' => 100,
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTANT_CITY_ID
    ];

    $requestProduct['valor'] = 'valor invalido';
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(400);
    $requestProduct['valor'] = null;
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(400);
    $requestProduct['valor'] = 40;

    $requestProduct['estoque'] = 'estoque invalido';
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(400);
    $requestProduct['estoque'] = null;
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(400);
    $requestProduct['estoque'] = 40;

    $requestProduct['nome'] = 1;
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(400);
    $requestProduct['nome'] = null;
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(400);
    $requestProduct['nome'] = 'valido';

    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
  }

  public function testDoNotCreateDuplicatesOrOverride()
  {
    $requestProduct = [
      'cod' => 100,
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTANT_CITY_ID
    ];

    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
    $this->assertCount(2, Cidade::find($this->EXISTANT_CITY_ID)->products);
  }
}
