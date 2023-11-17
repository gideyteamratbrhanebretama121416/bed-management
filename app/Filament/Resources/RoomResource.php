<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Building;
use App\Models\Floor;
use App\Models\RentedRoom;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';
    protected static ?string $navigationGroup = 'Configurations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([   
                Select::make('floor_id')
                ->label('Floor')
                ->options(Floor::all()->pluck('name', 'id'))
                ->required(),
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('floor.building.name')->label('Building'),
                TextColumn::make('floor.name')->label('Floor'),
                TextColumn::make('name')->label('Name'),
                TextColumn::make('price')->label('Price'),
                TextColumn::make('status')->label('Status'),

            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    'Free' => 'Free',
                    'Rented' => 'Rented',
                    'Unavailable' => 'Unavailable',
                ]),
                Filter::make('building')
                ->form([
                    Select::make('building_id')->label('Building')->options(Building::all()->pluck('name', 'id')),
                    
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['building_id'],
                            fn (Builder $query, $date): Builder => $query->whereHas('floor.building', function ($query) use ($data) {
                                $query->where('building_id', $data);
                            }),
                        );
                })->indicateUsing(function (array $data): array {
                    $indicators = [];
                    if (!$data['building_id']) {
                        return [];
                    }
                    if ($data['building_id'] ?? null) {
                        $indicators['building_id'] = 'Building; '.Building::findOrFail($data['building_id'])->name;
                    }
                    return $indicators;
                }),
                SelectFilter::make('floor')->relationship('floor', 'name')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Free')
                    ->action(function (Room $record) {
                        $record->status = "Free";
                        $record->save();
                        return $record;
                        
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn ($record) => $record->status == 'Rented'),
                    Tables\Actions\Action::make('Rent')
                        ->label('Rent')
                       ->url(fn (Room $record): string => RentedRoomResource::getUrl('create', ['record' => $record]))
                        ->color('success')
                        ->icon('heroicon-o-check')
                        ->visible(fn ($record) => $record->status == 'Free'),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }    
}
