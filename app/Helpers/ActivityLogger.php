<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $action, string $description, ?int $userId = null): void
    {
        $userId = $userId ?? Auth::id();

        if ($userId) {
            ActivityLog::create([
                'user_id' => $userId,
                'action' => $action,
                'description' => $description,
            ]);
        }
    }
}
