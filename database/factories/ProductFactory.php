<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => 'Product_' . fake()->word() . '_' . fake()->word(),
            "description" => fake()->text(500),
            "slug" => fake()->uuid(),
            "categoryid" => null,
            "price" => fake()->numberBetween(1, 1000),
            "length" => fake()->numberBetween(1, 100),
            "width" => fake()->numberBetween(1, 100),
            "weight" => fake()->numberBetween(1, 100)
        ];
    }

    public function withCategory($category_id)
    {
        $name = 'Product_' . fake()->word() . '_' . fake()->word();

        return $this->state([
            "name" => $name,
            "description" => fake()->text(500),
            "slug" => Str::slug($name),
            "categoryid" => $category_id,
            "price" => fake()->numberBetween(1, 1000),
            "length" => fake()->numberBetween(1, 100),
            "width" => fake()->numberBetween(1, 100),
            "weight" => fake()->numberBetween(1, 100)
        ]);
    }
}