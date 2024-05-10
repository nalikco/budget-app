<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $users->add(User::factory()->create());
        }

        $currencies = Currency::all();
        if ($currencies->isEmpty()) {
            $currencies->add(Currency::factory()->create());
        }

        return [
            'user_id' => $users->random()->id,
            'currency_id' => $currencies->random()->id,
            'name' => $this->faker->text(20),
            'balance' => $this->faker->randomFloat(2, 0, 1000),
            'icon' => $this->faker->randomElement(config('icons')),
        ];
    }
}
