<?php

namespace Database\Factories;

use App\Models\BuyProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuyProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BuyProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'attr_to_product_id' => rand(1, 20)
        ];
    }
}
