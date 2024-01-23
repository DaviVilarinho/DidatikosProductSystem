<?php
namespace Tests\Feature;

use App\Models\Cidade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
  private $EXISTENT_CITY_ID;
  public function setUp(): void
  {
    parent::setUp();
    $this->artisan('migrate:fresh');
    $cidade = Cidade::factory()->create();
    $this->EXISTENT_CITY_ID = $cidade->id;
  }

  public function testCreateNewProducts()
  {
    $requestProduct = ['nome' => 'Produto 1', 'valor' => 10.00, 'estoque' => 10, 'cidade_id' => $this->EXISTENT_CITY_ID];
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);

    $requestProduct['nome'] = "outra coisa";
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);

    $this->assertCount(2, Cidade::find($this->EXISTENT_CITY_ID)->products);
  }

  public function testGetProducts()
  {
    $response = $this->get('/api/products');
    $response->assertStatus(404);

    $requestProduct = ['nome' => 'Produto 1', 'valor' => 10.00, 'estoque' => 10, 'cidade_id' => $this->EXISTENT_CITY_ID];
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
    $cod = $response->decodeResponseJson()['cod'];

    $response = $this->get('/api/products');
    $response->assertStatus(200);
    $response->assertJsonCount(1);
    $response = $this->get("/api/products/$cod");
    $response->assertStatus(200);
  }

  public function testDoNotCreateInvalidCities()
  {
    $requestProduto = [
      'cod' => 100,
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTENT_CITY_ID + 1
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
      'cidade_id' => $this->EXISTENT_CITY_ID
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
      'cidade_id' => $this->EXISTENT_CITY_ID
    ];

    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
    $this->assertCount(2, Cidade::find($this->EXISTENT_CITY_ID)->products);
  }

  public function testDeleteOnlyExistentProducts()
  {
    $requestProduct = [
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTENT_CITY_ID
    ];
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
    $requestProduct = $response->decodeResponseJson();

    $this->assertCount(1, Cidade::find($this->EXISTENT_CITY_ID)->products);

    $deleteCode = $requestProduct['cod'];
    $response = $this->delete("/api/products/$deleteCode");
    $response->assertStatus(200);

    $this->assertCount(0, Cidade::find($this->EXISTENT_CITY_ID)->products);

    $response = $this->delete("/api/products/$deleteCode");
    $response->assertStatus(400);
  }

  public function testUpdateOnlyExistentProducts()
  {
    $requestProduct = [
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTENT_CITY_ID
    ];
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
    $requestProduct = $response->decodeResponseJson();

    $this->assertCount(1, Cidade::find($this->EXISTENT_CITY_ID)->products);

    $updateCode = $requestProduct['cod'];
    $requestProduct['nome'] = 'um nome diferente';
    $response = $this->put("/api/products/$updateCode", [$requestProduct]);
    $response->assertStatus(200);

    $this->assertCount(1, Cidade::find($this->EXISTENT_CITY_ID)->products);

    $updateCode = 0;
    $response = $this->put("/api/products/$updateCode", [$requestProduct]);
    $response->assertStatus(404);
  }

  public function testUpdateOnlyValidCities()
  {
    $requestProduct = [
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTENT_CITY_ID
    ];
    $response = $this->post('/api/products', $requestProduct);
    $response->assertStatus(201);
    $response = $response->decodeResponseJson();

    $updateCode = $response['cod'];
    $requestProduct['cod'] = $updateCode;
    $requestProduct['cidade_id'] = $this->EXISTENT_CITY_ID + 1;
    $response = $this->put("/api/products/$updateCode", $requestProduct);
    $response->assertStatus(400);
  }
}
