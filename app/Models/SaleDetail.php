<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'edition_id', 'cantidad', 'precio_unitario'];

    // Pertenece a una venta
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    // Está asociado a una edición
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }
}
