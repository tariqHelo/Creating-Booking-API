<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'name', 'lat', 'long'];



    public function city(){
        return $this->belongsTo(Country::class);
    }

    public function properties(){
        return $this->hasMany(Property::class);
    }

    public function geoobjects(){
        return $this->hasMany(Geoobject::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
