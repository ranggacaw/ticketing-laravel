<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log a user activity.
     *
     * @param string $action
     * @param Model|null $resource
     * @param array $metadata
     * @param string|null $description
     * @return ActivityLog
     */
    public static function log(string $action, ?Model $resource = null, array $metadata = [], ?string $description = null)
    {
        $log = new ActivityLog();
        $log->user_id = Auth::id();
        $log->action = $action;
        
        if ($resource) {
            $log->resource_type = get_class($resource);
            $log->resource_id = $resource->getKey();
        }

        $log->metadata = $metadata;
        $log->description = $description;
        $log->ip_address = Request::ip();
        $log->user_agent = Request::userAgent();
        
        $log->save();

        return $log;
    }
}
