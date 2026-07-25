<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Edition extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'numero_edicion',
        'precio_compra',
        'precio_venta',
        'stock_actual',
        'product_id',
    ];

    // Ya lo tienes: Pertenece a un producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Una edición puede tener muchas mermas registradas
    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class);
    }

    // Una edición puede aparecer en muchos detalles de ventas
    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }
}
