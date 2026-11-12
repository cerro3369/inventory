<?php

namespace Database\Seeders;

use App\Models\Edition;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name'     => 'roberto',
            'email'    => 'roberto@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

        $this->call([
            ProductSeeder::class,
        ]);

        Product::factory(10)->create([
            'user_id' => $user->id,
        ]);

        Edition::factory(10)->create();
    }
}