<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function (Model $model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected static function getModelEvents()
    {
        return ['created', 'updated', 'deleted'];
    }

    public function logActivity($event)
    {
        ActivityLog::create([
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'event' => $event,
            'description' => $this->getActivityDescription($event),
            'properties' => $this->getActivityProperties($event),
            'causer_type' => auth()->check() ? get_class(auth()->user()) : null,
            'causer_id' => auth()->check() ? auth()->id() : null,
        ]);
    }

    protected function getActivityDescription($event)
    {
        $modelName = class_basename($this);

        return match ($event) {
            'created' => "Created {$modelName}",
            'updated' => "Updated {$modelName}",
            'deleted' => "Deleted {$modelName}",
            default => "Performed action on {$modelName}",
        };
    }

    protected function getActivityProperties($event)
    {
        $properties = [];

        if ($event === 'updated') {
            $properties['old'] = collect($this->getOriginal())->except($this->getHidden());
            $properties['attributes'] = collect($this->getChanges())->except($this->getHidden());
        } else {
            $properties['attributes'] = collect($this->getAttributes())->except($this->getHidden());
        }

        return $properties;
    }
}
