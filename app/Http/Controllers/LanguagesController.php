<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class LanguagesController extends Controller
{
    public function index()
    {
        return response(Language::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $Language = new Language();
        $Language->name = $faker->lexify('????????');
        $Language->save();

        return response($Language->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $Language = Language::findOrFail($id);
        $Language->name = $request->name;
        $Language->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Language::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
