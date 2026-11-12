<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'total',
    ];

    /**
     * Una venta tiene muchos detalles de productos.
     */
    public function details(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Relación con el usuario/cajero que realizó la venta.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}