<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use App\Models\Facility;
use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->with('group', 'facility');
    }

    public static function form(Form $form): Form
{
    
    $form->schema([
        Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
        Forms\Components\TextInput::make('consumption'),
        Forms\Components\Select::make('group_id')
            ->label('Group')
            ->required()
            ->options(Group::all()->pluck('name', 'id')->toArray())
            ->reactive()
            ->afterStateUpdated(fn (callable $set) => $set('facility_id', null))
            ->hidden(!auth()->user()->is_admin),
        Forms\Components\Select::make('facility_id')
            ->label('Facility')
            ->options(function (callable $get){
                $group = Group::find($get('group_id'));
                if(!$group){
                    return Facility::all()->pluck('name', 'id');
                }
                return $group->facilities->pluck('name', 'id');
            })
            ->hidden(!auth()->user()->is_admin),
        Forms\Components\Select::make('facility_id')
            ->relationship('facility', 'name', function (Builder $query) {
                return $query->where('group_id', Auth::user()->group_id);
            })  
            ->hidden(auth()->user()->is_admin), 
    ]);

    return $form;
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('consumption')
                    ->sortable()
                    ->placeholder('not set'),
                Tables\Columns\TextColumn::make('facility.name')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                    // ->hidden(!auth()->user()->is_admin),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->hidden((!auth()->user()->is_admin) || (!auth()->user()->is_owner)),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }    
}