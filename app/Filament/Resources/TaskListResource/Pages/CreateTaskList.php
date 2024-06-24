<?php

namespace App\Filament\Resources\TaskListResource\Pages;

use App\Filament\Resources\TaskListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateTaskList extends CreateRecord
{
    protected static string $resource = TaskListResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    public function getTitle(): string | Htmlable
    {
        $title = parent::getTitle();
        $title .= ' (нажмите ' . __('filament-panels::resources/pages/create-record.form.actions.create.label') . ', чтобы добавлялись задачи)';
        return $title;
    }
}
