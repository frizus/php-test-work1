<?php

namespace App\Filament\Resources\TaskListResource\RelationManagers;

use App\Models\TaskListTask;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TaskListTasksRelationManager extends RelationManager
{
    protected static string $relationship = 'taskListTasks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort')
                    ->default(fn() => TaskListTask::nextSort() ?? 0),
                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                    ->collection('task_list_task')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->ofUser())
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('sort'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->collection('task_list_task')
                    ->conversion('preview')
                    ->width(150)
                    ->height('auto')
                    ->url(function(TaskListTask $record) {
                        /** @var Media $media */
                        $media = $record->getRelationValue('media')?->first;
                        return $media?->getUrl()?->original_url;
                    }, true),
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort');
    }
}
