<?php

namespace App\Filament\Resources\RentedRoomResource\Pages;

use App\Filament\Resources\RentedRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentedRoom extends EditRecord
{
    protected static string $resource = RentedRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
