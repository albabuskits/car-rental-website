<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logAction('created');
        });

        static::updated(function ($model) {
            $model->logAction('updated');
        });

        static::deleted(function ($model) {
            $model->logAction('deleted');
        });
    }

    protected function logAction(string $action): void
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            return;
        }

        $label = $this->getActivityLabel();
        $description = $this->getActivityDescription($action);

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'subject_type' => get_class($this),
            'subject_id' => $this->getKey(),
            'subject_label' => $label,
            'description' => $description,
            'properties' => $this->getActivityProperties(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    protected function getActivityLabel(): string
    {
        if (method_exists($this, 'activityLabel')) {
            return $this->activityLabel();
        }
        return $this->getKey() ? '#' . $this->getKey() : 'new';
    }

    protected function getActivityDescription(string $action): string
    {
        $userName = Auth::user()->name;
        $modelName = class_basename($this);
        $label = $this->getActivityLabel();

        $map = [
            'created' => "{$userName} أضاف {$modelName} {$label}",
            'updated' => "{$userName} عدّل {$modelName} {$label}",
            'deleted' => "{$userName} حذف {$modelName} {$label}",
        ];

        return $map[$action] ?? "{$userName} قام بـ {$action} على {$modelName} {$label}";
    }

    protected function getActivityProperties(): ?array
    {
        if (method_exists($this, 'activityProperties')) {
            return $this->activityProperties();
        }
        return null;
    }
}
