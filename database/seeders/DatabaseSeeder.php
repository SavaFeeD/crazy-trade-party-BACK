<?php

namespace Database\Seeders;

use Database\Factories\BuyProductFactory;
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
        \App\Models\User::factory(10)->create();
        \App\Models\Product::factory(50)->create();
        \App\Models\BuyProduct::factory(15)->create();
        \App\Models\Wishlist::factory(20)->create();
    }
}
