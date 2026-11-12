<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Waste extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'edition_id',
        'cantidad',
        'tipo_baja',
        'notas',
    ];

    /**
     * Relación con la edición de cómic o coleccionable.
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }
}