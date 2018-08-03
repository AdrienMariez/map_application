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
        $index = Category::orderBy('weight', 'asc')->get();
        return response($index->jsonSerialize(), Response::HTTP_OK);
        // return response(Category::all()->jsonSerialize(), Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $category = new Category();
        $category->id = $request->id;
        $category->icon = $request->icon;
        $category->color = $request->color;
        $category->weight = $request->weight;
        $category->updated_at = $request->created_at;
        $category->created_at = $request->created_at;
        $category->save();

        return response($category->jsonSerialize(), Response::HTTP_CREATED);
    }

    // public function update(Request $request, $id)
    // {
    //     $category = Category::findOrFail($id);
    //     $category->icon = $request->icon;
    //     $category->color = $request->color;
    //     $category->weight = $request->weight;
    //     $category->save();

    //     return response(null, Response::HTTP_OK);
    // }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->icon = $request->icon;
        $category->color = $request->color;
        $category->weight = $request->weight;
        $category->updated_at = $request->updated_at;
        $category->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
