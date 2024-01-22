<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
