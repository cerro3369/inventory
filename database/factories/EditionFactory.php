<?php

namespace Database\Factories;

use App\Models\Edition;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Edition>
 */
class EditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_edicion' => (string) $this->faker->numberBetween(1, 100), 
            'precio_compra'  => $this->faker->randomFloat(2, 5, 150),
            'precio_venta'   => $this->faker->randomFloat(2, 5, 150),
            'stock_actual'   => $this->faker->numberBetween(0, 50),
            'product_id' => Product::all()->random()->id,            
        ];
    }
}
