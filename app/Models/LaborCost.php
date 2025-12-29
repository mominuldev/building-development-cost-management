<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaborCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'labor_type',
        'name',
        'category',
        'number_of_workers',
        'daily_wage',
        'days_worked',
        'total_cost',
        'work_date',
        'description',
        'notes',
        'is_attendance_based',
        'calculated_total',
    ];

    protected $casts = [
        'number_of_workers' => 'integer',
        'daily_wage' => 'decimal:2',
        'days_worked' => 'integer',
        'total_cost' => 'decimal:2',
        'work_date' => 'date',
        'is_attendance_based' => 'boolean',
        'calculated_total' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function contractorWorkers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'contractor_worker', 'contractor_id', 'worker_id')
            ->withPivot('assigned_date', 'removed_date', 'is_active', 'notes')
            ->wherePivot('is_active', true)
            ->withTimestamps();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    // For contractors: get number of assigned workers
    public function getAssignedWorkersCountAttribute(): int
    {
        if ($this->labor_type === 'contractor') {
            return $this->contractorWorkers()->count();
        }
        return $this->number_of_workers ?? 0;
    }

    // For contractors: calculate total from assigned workers' attendance
    public function getCalculatedFromWorkersAttribute(): float
    {
        if ($this->labor_type !== 'contractor') {
            return 0;
        }

        // Sum all wages earned by assigned workers
        return $this->contractorWorkers()
            ->get()
            ->sum(function ($worker) {
                return $worker->total_wages_earned;
            });
    }

    // Dynamic total cost based on labor type
    public function getActualTotalCostAttribute(): float
    {
        if ($this->labor_type === 'contractor') {
            // For contractors, use calculated total from workers' attendance
            return (float) ($this->calculated_total ?? $this->calculated_from_workers);
        }

        // For other types, use the manual calculation or total_cost
        return $this->is_attendance_based
            ? (float) ($this->calculated_total ?? 0)
            : (float) $this->total_cost;
    }

    public function scopeAttendanceBased($query)
    {
        return $query->where('is_attendance_based', true);
    }

    public function scopeManualEntry($query)
    {
        return $query->where('is_attendance_based', false);
    }

    public function scopeContractors($query)
    {
        return $query->where('labor_type', 'contractor');
    }

    // Calculate total due for this contractor (based on linked workers' attendance)
    public function getTotalDueAttribute(): float
    {
        if ($this->labor_type !== 'contractor') {
            return 0;
        }

        return $this->contractorWorkers()
            ->get()
            ->sum(function ($worker) {
                return $worker->total_wages_earned - $worker->total_payments_received;
            });
    }

    // Calculate total payments received for this contractor
    public function getTotalPaymentsReceivedAttribute(): float
    {
        return (float) Payment::where('recipient_type', 'contractor')
            ->where('recipient_id', $this->id)
            ->sum('amount');
    }

    // Update calculated_total based on assigned workers
    public function updateCalculatedTotal()
    {
        if ($this->labor_type === 'contractor') {
            $this->calculated_total = $this->calculated_from_workers;
            $this->saveQuietly(); // Save without triggering boot events
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($labor) {
            // Only calculate total_cost for non-contractors (not attendance-based)
            if ($labor->labor_type !== 'contractor' && !$labor->is_attendance_based) {
                if ($labor->number_of_workers && $labor->daily_wage && $labor->days_worked) {
                    $labor->total_cost = $labor->number_of_workers * $labor->daily_wage * $labor->days_worked;
                }
            }
        });

        // When a contractor is saved, update calculated_total from workers
        static::saved(function ($labor) {
            if ($labor->labor_type === 'contractor') {
                $labor->updateCalculatedTotal();
            }
        });
    }
}
