<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\TaskList;
use App\Models\TaskListTask;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superAdminRoleId = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ])->id;

        $simpleRole = Role::create([
            'name' => 'User',
            'guard_name' => 'web',
        ]);

        $simpleRole->givePermissionTo([
            'view-any TaskList',
            'view TaskList',
            'create TaskList',
            'update TaskList',
            'delete TaskList',
            'force-delete TaskList',
            'view-any TaskListTask',
            'view TaskListTask',
            'create TaskListTask',
            'update TaskListTask',
            'delete TaskListTask',
            'force-delete TaskListTask',
            'reorder TaskListTask',
        ]);

        $simpleRoleId = $simpleRole->id;

        $superUser = User::factory()
            ->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => '123456',
            ]);

        $superUser->assignRole($superAdminRoleId);

        $userIds = [];

        $simpleUser = User::factory()
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => '123456',
            ]);

        $simpleUser->assignRole($simpleRoleId);

        $userIds[] = $simpleUser->id;

        $simpleUser = User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => '123456',
        ]);

        $simpleUser->assignRole($simpleRoleId);

        $userIds[] = $simpleUser->id;

        TaskList::factory(4)
            ->state(new Sequence(
                ...(collect($userIds)->map(fn($value) => ['user_id' => $value])->toArray())
            ))
            ->create()
            ->each(function(TaskList $taskList) {
                TaskListTask::factory(rand(2, 5))
                    ->create([
                        'task_list_id' => $taskList->id,
                        'user_id' => $taskList->user_id,
                    ])
                    ->each(function(TaskListTask $taskListTask) {
                        $i = $taskListTask->user_id;
                        $taskListTask->attachTags(fake()->randomElements(['first' . $i, 'second' . $i, 'third' . $i], rand(2, 3)), Tag::taskListTasksTypeOfUser($taskListTask->user_id));

                        //$dir = config('filesystems.disks.' . config('filament.default_filesystem_disk') . '.root');
                        if ($image = fake()->image()) {
                            $taskListTask->addMedia($image)
                                ->toMediaCollection(TaskListTask::MEDIA_COLLECTION);
                        }
                    });
            });
    }
}
