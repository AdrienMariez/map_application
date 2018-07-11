<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class CategoriesController extends Controller
{
    public function index()
    {
        return response(Category::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker)
    {
        $category = new Category();
        $category->icon = $faker->lexify('????????');
        $category->color = $faker->boolean ? 'red' : 'green';
        $category->weight = $faker->boolean ? '2' : '4';
        $category->save();

        return response($category->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->icon = $request->icon;
        $category->color = $request->color;
        $category->weight = $request->weight;
        $category->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
