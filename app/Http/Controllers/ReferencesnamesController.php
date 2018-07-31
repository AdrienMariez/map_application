<?php

namespace App\Http\Controllers;

use App\Referencesnames;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class ReferencesnamesController extends Controller
{
    public function index()
    {
        return response(Referencesnames::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $referenceName = new Referencesnames();
        $referenceName->text = $faker->lexify('????????');
        $categoryName->fk_category_id = $faker->boolean ? '1' : '2';
        $referenceName->fk_language_code = $faker->boolean ? '2' : '4';
        $referenceName->save();

        return response($referenceName->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $referenceName = Referencesnames::findOrFail($id);
        $referenceName->text = $request->text;
        $referenceName->fk_category_id = $request->fk_category_id;
        $referenceName->fk_language_code = $request->fk_language_code;
        $referenceName->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Referencesnames::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
