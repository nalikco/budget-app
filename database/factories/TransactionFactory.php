<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\MovementCategory;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $accounts = Account::all();
        if ($accounts->isEmpty()) {
            $accounts->push(Account::factory()->create());
        }

        $movementCategories = MovementCategory::all();
        if ($movementCategories->isEmpty()) {
            $movementCategories->push(MovementCategory::factory()->create());
        }

        $transactions = Transaction::all();

        return [
            'account_id' => $accounts->random()->id,
            'movement_category_id' => $movementCategories->random()->id,
            'credit_amount' => $this->faker->randomFloat(2, 1, 10000),
            'debit_amount' => $this->faker->randomFloat(2, 1, 10000),
            'date' => $this->faker->dateTime(),
            'description' => $this->faker->randomElement([$this->faker->sentence(), null]),
            'related_transaction_id' => $transactions->isNotEmpty()
                ? $this->faker->randomElement([$transactions->random()->id, null, null, null])
                : null,
        ];
    }
}
