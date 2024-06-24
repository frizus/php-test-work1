<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskListResource\Pages;
use App\Filament\Resources\TaskListResource\RelationManagers;
use App\Models\TaskList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TaskListResource extends Resource
{
    protected static ?string $model = TaskList::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->withCount('taskListTasks');
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                // костыль
                Tables\Columns\TextColumn::make('user.email')
                    ->visible(auth()->user()->isSuperAdmin()),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('task_list_tasks_count')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TaskListTasksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaskLists::route('/'),
            'create' => Pages\CreateTaskList::route('/create'),
            'edit' => Pages\EditTaskList::route('/{record}/edit'),
        ];
    }

    // костыль
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->isSuperAdmin()) {
            return $query;
        }

        return $query->ofUser();
    }
}
