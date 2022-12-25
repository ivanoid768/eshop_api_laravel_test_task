<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Category_' . fake()->unique()->word(),
            'parent_id' => null
        ];
    }

    public function withParent($parent_id)
    {
        return $this->state([
            'name' => 'Category_' . fake()->unique()->word(),
            'parent_id' => $parent_id
        ]);
    }
}