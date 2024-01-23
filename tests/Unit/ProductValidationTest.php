<?php
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CidadeProductTest extends TestCase
{
  public function testFieldsMustComplainProductType()
  {
    $product = [
      'nome' => 'Produto 1',
      'valor' => 10.00,
      'estoque' => 10,
    ];
    $validator = Validator::make($product, Product::$updateRules);
    $this->assertFalse($validator->fails());
    $product['nome'] = 1;
    $validator = Validator::make($product, Product::$updateRules);
    $this->assertTrue($validator->fails());
    $product['nome'] = null;
    $validator = Validator::make($product, Product::$updateRules);
    $this->assertTrue($validator->fails());
    unset($product['nome']);
    $validator = Validator::make($product, Product::$updateRules);
    $this->assertFalse($validator->fails());

    foreach (['valor', 'estoque'] as $key) {
      $product[$key] = -1;
      $validator = Validator::make($product, Product::$updateRules);
      $this->assertTrue($validator->fails());
      $product[$key] = null;
      $validator = Validator::make($product, Product::$updateRules);
      $this->assertTrue($validator->fails());
      unset($product[$key]);
      $validator = Validator::make($product, Product::$updateRules);
      $this->assertFalse($validator->fails());
    }
  }
}

