<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'worker_id',
        'labor_cost_id',
        'attendance_date',
        'status',
        'hours_worked',
        'wage_amount',
        'notes',
        'work_description',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'hours_worked' => 'decimal:2',
        'wage_amount' => 'decimal:2',
    ];

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function laborCost(): BelongsTo
    {
        return $this->belongsTo(LaborCost::class);
    }

    // Auto-calculate wage based on status
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            $worker = $attendance->worker;
            if (!$worker) return;

            $dailyWage = $worker->daily_wage;

            // Calculate wage based on attendance status
            switch ($attendance->status) {
                case 'present':
                    $attendance->wage_amount = $dailyWage;
                    $attendance->hours_worked = $attendance->hours_worked ?? 8; // Standard work day
                    break;
                case 'half_day':
                    $attendance->wage_amount = $dailyWage / 2;
                    $attendance->hours_worked = $attendance->hours_worked ?? 4;
                    break;
                case 'overtime':
                    // Overtime: 1.5x daily wage
                    $attendance->wage_amount = $dailyWage * 1.5;
                    $attendance->hours_worked = $attendance->hours_worked ?? 10;
                    break;
                case 'absent':
                case 'leave':
                case 'holiday':
                    $attendance->wage_amount = 0;
                    $attendance->hours_worked = 0;
                    break;
            }
        });

        static::created(function ($attendance) {
            if ($attendance->labor_cost_id) {
                $attendance->updateLaborCostTotal();
            }
        });

        static::updated(function ($attendance) {
            if ($attendance->labor_cost_id) {
                $attendance->updateLaborCostTotal();
            }
        });

        static::deleted(function ($attendance) {
            if ($attendance->labor_cost_id) {
                $attendance->updateLaborCostTotal();
            }
        });
    }

    public function updateLaborCostTotal(): void
    {
        if (!$this->labor_cost_id) return;

        $laborCost = LaborCost::find($this->labor_cost_id);
        if (!$laborCost) return;

        // Recalculate total from all attendances linked to this labor cost
        $total = Attendance::where('labor_cost_id', $laborCost->id)
            ->sum('wage_amount');

        $laborCost->calculated_total = $total;
        $laborCost->saveQuietly(); // Save without triggering events
    }

    // Scopes
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('attendance_date', $date);
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('attendance_date', [$startDate, $endDate]);
    }

    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }
}
