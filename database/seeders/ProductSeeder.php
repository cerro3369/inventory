<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $products = [
            ['titulo' => 'Batman: The Dark Knight Returns'],
            ['titulo' => 'Watch Dogs: Legion Comic Series'],
            ['titulo' => 'Spider-Man: Blue'],
            ['titulo' => 'Sandman Omnibus'],
        ];

        foreach ($products as $product) {
            Product::create([
                'user_id' => $user->id,
                'titulo'  => $product['titulo'],
            ]);
        }
    }
}