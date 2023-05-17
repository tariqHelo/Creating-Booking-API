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
        $properties =  Property::with([
            'city',
            'apartments.apartment_type',
            'apartments.rooms.beds.bed_type'
        ])
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
                        ->where('capacity_children', '>=', $request->children);
                });
            })
            ->get();

            return PropertySearchResource::collection($properties);

    }
}
