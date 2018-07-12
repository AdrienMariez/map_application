<?php

namespace App\Http\Controllers;

use App\ReferenceName;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class ReferencesNamesController extends Controller
{
    public function index()
    {
        return response(ReferenceName::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $referenceName = new ReferenceName();
        $referenceName->text = $faker->lexify('????????');
        $referenceName->fk_language_id = $faker->boolean ? '2' : '4';
        $referenceName->save();

        return response($referenceName->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $referenceName = ReferenceName::findOrFail($id);
        $referenceName->text = $request->text;
        $referenceName->fk_language_id = $request->fk_language_id;
        $referenceName->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        ReferenceName::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
