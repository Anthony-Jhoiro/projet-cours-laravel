<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\Contact;
use App\Mail\NewPostMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(ContactRequest $request) {
        Log::debug ($request);
//        Mail::to ('moi@moi.moi')->send (new Contact($request->except ('_token')));
        Mail::to ('moi@moi.moi')->send (new NewPostMail());
        return view('contact');
    }
}
