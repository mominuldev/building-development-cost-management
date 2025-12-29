<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'recipient_type',
        'recipient_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'status',
        'notes',
        'period_start',
        'period_end',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Polymorphic relationship to get recipient (contractor or worker)
    public function recipient()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeToContractors($query)
    {
        return $query->where('recipient_type', 'contractor');
    }

    public function scopeToWorkers($query)
    {
        return $query->where('recipient_type', 'worker');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }
}
