<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cidade;
use App\Models\Product;

class CidadeProductTest extends TestCase
{
  use RefreshDatabase;

  public function testAchaProdutosPorCidades()
  {
    $cidade = Cidade::factory()->create();
    $outraCidade = Cidade::factory()->create();
    $product1 = Product::factory()->create(['cidade_id' => $cidade->id]);
    $product2 = Product::factory()->create(['cidade_id' => $cidade->id]);
    $product3 = Product::factory()->create(['cidade_id' => $outraCidade->id]);

    $this->assertCount(2, $cidade->products);
    $this->assertCount(1, $outraCidade->products);
    $produtosDaCidade = $cidade->find($cidade->id)->products;
    $produtosDaOutraCidade = $outraCidade->find($outraCidade->id)->products;
    $this->assertTrue($produtosDaCidade->contains($product1));
    $this->assertFalse($produtosDaOutraCidade->contains($product1));
    $this->assertTrue($produtosDaCidade->contains($product2));
    $this->assertTrue($produtosDaOutraCidade->contains($product3));
    $this->assertFalse($produtosDaOutraCidade->contains($product2));
  }
}