<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TaskList;
use App\Models\User;

class TaskListPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any TaskList');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaskList $tasklist): bool
    {
        return $user->checkPermissionTo('view TaskList') &&
            ($user->id === $tasklist->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create TaskList');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskList $tasklist): bool
    {
        return $user->checkPermissionTo('update TaskList') &&
            ($user->id === $tasklist->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskList $tasklist): bool
    {
        return $user->checkPermissionTo('delete TaskList') &&
            ($user->id === $tasklist->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TaskList $tasklist): bool
    {
        return $user->checkPermissionTo('restore TaskList') &&
            ($user->id === $tasklist->user_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TaskList $tasklist): bool
    {
        return $user->checkPermissionTo('force-delete TaskList') &&
            ($user->id === $tasklist->user_id);
    }
}
