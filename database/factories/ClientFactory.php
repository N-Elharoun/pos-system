<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ClientRegistrationEnum;
use App\Enums\ClientStatusEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'status' => $this->faker->randomElement([ClientStatusEnum::Active, ClientStatusEnum::Inactive]),
            'registered_via' => $this->faker->randomElement([ClientRegistrationEnum::Pos,ClientRegistrationEnum::App]),
        ];
    }
}
