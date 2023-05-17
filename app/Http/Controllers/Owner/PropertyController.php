<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Property;

class PropertyController extends Controller
{
    
    public function index(){
      
        $this->authorize('properties-manage');

        return response()->json(['success' => true]);
    }


    public function store(Request $request){
        $this->authorize('properties-manage');

        return Property::create($request->all());
    }
}
