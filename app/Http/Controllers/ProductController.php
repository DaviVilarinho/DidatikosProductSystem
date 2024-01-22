<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\QueryException;
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
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'valor' => 'required|numeric',
            'estoque' => 'required|integer',
            'cidade_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $product = Product::create($request->all());

            return response()->json(['message' => 'Produto criado com sucesso'], 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Produto inválido'], 400);
        }
    }

    public function putById($request, $id)
    {
        try {
            $product = Product::find($id);
            if (is_null($product)) {
                return response()->json(['message' => 'Produto não encontrado'], 404);
            }
            $product->update($request->all());
            return response()->json(['message' => 'Atualizado com sucesso'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Erro ao atualizar o produto'], 400);
        }
    }

    public function deleteById($id)
    {
        try {
            $product = Product::find($id);
            if (is_null($product)) {
                return response()->json(['message' => 'Produto não encontrado'], 400);
            }
            $product->delete();
            return response()->json(['message' => 'Produto removido com sucesso'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Erro ao remover o produto'], 400);
        }
    }
}
