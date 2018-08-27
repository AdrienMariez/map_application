<?php

namespace App\Http\Controllers;

use App\Contact;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class ContactController extends Controller
{
    public function index()
    {
        return response(Contact::all()->jsonSerialize(), 
        Response::HTTP_OK);
    }
    
    public function store(Request $request)
    {
        $contact = new Contact();
        $contact->id = $request->id;
        $contact->name = $request->name;
        $contact->title = $request->title;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        Mail::send('emails.contact',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'title' => $request->get('title'),
                'user_message' => $request->get('message')
                ),
                function($message) {
                    $message->from('noreply@cartePrayssac.com');
                    $message->to('adrien.mariez@gmail.com', 'Admin')->subject('Message utilisateur');
                }
        );

        return response($contact->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->name = $request->name;
        $contact->title = $request->title;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Contact::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
