<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;


use App\Models\Booking;
use App\Models\User;

class BookingController extends Controller
{

    public function index()
    {
       
        //check if user is has permission to manage bookings
       // $this->authorize('bookings-manage');
        
        //get all bookings with property and apartment with trashed
        $bookings = auth()->user()->bookings()
            ->with('apartment.property')
            ->withTrashed()
            ->orderBy('start_date')
            ->get();
        
        //return bookings using BookingResource
        return BookingResource::collection($bookings);
        // dd(auth()->user());

        // return response()->json(['success' => true]);
    }


    public function store(StoreBookingRequest $request)
    {  
        //dd(auth()->id());

        $booking = auth()->user()->bookings()->create($request->validated());

        return new BookingResource($booking);
    }


    public function show(Booking $booking)
    {
        $this->authorize('bookings-manage');

        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        return new BookingResource($booking);
    }


    public function update(StoreBookingRequest $request, Booking $booking)
    {
        $this->authorize('bookings-manage');

        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        $booking->update($request->validated());

        return new BookingResource($booking);
    }


    public function destroy(Booking $booking)
    {
        $this->authorize('bookings-manage');

        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        $booking->delete();

        return response()->noContent();
    }
}
