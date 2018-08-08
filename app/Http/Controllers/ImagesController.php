<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//Faker allows to implement dummy data
use Faker\Generator;

class ImagesController extends Controller
{

    public function index()
    {
        return response(Image::all()->jsonSerialize(), 
        Response::HTTP_OK);
    }

    // public function store(Request $request)
        // {
            // $this->validate($request, [
            //     'image' => 'required'
            // ]);
        
            // if($request->get('image')) {
            //     $image = $request->get('image');
            //     $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            //     \Image::make($request->get('image'))->save(public_path('images/uploads/').$name);
            // }

        //     $image= new Image();
        //     $image->image_path = $image_path;
        //     $image->updated_at = $request->created_at;
        //     $image->created_at = $request->created_at;
        //     $image->save();

        //     return response($image->jsonSerialize(), Response::HTTP_CREATED);
    // }
    

    public function store(Request $request)
    {
        if($request->get('image'))
        {
           $image = $request->get('image');
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           \Image::make($request->get('image'))->save(public_path('images/').$name);
         }
 
        $image= new Image();
        $image->image_path = $name;
        $image->updated_at = $request->created_at;
        $image->created_at = $request->created_at;
        $image->save();
 
        return response()->json(['success' => 'You have successfully uploaded an image'], 200);

        // $image = new Image();
        // $image->id = $request->id;
        // $image->image_path = '/images/uploads/'.$name;
        // $image->updated_at = $request->created_at;
        // $image->created_at = $request->created_at;
        // $image->save();

    }

    public function uploadGalery(Request $request){

        $this->validate($request, [
          'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
      
        if ($request->hasFile('file')) {
          $image = $request->file('file');
          $name = time().'.'.$image->getClientOriginalExtension();
          $destinationPath = public_path('/storage/galeryImages/');
          $image->move($destinationPath, $name);
      
          $this->save();
      
          return back()->with('success','Image Upload successfully');
        }
      
      }

    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        $image->image_path = $request->image_path;
        $image->updated_at = $request->updated_at;
        $image->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Image::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
