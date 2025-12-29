<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'labor_cost_id',
        'primary_contractor_id',
        'name',
        'phone',
        'email',
        'address',
        'labor_type',
        'category',
        'daily_wage',
        'is_active',
        'hire_date',
        'terminate_date',
        'notes',
    ];

    protected $casts = [
        'daily_wage' => 'decimal:2',
        'is_active' => 'boolean',
        'hire_date' => 'date',
        'terminate_date' => 'date',
    ];

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function laborCost(): BelongsTo
    {
        return $this->belongsTo(LaborCost::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function primaryContractor(): BelongsTo
    {
        return $this->belongsTo(LaborCost::class, 'primary_contractor_id');
    }

    public function contractors(): BelongsToMany
    {
        return $this->belongsToMany(LaborCost::class, 'contractor_worker', 'worker_id', 'contractor_id')
            ->withPivot('assigned_date', 'removed_date', 'is_active', 'notes')
            ->wherePivot('is_active', true)
            ->withTimestamps();
    }

    // Payment tracking
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'recipient');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByLaborType($query, $type)
    {
        return $query->where('labor_type', $type);
    }

    // Accessors & Helpers
    public function getTotalDaysWorkedAttribute(): int
    {
        return $this->attendances()
            ->whereIn('status', ['present', 'overtime'])
            ->count();
    }

    public function getTotalWagesEarnedAttribute(): float
    {
        return (float) $this->attendances()->sum('wage_amount');
    }

    public function getAttendancePercentageAttribute(): float
    {
        $totalDays = $this->attendances()->count();
        if ($totalDays === 0) return 0;

        $presentDays = $this->attendances()
            ->whereIn('status', ['present', 'overtime'])
            ->count();

        return ($presentDays / $totalDays) * 100;
    }

    public function getIsPresentTodayAttribute(): bool
    {
        return $this->attendances()
            ->whereDate('attendance_date', today())
            ->whereIn('status', ['present', 'overtime'])
            ->exists();
    }

    // Payment tracking
    public function getTotalPaymentsReceivedAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getAmountDueAttribute(): float
    {
        return max(0, $this->total_wages_earned - $this->total_payments_received);
    }

    public function getPaymentStatusAttribute(): string
    {
        $due = $this->amount_due;

        if ($due == 0 && $this->total_wages_earned > 0) {
            return 'paid';
        } elseif ($this->total_payments_received > 0) {
            return 'partial';
        } else {
            return 'pending';
        }
    }
}
