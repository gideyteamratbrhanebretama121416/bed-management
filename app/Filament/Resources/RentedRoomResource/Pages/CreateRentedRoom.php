<?php

namespace App\Filament\Resources\RentedRoomResource\Pages;

use App\Filament\Resources\RentedRoomResource;
use App\Models\RentedRoom;
use App\Models\Room;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRentedRoom extends CreateRecord
{
    protected static string $resource = RentedRoomResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    protected function handleRecordCreation(array $data): RentedRoom
    {
        $room = Room::findOrFail(app('request')->serverMemo['data']['record']);
        $attributes = collect($data)->merge(['room_id' => $room->id, 'price' => $room->price]);
        $room->status = 'Rented';
        $room->save();
        return RentedRoom::create($attributes->toArray());
    }
}
