<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\enums\CategoryStatusEnum;


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
    public function definition(): array
    {
        $names=[
        'Beverages',
        'Snacks',
        'Dairy',
        'Bakery',
        'Frozen Foods',
        'Produce',
        'Meat & Poultry',
        'Seafood',
        'Pantry',
        'Personal Care',
        'Household Supplies',
        'Health & Wellness',
        'Baby Products',
        'Pet Supplies',
        'Electronics',
        'Stationery',
        'Cold Beverages',
        'Cigarettes & Tobacco',
        'Prepared Foods',
        'Hot Beverages',
        ];
        return [
            'name'=>fake()->unique()->randomElement($names),
            'status'=>fake()->randomElement(CategoryStatusEnum::cases())
        ];
    }
}
