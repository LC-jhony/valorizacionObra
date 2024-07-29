<?php

namespace App\Models;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialMovement extends Model
{
    use HasFactory;
    protected $fillable = [
        'material_id',
        'movement_id',
        'quantity',
        'created_at',
    ];
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
    public function movement(): BelongsTo
    {
        return $this->belongsTo(Movement::class);
    }
}
