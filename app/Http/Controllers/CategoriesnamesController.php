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

    public function store(Request $request)
    {
        $categoryName = new Categoriesnames();
        $categoryName->fk_category_id = $request->fk_category_id;
        $categoryName->fk_language_code = $request->fk_language_code;
        $categoryName->text = $request->text;
        $categoryName->updated_at = $request->created_at;
        $categoryName->created_at = $request->created_at;
        $categoryName->save();

        return response($categoryName->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $categoryName = Categoriesnames::findOrFail($id);
        $categoryName->fk_category_id = $request->fk_category_id;
        $categoryName->fk_language_code = $request->fk_language_code;
        $categoryName->text = $request->text;
        $categoryName->updated_at = $request->updated_at;
        $categoryName->save();

        return response(null, Response::HTTP_OK);
    }

    // public function update(Request $request, $id)
    // {
    //     $categoryName = Categoriesnames::findOrFail($id);
    //     $categoryName->$request->fk_language_code;
    //     $categoryName->text = $request->text;
    //     $categoryName->save();

    //     return response(null, Response::HTTP_OK);
    // }

    public function destroy($id)
    {
        Categoriesnames::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
