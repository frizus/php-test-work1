<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TaskListTask;
use App\Models\User;

class TaskListTaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any TaskListTask');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaskListTask $tasklisttask): bool
    {
        return $user->checkPermissionTo('view TaskListTask') &&
            ($user->id === $tasklisttask->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create TaskListTask');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskListTask $tasklisttask): bool
    {
        return $user->checkPermissionTo('update TaskListTask') &&
            ($user->id === $tasklisttask->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskListTask $tasklisttask): bool
    {
        return $user->checkPermissionTo('delete TaskListTask') &&
            ($user->id === $tasklisttask->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TaskListTask $tasklisttask): bool
    {
        return $user->checkPermissionTo('restore TaskListTask') &&
            ($user->id === $tasklisttask->user_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TaskListTask $tasklisttask): bool
    {
        return $user->checkPermissionTo('force-delete TaskListTask') &&
            ($user->id === $tasklisttask->user_id);
    }
}
