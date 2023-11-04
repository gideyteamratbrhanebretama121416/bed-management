<?php

namespace App\Filament\Resources\RentedRoomResource\Pages;

use App\Filament\Resources\RentedRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentedRooms extends ListRecords
{
    protected static string $resource = RentedRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
