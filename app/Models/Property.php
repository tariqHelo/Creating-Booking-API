<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\PropertyObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;



class Property extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'owner_id',
        'name',
        'city_id',
        'address_street',
        'address_postcode',
        'lat',
        'long',
    ];
   
    //Relationships with City model
    public function city(){
        return $this->belongsTo(City::class);
    }

    
    //Observer for Property model
    public static function booted()
    {
        parent::booted();
 
        self::observe(PropertyObserver::class);
    }

    
    //Relationships with User model
    public function owner(){
        return $this->belongsTo(User::class);
    }
    
    //Relationships with Apartment model
    public function apartments(){
        return $this->hasMany(Apartment::class);
    }

    
    //Relationships with Facility model
    public function facilities(){
        return $this->belongsToMany(Facility::class);
    }

    
    //Relationships with ApartmentPrice model
    public function prices(){
        return $this->hasMany(ApartmentPrice::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Apartment::class);
    }
    
    
    //Get with the attribute the full address of the property
    public function address(): Attribute
    {
        return new Attribute(
            get: fn () => $this->address_street
                 . ', ' . $this->address_postcode
                 . ', ' . $this->city->name
        );
    }
    
    //Get Thubnail of the property
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(800);
    }


    


}
