<?php

use App\Models\Account;
use App\Models\MovementCategory;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Account::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(MovementCategory::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->decimal('out_amount', 15);
            $table->decimal('in_amount', 15);
            $table->timestamp('date');
            $table->string('description')->nullable();
            $table->foreignIdFor(Transaction::class, 'related_transaction_id')
                ->nullable()
                ->unique()
                ->constrained('transactions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
