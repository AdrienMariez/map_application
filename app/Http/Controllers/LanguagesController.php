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

    public function store(Request $request)
    {
        $language = new Language();
        $language->id = $request->id;
        $language->name = $request->name;
        $language->code = $request->code;
        $language->active = $request->active;
        $language->save();

        return response($language->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->code = $request->code;
        $language->active = $request->active;
        $language->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Language::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
