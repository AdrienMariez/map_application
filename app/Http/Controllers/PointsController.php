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

    public function index()
    {
        return response(Point::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $point = new Point();
        $point->link = $faker->lexify('????????');
        $point->icon = $faker->lexify('????????');
        $point->color = $faker->boolean ? 'red' : 'green';
        $point->longitude = $faker->boolean ? '2' : '4';
        $point->lattitude = $faker->boolean ? '1' : '3';
        $point->image_path = $faker->lexify('????????');
        $point->save();

        return response($point->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $point = Point::findOrFail($id);
        $point->link = $request->link;
        $point->icon = $request->icon;
        $point->color = $request->color;
        $point->longitude = $request->longitude;
        $point->lattitude = $request->lattitude;
        $point->image_path = $request->image_path;
        $point->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Point::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
