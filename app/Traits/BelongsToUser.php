<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @method static void creating(\Closure|string $callback)
 * @method static mixed addGlobalScope(string $scope, \Closure|\Illuminate\Database\Eloquent\Scope $implementation)
 */
trait BelongsToUser
{
    /**
     * Boot del Trait para aplicar Global Scope y asignación automática al crear.
     *
     * @return void
     */
    protected static function bootBelongsToUser()
    {
        // 1. Asignar automáticamente el user_id al crear un registro
        static::creating(function (Model $model) {
            if (Auth::check() && empty($model->getAttribute('user_id'))) {
                $model->setAttribute('user_id', Auth::id());
            }
        });

        // 2. Global Scope: Filtrar todas las consultas por el usuario en sesión
        static::addGlobalScope('user_id', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where($builder->getModel()->getTable() . '.user_id', Auth::id());
            }
        });
    }

    /**
     * Relación Eloquent con el Modelo User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}