<?php

namespace Database\Seeders;

use App\Models\Cidade;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cidade::factory(10)->create();

        $cidades = [Cidade::factory()->create(), Cidade::factory()->create()];
        for ($i = 0; $i < 5; $i++) {
            Product::factory()->create(['cidade_id' => $cidades[$i % 2]->id]);
        }
    }
}
