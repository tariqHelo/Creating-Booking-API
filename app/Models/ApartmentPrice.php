<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'price',
        'start_date',
        'end_date',
    ]; 
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];



    // public function apartment()
    // {
    //     return $this->belongsTo(Apartment::class);
    // }


    public function scopeValidForRange($query, array $range = [])
    {
        return $query->where(function ($query) use ($range) {
            return $query
                // Covers outer bounds
                ->where(function ($query) use ($range) {
                    $query->where('start_date', '>=', reset($range))->where('end_date', '<=', end($range));
                })
                // Covers left and right bound
                ->orWhere(function ($query) use ($range) {
                    $query->whereBetween('start_date', $range)->orWhereBetween('end_date', $range);
                })
                // Covers inner bounds
                ->orWhere(function ($query) use ($range) {
                    $query->where('start_date', '<=', reset($range))
                        ->where('end_date', '>=', end($range));
                });
        });
       
    }
}
