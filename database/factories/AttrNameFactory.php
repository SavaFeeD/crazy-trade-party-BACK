<?php

namespace Database\Factories;

use App\Models\AttrName;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttrNameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttrName::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText(15)
        ];
    }
}
