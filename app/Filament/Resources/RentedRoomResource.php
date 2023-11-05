<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentedRoomResource\Pages;
use App\Filament\Resources\RentedRoomResource\RelationManagers;
use App\Models\Building;
use App\Models\RentedRoom;
use App\Models\Room;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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
                // Select::make('room_id')
                //     ->label('Room')
                //     ->options(Room::all()->pluck('name', 'id'))
                //     ->required(),
                TextInput::make('customer_name')
                    ->label('Customer name')
                    ->required(),
                TextInput::make('id_number')
                    ->label('Id number')
                    ->required(),
                FileUpload::make('id_image')->label('Id image'),
                DateTimePicker::make('rented_date')
                    ->label('Rented date')
                    ->default(now())
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room.name')->label('Room'),
                TextColumn::make('room.floor.name')->label('Floor'),
                TextColumn::make('room.floor.building.name')->label('Building'),
                TextColumn::make('room.price')->label('Price'),
                TextColumn::make('rented_date')->label('Rented date'),
                TextColumn::make('customer_name')->label('Customer name'),
                TextColumn::make('id_number')->label('Id number'),
            ])
            ->filters([
                Filter::make('building')
                ->form([
                    Select::make('building_id')->label('Building')->options(Building::all()->pluck('name', 'id')),
                    
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['building_id'],
                            fn (Builder $query, $date): Builder => $query->whereHas('room.floor.building', function ($query) use ($data) {
                                $query->where('building_id', $data);
                            }),
                        );
                })
                ->indicateUsing(function (array $data): array {
                    $indicators = [];
                    if (!$data['building_id']) {
                        return [];
                    }
                    if ($data['building_id'] ?? null) {
                        $indicators['building_id'] = 'Building; '.Building::findOrFail($data['building_id'])->name;
                    }
                    return $indicators;
                }),
                Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from'),
                        Forms\Components\DatePicker::make('date_to'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('rented_date', '>=', $date),
                            )
                            ->when(
                                $data['date_to'],
                                fn (Builder $query, $date): Builder => $query->whereDate('rented_date', '<=', $date),
                            );
                    })->indicateUsing(function (array $data): array {
                        $indicators = [];
                 
                        if ($data['date_from'] ?? null) {
                            $indicators['date_from'] = 'From: ' . Carbon::parse($data['date_from'])->toFormattedDateString();
                        }
                 
                        if ($data['date_to'] ?? null) {
                            $indicators['date_to'] = 'To: ' . Carbon::parse($data['date_to'])->toFormattedDateString();
                        }
                 
                        return $indicators;
                    })
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
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
            'create' => Pages\CreateRentedRoom::route('/{record?}/create'),
            'edit' => Pages\EditRentedRoom::route('/{record}/edit'),
        ];
    }    
}
