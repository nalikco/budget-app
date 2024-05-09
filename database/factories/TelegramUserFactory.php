<?php

namespace Database\Factories;

use App\Models\TelegramUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TelegramUser>
 */
class TelegramUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'telegram_id' => rand(1000000, 99999999),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->userName(),
            'language_code' => $this->faker->languageCode(),
            'allows_write_to_pm' => $this->faker->boolean(),
        ];
    }
}
