<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

use App\Http\Resources\ApartmentDetailsResource;

class ApartmentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Apartment $apartment)
    {

        dd($apartment);
        $apartment->load('facilities.category');

        $apartment->setAttribute(
            'facility_categories',
            $apartment->facilities->groupBy('category.name')->mapWithKeys(fn ($items, $key) => [$key => $items->pluck('name')])
        );
 
        return new ApartmentDetailsResource($apartment);
    }
}
