<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'recipient_nid',
        'amount',
        'loan_date',
        'payment_method',
        'transaction_reference',
        'status',
        'amount_repaid',
        'due_date',
        'interest_rate',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'amount_repaid' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'loan_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Get the project that owns the loan.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the repayments for the loan.
     */
    public function repayments(): HasMany
    {
        return $this->hasMany(LoanRepayment::class)->orderBy('payment_date', 'desc');
    }

    /**
     * Get the remaining balance of the loan.
     */
    public function getRemainingBalanceAttribute(): float
    {
        return max(0, $this->amount - $this->amount_repaid);
    }

    /**
     * Get the payment status text.
     */
    public function getPaymentStatusTextAttribute(): string
    {
        if ($this->status === 'paid') {
            return 'Fully Paid';
        } elseif ($this->status === 'partial') {
            return 'Partially Paid';
        }
        return 'Pending';
    }

    /**
     * Get the payment status color class.
     */
    public function getPaymentStatusColorAttribute(): string
    {
        if ($this->status === 'paid') {
            return 'success';
        } elseif ($this->status === 'partial') {
            return 'warning';
        }
        return 'error';
    }

    /**
     * Check if loan is overdue.
     */
    public function getIsOverdueAttribute(): bool
    {
        if (!$this->due_date || $this->status === 'paid') {
            return false;
        }
        return $this->due_date->isPast();
    }

    /**
     * Update loan status based on amount repaid.
     */
    public function updateStatus(): void
    {
        if ($this->amount_repaid >= $this->amount) {
            $this->status = 'paid';
        } elseif ($this->amount_repaid > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'pending';
        }
        $this->saveQuietly();
    }

    /**
     * Scope to get pending loans.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get partially paid loans.
     */
    public function scopePartial($query)
    {
        return $query->where('status', 'partial');
    }

    /**
     * Scope to get paid loans.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope to get overdue loans.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->where('status', '!=', 'paid');
    }
}
