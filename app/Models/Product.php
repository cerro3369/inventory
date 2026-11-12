<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'titulo',
    ];

    /**
     * Un producto base tiene muchas ediciones/tomos en inventario.
     */
    public function editions(): HasMany
    {
        return $this->hasMany(Edition::class);
    }
}