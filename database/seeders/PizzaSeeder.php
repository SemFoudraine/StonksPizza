<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Pizza;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pizza::create([
            'name' => 'Pizza Margherita',
            'description' => 'Traditional Italian pizza with tomato sauce, mozzarella cheese, and basil leaves.',
            'image' => 'https://example.com/pizza_margherita.jpg',
            'price' => 9.99,
            'calories' => 800,
        ]);

        // Voeg hier meer pizza's toe als nodig
    }
}
