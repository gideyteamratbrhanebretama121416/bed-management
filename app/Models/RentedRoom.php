<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentedRoom extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'id_number', 'id_image', 'room_id', 'rented_date', 'price'];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
