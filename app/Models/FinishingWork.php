<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinishingWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'work_type',
        'name',
        'description',
        'quantity',
        'unit',
        'unit_price',
        'total_cost',
        'work_date',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'work_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($finishing) {
            if ($finishing->quantity && $finishing->unit_price) {
                $finishing->total_cost = $finishing->quantity * $finishing->unit_price;
            }
        });
    }
}
