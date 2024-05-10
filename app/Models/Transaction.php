<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'movement_category_id',
        'out_amount',
        'in_amount',
        'date',
        'description',
        'related_transaction_id',
    ];

    /**
     * The attributes that must be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'account',
        'movementCategory',
        'relatedTransaction',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function movementCategory(): BelongsTo
    {
        return $this->belongsTo(MovementCategory::class);
    }

    public function relatedTransaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'related_transaction_id');
    }
}
