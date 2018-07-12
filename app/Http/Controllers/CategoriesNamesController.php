<?php

namespace App\Http\Controllers;

use App\CategoryName;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class CategoriesNamesController extends Controller
{
    public function index()
    {
        return response(CategoryName::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $categoryName = new CategoryName();
        $categoryName->fk_category_id = $faker->boolean ? '1' : '2';
        $categoryName->fk_language_id = $faker->boolean ? '1' : '2';
        $categoryName->text = $faker->lexify('????????');
        $categoryName->save();

        return response($CategoryName->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $categoryName = CategoryName::findOrFail($id);
        $categoryName->$request->fk_category_id;
        $categoryName->$request->fk_language_id;
        $categoryName->text = $request->text;
        $categoryName->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        CategoryName::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
