<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function get()
    {
        $products = Product::all();
        if (count($products) == 0) {
            return response()->json(['message' => 'Não há produtos cadastrados'], 404);
        }
        return response()->json($products);
    }

    public function getById($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        return response()->json($product);
    }


    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), Product::$createRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create($validator->validated());

        return response()->json($product, 201);
    }

    public function putById(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Product::$updateRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        $product->update($validator->validated());
        return response()->json(['message' => 'Atualizado com sucesso'], 200);
    }

    public function deleteById($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Produto não encontrado'], 400);
        }
        $product->delete();
        return response()->json(['message' => 'Produto removido com sucesso'], 200);
    }
}
