<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

use App\Http\Resources\ApartmentDetailsResource;
use Termwind\Components\Raw;

class ApartmentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        // Find the apartment by ID in the database
        $apartment = Apartment::find($id);

        // If the apartment is not found, return 404
        if (!$apartment) {
            return response()->json([
                'message' => 'Apartment not found',
            ], 404);
        }
        $apartment->load('facilities.category');

        $apartment->setAttribute(
            'facility_categories',
            $apartment->facilities->groupBy('category.name')
                ->mapWithKeys(fn ($items, $key) =>
                [$key => $items->pluck('name')])
        );

        return new ApartmentDetailsResource($apartment);
    }
}
