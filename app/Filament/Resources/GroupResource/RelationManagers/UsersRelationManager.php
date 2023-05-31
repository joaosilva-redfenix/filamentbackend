<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\User;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    protected static ?string $inverseRelationship = 'group';

    protected static ?string $recordTitleAttribute = 'name';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(static fn (null|string $state): null|string => filled($state) ? Hash::make($state) : null,)->required()
                    ->dehydrated(static fn(null|string $state): bool => filled($state),)
                    ->label('Password'),
                // Forms\Components\Select::make('group_id')
                //     ->relationship('group', 'name'),
                // Toggle::make('is_owner')
                //     ->label('Owner')
                //     ->onIcon('heroicon-s-user')
                //     ->offIcon('heroicon-s-user')
                //     ->onColor('success')
                //     ->offColor('danger'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AssociateAction::make()
                    ->hidden(!auth()->user()->is_admin)
                    ->recordSelectOptionsQuery(fn ($query) => $query->where('group_id', null))
                    ->disableAssociateAnother()
                    ->preloadRecordSelect(),
            ])  
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(auth()->user()->is_admin),
                Tables\Actions\DissociateAction::make()
                    ->hidden(!auth()->user()->is_admin),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DissociateBulkAction::make(),
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}