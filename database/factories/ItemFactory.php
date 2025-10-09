<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Unit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'item_code' => 'Itm' . fake()->numberBetween(111111, 999999),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1, 10000),
            'quantity' => fake()->randomFloat(2, 1, 10000),
            'minimum_stock' => fake()->randomFloat(2, 1, 10000),
            'is_shown_in_store' => fake()->boolean(),
            'category_id' => Category::inRandomOrder()->value('id'),
            'unit_id' => Unit::inRandomOrder()->value('id'),
        ];
    }
}
