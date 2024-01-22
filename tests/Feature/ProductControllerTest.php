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

  public function testCriarProductsNovos()
  {
    $requestProduto = ['nome' => 'Produto 1', 'valor' => 10.00, 'estoque' => 10, 'cidade_id' => $this->EXISTANT_CITY_ID];
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(201);

    $requestProduto['nome'] = "outra coisa mas id mesmo";
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(201);
  }

  public function testNaoCriarProductsInvalidosCidade()
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

  public function testNaoCriarProductsInvalidosValor()
  {
    $requestProduto = [
      'cod' => 100,
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTANT_CITY_ID
    ];

    $requestProduto['valor'] = 'valor invalido';
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(400);
    $requestProduto['valor'] = null;
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(400);
  }

  public function testNaoCriarProductsInvalidosEstoque()
  {
    $requestProduto = [
      'cod' => 100,
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTANT_CITY_ID
    ];

    $requestProduto['estoque'] = 'estoque invalido';
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(400);
    $requestProduto['estoque'] = null;
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(400);
  }

  public function testNaoCriarProductsInvalidosNome()
  {
    $requestProduto['nome'] = 1;
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(400);
    $requestProduto['nome'] = null;
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(400);
  }
  public function testNaoDarOverrideSeUserDerCod()
  {
    $requestProduto = [
      'cod' => 100,
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
      'cidade_id' => $this->EXISTANT_CITY_ID
    ];

    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(201);
    $response = $this->post('/api/products', $requestProduto);
    $response->assertStatus(201);
    $this->assertCount(2, Cidade::find($this->EXISTANT_CITY_ID)->products);
  }
}
