<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers;
use App\Filament\Resources\GroupResource\RelationManagers\UsersRelationManager;
use App\Models\Group;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    
    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    // public static function getEloquentQuery(): Builder
    // {
    //     return static::getModel()::query()->with('User');
    // }
    // protected static function getNavigationGroup(): ?string
    // {
    //     $groupId = Auth::user()->group_id;
    //     $group = Group::where('id', $groupId)->first();
    //     $groupName = $group->name;
    //     return $groupName;
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('users_count')->counts('users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('facilities_count')->counts('facilities')
                    ->sortable(),
                Tables\Columns\TextColumn::make('devices_count')->counts('devices')
                    ->sortable(),

// HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHEELP
// ->query(function (Group $group) {
// return User::where('group_id', $group('id'))->count();
// })

// Tables\Columns\TextColumn::make('created_at')
// ->dateTime(),
// Tables\Columns\TextColumn::make('updated_at')
// ->dateTime(),
])
->filters([
//
])
->actions([
Tables\Actions\EditAction::make(),
])
->bulkActions([
Tables\Actions\DeleteBulkAction::make(),
]);
}

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

public static function getPages(): array
{
return [
'index' => Pages\ListGroups::route('/'),
'create' => Pages\CreateGroup::route('/create'),
'edit' => Pages\EditGroup::route('/{record}/edit'),
];
}
}