<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public static $createRules = [
        'nome' => 'required|string|min:3|max:255',
        'valor' => 'required|numeric|min:0',
        'estoque' => 'required|integer|min:0',
        'cidade_id' => 'required|exists:cidades,id'
    ];
    public static $updateRules = [
        'cod' => 'sometimes|exists:products,cod',
        'nome' => 'sometimes|string|min:3|max:255',
        'valor' => 'sometimes|numeric|min:0',
        'estoque' => 'sometimes|integer|min:0',
        'cidade_id' => 'sometimes|exists:cidades,id'
    ];

    protected $primaryKey = 'cod';
    protected $fillable = ['nome', 'valor', 'estoque', 'cidade_id'];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

    protected $casts = [
        'valor' => 'float',
        'estoque' => 'integer',
    ];
}
