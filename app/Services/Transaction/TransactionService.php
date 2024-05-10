<?php

namespace App\Services\Transaction;

use App\Dto\Transaction\CreateTransactionData;
use App\Dto\Transaction\CreateTransferData;
use App\Enums\MovementCategoryType;
use App\Exceptions\Account\InsufficientFundsException;
use App\Models\Account;
use App\Models\Transaction;
use App\Services\Account\AccountCalculationService;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function __construct(
        private readonly AccountCalculationService $accountCalculationService,
    ) {
    }

    /**
     * @throws InsufficientFundsException
     */
    public function create(CreateTransactionData $data): Transaction
    {
        $account = $data->account;

        $transaction = new Transaction([
            ...$data->toArray(),
            'account_id' => $account->id,
            'movement_category_id' => $data->movementCategory->id,
        ]);
        $account = $this->updateAccountBalance($account, $data);

        return DB::transaction(function () use ($transaction, $account) {
            $transaction->save();
            $account->save();

            return $transaction;
        });
    }

    /**
     * @throws InsufficientFundsException
     */
    public function update(Transaction $transaction, CreateTransactionData $data): Transaction
    {
        $oldAccount = $transaction->account;
        $this->accountCalculationService->rollback(
            $oldAccount->balance,
            $transaction->movementCategory->type == MovementCategoryType::INCOME ? $transaction->in_amount : $transaction->out_amount,
            $transaction->movementCategory->type,
        );

        $account = $data->account;
        $transaction->fill([
            ...$data->toArray(),
            'account_id' => $account->id,
            'movement_category_id' => $data->movementCategory->id,
        ]);
        $account = $this->updateAccountBalance($account, $data);

        return DB::transaction(function () use ($transaction, $oldAccount, $account) {
            $transaction->save();
            $oldAccount->save();
            $account->save();

            return $transaction;
        });
    }

    public function delete(Transaction $transaction): void
    {
        //        $relatedTransaction = $transaction->relatedTransaction;
        //        if (is_null($relatedTransaction)) {
        //            Transaction::query()
        //                ->where('related_transaction_id', $transaction->id)
        //                ->first();
        //        }
        //
        //        DB::transaction(function () use ($transaction, $relatedTransaction) {
        //            $transaction->delete();
        //            $relatedTransaction->delete();
        //        });
    }

    /**
     * Get the amount for an account based on the transaction data.
     *
     * @param  CreateTransactionData  $data  The transaction data.
     * @return int|float The amount for the account.
     */
    private function getAmountForAccount(CreateTransactionData $data): int|float
    {
        return $data->movementCategory->type == MovementCategoryType::INCOME ? $data->inAmount : $data->outAmount;
    }

    /**
     * Update the balance of an account based on the transaction data.
     *
     * @param  Account  $account  The account to update.
     * @param  CreateTransactionData  $data  The transaction data.
     * @return Account The updated account.
     *
     * @throws InsufficientFundsException If the account balance is insufficient.
     */
    private function updateAccountBalance(Account $account, CreateTransactionData $data): Account
    {
        $account->balance = $this->accountCalculationService->calculate(
            balance: $account->balance,
            amount: $this->getAmountForAccount($data),
            type: $data->movementCategory->type,
        );

        return $account;
    }

    public function transfer(CreateTransferData $data): Transaction
    {

    }
}
