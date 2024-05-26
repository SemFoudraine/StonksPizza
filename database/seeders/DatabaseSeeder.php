<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pizza;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                Pizza::create([
            'name' => 'Pizza Margherita',
            'description' => 'Traditional Italian pizza with tomato sauce, mozzarella cheese, and basil leaves.',
            'image' => 'https://example.com/pizza_margherita.jpg',
            'price' => 9.99,
            'calories' => 800,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
