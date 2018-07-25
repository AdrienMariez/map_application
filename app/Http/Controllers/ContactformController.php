<?php

namespace App\Http\Controllers;

use App\Contactform;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class ContactformController extends Controller
{
    // public function index()
    // {
    //     $index = Contactform::orderBy('weight', 'asc')->get();
    //     return response($index->jsonSerialize(), Response::HTTP_OK);
    //     // return response(Category::all()->jsonSerialize(), Response::HTTP_OK);
    // }

    public function create(Request $request)
    {
        $contactform = new Contactform();
        $contactform->name = $request->name;
        $contactform->title = $request->title;
        $contactform->email = $request->email;
        $contactform->text = $request->text;
        $contactform->save();

        return response($contactform->jsonSerialize(), Response::HTTP_CREATED);
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

    // public function destroy($id)
    // {
    //     Category::destroy($id);

    //     return response(null, Response::HTTP_OK);
    // }
}
