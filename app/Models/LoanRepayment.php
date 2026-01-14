<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanRepayment extends Model
{
    protected $fillable = [
        'loan_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Get the loan that owns the repayment.
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
