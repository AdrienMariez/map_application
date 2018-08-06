<?php

namespace App\Http\Controllers;

use App\Reference;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class ReferencesController extends Controller
{
    public function index()
    {
        $index = Reference::orderBy('weight', 'asc')->get();
        return response($index->jsonSerialize(), Response::HTTP_OK);
        // return response(Reference::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $reference = new Reference();
        $reference->id = $request->id;
        $reference->icon = $request->icon;
        $reference->weight = $request->weight;
        $reference->fk_category_id = $request->fk_category_id;
        $reference->updated_at = $request->created_at;
        $reference->created_at = $request->created_at;
        $reference->save();

        return response($reference->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $reference = Reference::findOrFail($id);
        $reference->icon = $request->icon;
        $reference->weight = $request->weight;
        $reference->fk_category_id = $request->fk_category_id;
        $reference->updated_at = $request->updated_at;
        $reference->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Reference::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
