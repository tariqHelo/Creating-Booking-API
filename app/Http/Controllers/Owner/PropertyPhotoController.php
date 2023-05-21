<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Property;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PropertyPhotoController extends Controller
{

    public function store(Property $property, Request $request)
    {   
        //Validate the request
        $request->validate([
            'photo' => ['image', 'max:5000']
        ]);
        
        //Get Photo from request and add it to the property
        $photo = $property->addMediaFromRequest('photo')->toMediaCollection('photos');
         
        //Set the position of the photo
        $position = Media::query()
            ->where('model_type', 'App\Models\Property')
            ->where('model_id', $property->id)
            ->max('position') + 1;
        //Set the position of the photo    
        $photo->position = $position;
        //Save the photo
        $photo->save();
        
        //Return the photo
        return [
            'filename' => $photo->getUrl(),
            'thumbnail' => $photo->getUrl('thumbnail'),
            'position' => $photo->position
        ];
    }


    public function reorder(Property $property, Media $photo, int $newPosition){

        if ($property->owner_id != auth()->id() || $photo->model_id != $property->id) {
            abort(403);
        }
       
        //Reorder the photos
        $query = Media::query()
            //Get all the photos where model_type is the same as the model_type of the photo
            ->where('model_type', 'App\Models\Property')
            //Get all the photos where model_id is the same as the model_id of the photo
            ->where('model_id', $photo->model_id);
        if ($newPosition < $photo->position) {
            //Increment the position of the photo
            $query->whereBetween('position', [$newPosition, $photo->position-1])
                ->increment('position');
        } else {
            //Decrement the position of the photo
            $query->whereBetween('position', [$photo->position+1, $newPosition])->decrement('position');
        }
        $photo->position = $newPosition;
        $photo->save();
     
        return [
            'newPosition' => $photo->position
        ];
    }
}
