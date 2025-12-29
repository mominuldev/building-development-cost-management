<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'material_type',
        'name',
        'quantity',
        'unit',
        'unit_price',
        'total_cost',
        'purchase_date',
        'supplier',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($material) {
            if ($material->quantity && $material->unit_price) {
                $material->total_cost = $material->quantity * $material->unit_price;
            }
        });
    }
}
