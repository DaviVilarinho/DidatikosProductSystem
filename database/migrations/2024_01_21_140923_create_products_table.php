<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('cod');
            $table->string('nome');
            $table->integer('estoque');
            $table->decimal('valor', 15, 2);
            $table->timestamps();
            $table->unsignedBigInteger('cidade_id');
            $table->foreign('cidade_id')->references('id')->on('cidades');
        });
    }
    protected $fillable = ['nome', 'valor', 'estoque', 'cidade_id'];

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
