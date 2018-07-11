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
        return response(Reference::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $reference = new Reference();
        $reference->icon = $faker->lexify('????????');
        $reference->color = $faker->boolean ? 'red' : 'green';
        $reference->weight = $faker->boolean ? '2' : '4';
        $reference->fk_category_id = $faker->boolean ? '1' : '3';
        $reference->save();

        return response($reference->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $reference = Reference::findOrFail($id);
        $reference->icon = $request->icon;
        $reference->color = $request->color;
        $reference->weight = $request->weight;
        $reference->fk_category_id = $request->fk_category_id;
        $reference->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Reference::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
