<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currencies = Currency::all();
        if ($currencies->isEmpty()) {
            $currencies->add(Currency::factory()->create());
        }

        return [
            'currency_id' => $currencies->random()->id,
            'username' => fake()->userName(),
            'remember_token' => Str::random(10),
        ];
    }
}
