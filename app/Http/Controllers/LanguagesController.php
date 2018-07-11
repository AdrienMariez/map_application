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
        $language = new Language();
        $language->name = $faker->lexify('????????');
        $language->save();

        return response($Language->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Language::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
