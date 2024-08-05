<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\OrderParchuse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify(),
            'name' => $this->faker->name(),
            'pu' => $this->faker->randomFloat(2, 1, 100), // price unit with 2 decimal places, range 1 to 100
            'um' => $this->faker->randomElement(['Kg', 'Ltr', 'Pcs','Und','Caja','M2','Par']), 
            'order_id' => OrderParchuse::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 100),
            'category_id' => Category::inRandomOrder()->first()->id
        ];
    }
}
