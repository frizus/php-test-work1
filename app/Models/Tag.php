<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Tag extends \Spatie\Tags\Tag
{
    public function scopeTaskListTasksOfUser(Builder $query, string | int | null $userId = null)
    {
        $this->withType(static::taskListTasksTypeOfUser($userId));
    }

    public static function taskListTasksTypeOfUser($userId = null)
    {
        return 'task_list_task_' . ($userId ?? auth()->id());
    }
}
