<?php

namespace App\Http\Controllers;

use App\Pointsnames;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class PointsnamesController extends Controller
{
    public function index()
    {
        return response(Pointsnames::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $pointName = new Pointsnames();
        $pointName->text = $faker->lexify('????????');
        $pointName->fk_point_id = $faker->boolean ? '2' : '4';
        $pointName->fk_language_id = $faker->boolean ? '2' : '4';
        $pointName->save();

        return response($pointName->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $pointName = Pointsnames::findOrFail($id);
        $pointName->text = $request->text;
        $pointName->$fk_reference_id = $request->fk_reference_id;
        $pointName->fk_language_id = $request->fk_language_id;
        $pointName->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Pointsnames::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
