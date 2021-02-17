<?php

namespace Database\Factories;

use App\Models\ProductIsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductIsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductIsCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(1, 50),
            'category_id' => rand(1, 15)
        ];
    }
}
