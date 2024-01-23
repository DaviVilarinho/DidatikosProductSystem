<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function get()
    {
        $cidades = Cidade::all();
        if (count($cidades) == 0) {
            return response()->json(['message' => 'Não há cidades cadastradas'], 404);
        }
        return response()->json($cidades);
    }
}
