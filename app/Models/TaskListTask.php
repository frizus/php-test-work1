<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TaskListTask extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'task_list_id',
        'sort',
        'name',
        'image',
    ];

    public function taskList(): BelongsTo
    {
        return $this->belongsTo(TaskList::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 150, 150)
            ->nonQueued();
    }

    public function scopeOfUser(Builder $query, string | int | null $userId = null)
    {
        $query->where('user_id', $userId ?? auth()->id());
    }

    public static function nextSort(): int | null
    {
        $maxSort = TaskListTask::query()
            ->ofUser()
            ->orderBy('sort', 'desc')
            ->limit(1)
            ->select('sort')
            ?->first()
            ->sort ?? 0;
        return $maxSort + 1;
    }
}
