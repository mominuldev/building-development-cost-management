<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StructureCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'structure_type',
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

        static::saving(function ($structure) {
            if ($structure->quantity && $structure->unit_price) {
                $structure->total_cost = $structure->quantity * $structure->unit_price;
            }
        });
    }
}
