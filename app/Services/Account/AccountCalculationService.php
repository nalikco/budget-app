<?php

namespace App\Services\Account;

use App\Enums\MovementCategoryType;
use App\Exceptions\Account\InsufficientFundsException;

class AccountCalculationService
{
    /**
     * Calculates the new balance based on the given balance, amount, and type of movement.
     *
     * @param  int|float  $balance  The current balance.
     * @param  int|float  $amount  The amount to add or subtract from the balance.
     * @param  MovementCategoryType  $type  The type of movement.
     * @return int|float The new balance after adding or subtracting the amount.
     *
     * @throws InsufficientFundsException If the amount is greater than the balance for OUTCOME movement type.
     */
    public function calculate(int|float $balance, int|float $amount, MovementCategoryType $type): int|float
    {
        if ($type == MovementCategoryType::INCOME) {
            return $this->add($balance, $amount);
        } elseif ($type == MovementCategoryType::OUTCOME) {
            return $this->sub($balance, $amount);
        }

        return $balance;
    }

    /**
     * Rollbacks the balance based on the given amount and type of movement.
     *
     * @param  int|float  $balance  The current balance.
     * @param  int|float  $amount  The amount to rollback from the balance.
     * @param  MovementCategoryType  $type  The type of movement.
     * @return int|float The new balance after rollback the amount.
     *
     * @throws InsufficientFundsException If the amount is greater than the balance for OUTCOME movement type.
     */
    public function rollback(int|float $balance, int|float $amount, MovementCategoryType $type): int|float
    {
        if ($type == MovementCategoryType::INCOME) {
            return $this->sub($balance, $amount);
        } elseif ($type == MovementCategoryType::OUTCOME) {
            return $this->add($balance, $amount);
        }

        return $balance;
    }

    /**
     * Adds the given amount to the balance and returns the new balance.
     *
     * @param  int|float  $balance  The current balance.
     * @param  int|float  $amount  The amount to add to the balance.
     * @return int|float The new balance after adding the amount.
     */
    private function add(int|float $balance, int|float $amount): int|float
    {
        return $balance + $amount;
    }

    /**
     * Subtracts the given amount from the balance and throws an exception if the amount is greater than the balance.
     *
     * @param  int|float  $balance  The current balance.
     * @param  int|float  $amount  The amount to subtract from the balance.
     * @return int|float The new balance after subtracting the amount.
     *
     * @throws InsufficientFundsException If the amount is greater than the balance.
     */
    private function sub(int|float $balance, int|float $amount): int|float
    {
        if ($amount > $balance) {
            throw new InsufficientFundsException();
        }

        return $balance - $amount;
    }
}
