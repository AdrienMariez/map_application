<?php

namespace App\Http\Controllers;

use App\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class CategoriesController extends Controller
{
    public function index()
    {
        return response(Categorie::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $categorie = new Categorie();
        $categorie->icon = $faker->lexify('????????');
        $categorie->color = $faker->boolean ? 'red' : 'green';
        $categorie->weight = $faker->boolean ? '2' : '4';
        $categorie->save();

        return response($categorie->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->icon = $request->icon;
        $categorie->color = $request->color;
        $categorie->weight = $request->weight;
        $categorie->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Categorie::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
