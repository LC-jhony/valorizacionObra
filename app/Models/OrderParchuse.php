<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderParchuse extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'status',
    ];
    public function materials(): HasMany
    {
        return $this->hasMany(
            related: Material::class,
            foreignKey: 'order_id'
        );
    }
}
