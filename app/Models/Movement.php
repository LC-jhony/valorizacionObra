<?php

namespace App\Models;

use App\Models\MaterialMovement;
use App\Models\OrderParchuse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'order_id',
        'created_at',
    ];

    public function movementproduct(): HasMany
    {
        return $this->hasMany(MaterialMovement::class);
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(
            related: OrderParchuse::class,
            foreignKey: 'order_id',
        );
    }
}
