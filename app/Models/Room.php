<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'apartment_id',
        'room_type_id',
    ];


    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }

}
