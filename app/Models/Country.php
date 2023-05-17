<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;


    public function cities()
    {
        return $this->hasMany(City::class);
    }


    public function properties()
    {
        return $this->hasManyThrough(Property::class, City::class);
    }
}
