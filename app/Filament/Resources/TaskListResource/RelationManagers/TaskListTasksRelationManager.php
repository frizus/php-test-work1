<?php

namespace App\Filament\Resources\TaskListResource\RelationManagers;

use App\Models\Tag;
use App\Models\TaskListTask;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                    ->collection(TaskListTask::MEDIA_COLLECTION),
                Forms\Components\SpatieTagsInput::make('tags')
                    ->type(Tag::taskListTasksTypeOfUser())

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->ofUser())
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort')
                    ->sortable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->collection(TaskListTask::MEDIA_COLLECTION)
                    ->conversion('preview')
                    ->width(150)
                    ->height('auto')
                    ->url(function(TaskListTask $record) {
                        /** @var Media $media */
                        $media = $record->getRelationValue('media')?->first;
                        return $media?->getUrl()?->original_url;
                    }, true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SpatieTagsColumn::make('tags')
                    ->type(Tag::taskListTasksTypeOfUser())
            ])
            ->filters([
                // https://v2.filamentphp.com/tricks/filter-by-multiple-spatie-tags
                Tables\Filters\SelectFilter::make('tags')
                    ->multiple()
                    ->options(Tag::getWithType(Tag::taskListTasksTypeOfUser())->pluck('name', 'name'))
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['values'], function (Builder $query, $data): Builder {
                            return $query->withAnyTags(array_values($data), Tag::taskListTasksTypeOfUser());
                        });
                    })
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        $data['sort'] = TaskListTask::nextSort();

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
