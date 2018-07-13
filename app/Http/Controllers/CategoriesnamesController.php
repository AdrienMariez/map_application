<?php

namespace App\Http\Controllers;

use App\Categoriesnames;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class CategoriesnamesController extends Controller
{
    public function index()
    {
        return response(Categoriesnames::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $categoryName = new Categoriesnames();
        $categoryName->fk_category_id = $faker->boolean ? '1' : '2';
        $categoryName->fk_language_id = $faker->boolean ? '1' : '2';
        $categoryName->text = $faker->lexify('????????');
        $categoryName->save();

        return response($CategoryName->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $categoryName = Categoriesnames::findOrFail($id);
        $categoryName->$request->fk_category_id;
        $categoryName->$request->fk_language_id;
        $categoryName->text = $request->text;
        $categoryName->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Categoriesnames::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
