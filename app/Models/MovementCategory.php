<?php

namespace App\Models;

use App\Enums\MovementCategoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovementCategory extends Model
{
    use HasFactory, SoftDeletes;

    public const string TRANSFER_CATEGORY_NAME = 'Transfer';

    public const string TRANSFER_CATEGORY_ICON = 'transfer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'is_default',
        'type',
        'name',
        'icon',
    ];

    /**
     * The attributes that must be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'user',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => MovementCategoryType::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
