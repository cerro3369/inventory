<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id', 
        'edition_id', 
        'cantidad', 
        'precio_unitario',
    ];

    /**
     * Un detalle de venta pertenece a una venta cabecera.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Un detalle de venta está asociado a una edición específica.
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }

    /**
     * Atributo calculado para obtener el subtotal del renglón.
     */
    public function getSubtotalAttribute(): float
    {
        return (float) ($this->cantidad * $this->precio_unitario);
    }
}