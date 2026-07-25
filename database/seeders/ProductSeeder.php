<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['titulo' => 'Batman: The Dark Knight Returns'],
            ['titulo' => 'Watch Dogs: Legion Comic Series'],
            ['titulo' => 'Spider-Man: Blue'],
            ['titulo' => 'Sandman Omnibus'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}






