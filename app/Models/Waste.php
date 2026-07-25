<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Waste extends Model
{
    protected $fillable = [
        'cantidad',
        'tipo_baja',
        'notas',
        'edition_id',
    ];

    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }
}
