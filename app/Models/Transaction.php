<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Available note constants
     */
    const AVAILABLE_NOTES = [100, 50, 20];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'user_id',
        'transaction_type_id',
        'amount',
    ];

    /**
     * Get the user that owns the bank account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the bank account.
     */
    public function type()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }
}
