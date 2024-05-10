<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\MovementCategory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class FakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(50)
            ->has(Account::factory(5))
            ->has(MovementCategory::factory(5))
            ->create();

        $users->each(function (User $user) {
            $movementCategories = $user->movementCategories;
            $accounts = $user->accounts;

            for ($i = 1; $i <= fake()->numberBetween(5, 20); $i++) {
                Transaction::factory()->create([
                    'movement_category_id' => $movementCategories->random()->id,
                    'account_id' => $accounts->random()->id,
                ]);
            }
        });
    }
}
