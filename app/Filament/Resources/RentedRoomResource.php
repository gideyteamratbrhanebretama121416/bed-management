<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentedRoomResource\Pages;
use App\Filament\Resources\RentedRoomResource\RelationManagers;
use App\Models\RentedRoom;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RentedRoomResource extends Resource
{
    protected static ?string $model = RentedRoom::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('room_id')
                    ->label('Room')
                    ->options(Room::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('customer_name')
                    ->label('Customer name')
                    ->required(),
                TextInput::make('id_number')
                    ->label('Id number')
                    ->required(),
                TextInput::make('id_image')
                    ->label('Id image')
                    ->required(),
                DatePicker::make('rented_date')
                    ->label('Rented date')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')->label('Customer name'),
                TextColumn::make('rented_date')->label('Rented date'),
                TextColumn::make('id_number')->label('Id number'),
                TextColumn::make('id_image')->label('Id image'),
                TextColumn::make('room.floor.building.name')->label('Building'),
                TextColumn::make('room.floor.name')->label('Floor'),
                TextColumn::make('room.name')->label('Room')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListRentedRooms::route('/'),
            'create' => Pages\CreateRentedRoom::route('/create'),
            'edit' => Pages\EditRentedRoom::route('/{record}/edit'),
        ];
    }    
}
