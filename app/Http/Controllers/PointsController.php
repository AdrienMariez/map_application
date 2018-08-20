<?php

namespace App\Http\Controllers;

use App\Point;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//Faker allows to implement dummy data
use Faker\Generator;

class PointsController extends Controller
{
    
    // By default, Eloquent expects created_at and updated_at columns to exist on your tables. If you do not wish to have these columns automatically managed by Eloquent, set the $timestamps property on your model to false
    //public $timestamps = false;
    //except that brings other problems later, so you should stick to keep the columns in the first place and stick with it.

    public function index()
    {
        return response(Point::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $point = new Point();
        $point->id = $request->id;
        $point->link = $request->link;
        $point->longitude = $request->longitude;
        $point->lattitude = $request->lattitude;
        $point->fk_image_id = $request->fk_image_id;
        $point->fk_reference_id = $request->fk_reference_id;
        $point->updated_at = $request->created_at;
        $point->created_at = $request->created_at;
        $point->save();

        return response($point->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $point = Point::findOrFail($id);
        $point->link = $request->link;
        $point->longitude = $request->longitude;
        $point->lattitude = $request->lattitude;
        $point->fk_image_id = $request->fk_image_id;
        $point->fk_reference_id = $request->fk_reference_id;
        $point->updated_at = $request->updated_at;
        $point->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Point::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
