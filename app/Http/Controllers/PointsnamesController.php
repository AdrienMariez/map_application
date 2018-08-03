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

    public function store(Request $request)
    {
        $pointName = new Pointsnames();
        $pointName->id = $request->id;
        $pointName->$fk_point_id = $request->fk_point_id;
        $pointName->fk_language_code = $request->fk_language_code;
        $pointName->title = $request->title;
        $pointName->description = $request->description;
        $pointName->linkalias = $request->linkalias;
        $pointName->save();

        return response($pointName->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $pointName = Pointsnames::findOrFail($id);
        $pointName->$fk_point_id = $request->fk_point_id;
        $pointName->fk_language_code = $request->fk_language_code;
        $pointName->title = $request->title;
        $pointName->description = $request->description;
        $pointName->linkalias = $request->linkalias;
        $pointName->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Pointsnames::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
