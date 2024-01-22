<?php
namespace Tests\Feature;

use Tests\TestCase;

class ProductControllerTest extends TestCase
{
  public function testCriarProducts()
  {
    $response = $this->get('/products');
    $response->assertStatus(404);

    $requestProduto = ['cod' => 1, 'nome' => 'Produto 1', 'valor' => 10.00, 'estoque' => 10, 'cidade_id' => 1];

    $response = $this->post('/products', $requestProduto);
    $response->assertStatus(201);
    $response = $this->post('/products', $requestProduto);
    $response->assertStatus(400);

    $requestProduto['nome'] = "outra coisa mas id mesmo";
    $response = $this->post('/products', $requestProduto);
    $response->assertStatus(400);
  }
}
