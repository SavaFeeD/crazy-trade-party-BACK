<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'short_description' => $this->faker->realText(20),
            'description' => $this->faker->realText(70),
            'price' => rand(1, 60000),
            'views_count' => rand(0, 200),
            'numbers' => rand(0, 50)
        ];
    }
}
