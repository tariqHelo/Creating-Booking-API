<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Property;
use Generator;
use App\Models\Geoobject;

use App\Http\Resources\PropertySearchResource;

class PropertySearchController extends Controller
{
    public function __invoke(Request $request)
    {

        //dd($request->all());
        $properties = Property::query()
            ->with([
                'city',
                'apartments.apartment_type',
                'apartments.rooms.beds.bed_type',
                'apartments.prices' => function($query) use ($request) {
                    $query->validForRange([
                        $request->start_date ?? now()->addDay()->toDateString(),
                        $request->end_date ?? now()->addDays(2)->toDateString(),
                    ]);
                },
                'facilities',
                // We add only this eager loading by position here
                'media' => fn($query) => $query->orderBy('position'),
            ])
            ->withAvg('bookings', 'rating')

            // conditions will come here
            ->when($request->has('city_id'), function ($query) use ($request) {
                $query->where('city_id', $request->city_id);
            })
            //get all properties in a country
            ->when($request->country, function ($query) use ($request) {
                $query->whereHas('city', fn ($q) => $q->where('country_id', $request->country));
            })
            //Search by Geographical Object, within 10km
            ->when($request->geoobject, function ($query) use ($request) {
                $geoobject = Geoobject::find($request->geoobject);
                if ($geoobject) {
                    $condition = "(
                        6371 * acos(
                            cos(radians(" . $geoobject->lat . "))
                            * cos(radians(`lat`))
                            * cos(radians(`long`) - radians(" . $geoobject->long . "))
                            + sin(radians(" . $geoobject->lat . ")) * sin(radians(`lat`))
                        ) < 10
                    )";
                    $query->whereRaw($condition);
                }
            })
            ->when($request->adults && $request->children, function($query) use ($request) {
                $query->withWhereHas('apartments', function($query) use ($request) {
                    $query->where('capacity_adults', '>=', $request->adults)
                        ->where('capacity_children', '>=', $request->children)
                        ->orderBy('capacity_adults')
                        ->orderBy('capacity_children')
                        ->take(1);
                });
            })
            //search by facilities
            ->when($request->facilities, function ($query) use ($request) {
                $query->withWhereHas('facilities', function ($query) use ($request) {
                    $query->whereIn('name', $request->facilities);
                });
            })
            ->orderBy('bookings_avg_rating', 'desc')
            ->get();

        // $allFacilities = $properties->pluck('facilities')->flatten();
        // $facilities = $allFacilities->unique('name')
        //     ->mapWithKeys(function ($facility) use ($allFacilities) {
        //         return [$facility->name => $allFacilities->where('name', $facility->name)->count()];
        //     })
        //     ->sortDesc();


        // return $properties;
        return [
            'properties' => PropertySearchResource::collection($properties),
            // 'facilities' => $facilities,
        ];
    }
}
