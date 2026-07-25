<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['total'];

    // Una venta tiene muchos renglones de detalle
    public function details(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }
}
