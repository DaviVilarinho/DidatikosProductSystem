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
    $outracidade = Cidade::factory()->create();
    $product1 = Product::factory()->create(['cidade_id' => $cidade->id]);
    $product2 = Product::factory()->create(['cidade_id' => $cidade->id]);
    $product3 = Product::factory()->create(['cidade_id' => $outracidade->id]);

    $this->assertCount(2, $cidade->products);
    $this->assertCount(1, $outracidade->products);
    $produtos_da_cidade = $cidade->find($cidade->id)->products;
    $produtos_da_outra_cidade = $outracidade->find($outracidade->id)->products;
    $this->assertTrue($produtos_da_cidade->contains($product1));
    $this->assertFalse($produtos_da_outra_cidade->contains($product1));
    $this->assertTrue($produtos_da_cidade->contains($product2));
    $this->assertTrue($produtos_da_outra_cidade->contains($product3));
    $this->assertFalse($produtos_da_outra_cidade->contains($product2));
  }
}