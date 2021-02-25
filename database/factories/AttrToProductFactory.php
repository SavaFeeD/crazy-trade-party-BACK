<?php

namespace Database\Factories;

use App\Models\AttrToProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttrToProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttrToProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attr_data_id' => rand(1, 20),
            'product_id' => rand(1, 50),
            'numbers' => rand(0, 50)
        ];
    }
}
