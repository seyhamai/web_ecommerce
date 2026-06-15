<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasShortId
{
    protected static function bootHasShortId()
    {
        static::creating(function (Model $model) {
            if (empty($model->public_id)) {
                $code = Str::random(8);

                // Use newQuery() to satisfy the IDE's strict builder rules
                while ($model->newQuery()->where('public_id', $code)->exists()) {
                    $code = Str::random(8);
                }

                $model->public_id = $code;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'public_id';
    }
}
