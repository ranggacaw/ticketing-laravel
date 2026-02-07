<?php

namespace App\Traits;

use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            ActivityLogger::log('CREATE', $model, $model->toArray(), 'Created ' . class_basename($model));
        });

        static::updated(function (Model $model) {
            $changes = $model->getChanges();
            // Remove updated_at from changes if it's the only change (e.g. only touched)
            if (count($changes) === 1 && array_key_exists('updated_at', $changes)) {
                return;
            }

            $original = $model->getOriginal();
            
            $metadata = [
                'before' => array_intersect_key($original, $changes),
                'after' => $changes,
            ];

            ActivityLogger::log('UPDATE', $model, $metadata, 'Updated ' . class_basename($model));
        });

        static::deleted(function (Model $model) {
            ActivityLogger::log('DELETE', $model, $model->toArray(), 'Deleted ' . class_basename($model));
        });
    }
}
