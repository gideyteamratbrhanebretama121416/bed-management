<?php

namespace App\Filament\Resources\RentedRoomResource\Pages;

use App\Filament\Resources\RentedRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\CreateAction;
use Illuminate\Contracts\View\View;


class ListRentedRooms extends ListRecords
{
    protected static string $resource = RentedRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getActions(): array
    {
        return [
        ];
    }


    protected function getFooter(): ?View
    {
        return view('rented-room-footer');
    }
}
