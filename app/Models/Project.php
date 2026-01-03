<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'estimated_budget',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'estimated_budget' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function contractorCosts(): HasMany
    {
        return $this->hasMany(LaborCost::class);
    }

    public function structureCosts(): HasMany
    {
        return $this->hasMany(StructureCost::class);
    }

    public function finishingWorks(): HasMany
    {
        return $this->hasMany(FinishingWork::class);
    }

    public function expenseTrackings(): HasMany
    {
        return $this->hasMany(ExpenseTracking::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getTotalMaterialCostAttribute(): float
    {
        return (float) $this->materials()->sum('total_cost');
    }

    public function getTotalLaborCostAttribute(): float
    {
        $manualCosts = (float) $this->contractorCosts()->manualEntry()->sum('total_cost');
        $attendanceCosts = $this->attendance_based_labor_cost;

        return $manualCosts + $attendanceCosts;
    }

    public function getAttendanceBasedLaborCostAttribute(): float
    {
        return (float) $this->contractorCosts()
            ->attendanceBased()
            ->get()
            ->sum(function ($laborCost) {
                return $laborCost->actual_total_cost;
            });
    }

    public function getTotalStructureCostAttribute(): float
    {
        return (float) $this->structureCosts()->sum('total_cost');
    }

    public function getTotalFinishingCostAttribute(): float
    {
        return (float) $this->finishingWorks()->sum('total_cost');
    }

    public function getTotalExpenseAttribute(): float
    {
        return (float) $this->expenseTrackings()->sum('amount');
    }

    public function getTotalProjectCostAttribute(): float
    {
        return $this->total_material_cost
            + $this->total_labor_cost
            + $this->total_structure_cost
            + $this->total_finishing_cost;
    }

    public function getBudgetRemainingAttribute(): float
    {
        return $this->estimated_budget - $this->total_project_cost;
    }

    public function getBudgetUsagePercentageAttribute(): float
    {
        if ($this->estimated_budget == 0) {
            return 0;
        }
        return ($this->total_project_cost / $this->estimated_budget) * 100;
    }

    public function getTotalWorkersAttribute(): int
    {
        return $this->workers()->active()->count();
    }

    public function getTotalPresentTodayAttribute(): int
    {
        return $this->attendances()
            ->whereDate('attendance_date', today())
            ->whereIn('status', ['present', 'overtime'])
            ->count();
    }

    // Payment tracking
    public function getTotalContractorPaymentsAttribute(): float
    {
        return (float) $this->payments()->toContractors()->sum('amount');
    }

    public function getTotalWorkerPaymentsAttribute(): float
    {
        return (float) $this->payments()->toWorkers()->sum('amount');
    }

    public function getTotalPaymentsMadeAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }
}
