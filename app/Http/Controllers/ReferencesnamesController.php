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

    public function store(Request $request)
    {
        $referenceName = new Referencesnames();
        $referenceName->fk_reference_id = $request->fk_reference_id;
        $referenceName->fk_language_code = $request->fk_language_code;
        $referenceName->text = $request->text;
        $referenceName->updated_at = $request->created_at;
        $referenceName->created_at = $request->created_at;
        $referenceName->save();

        return response($referenceName->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $referenceName = Referencesnames::findOrFail($id);
        $referenceName->fk_reference_id = $request->fk_reference_id;
        $referenceName->fk_language_code = $request->fk_language_code;
        $referenceName->text = $request->text;
        $referenceName->updated_at = $request->updated_at;
        $referenceName->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Referencesnames::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
