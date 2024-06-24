<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;

class TaskList extends Model
{
    use HasFactory, HasTags;

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function taskListTasks(): HasMany
    {
        return $this->hasMany(TaskListTask::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfUser(Builder $query, string | int | null $userId = null)
    {
        $query->where('user_id', $userId ?? auth()->id());
    }
}
