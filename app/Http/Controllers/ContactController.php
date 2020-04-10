<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\Contact;
use App\Mail\NewPostMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    /**
     * Envoie un mail à "l'administrateur" du site avec le contenue du formulaire de contact de l'utilisateur
     * @param ContactRequest $request
     * @return RedirectResponse
     */
    public function store(ContactRequest $request) {
        Mail::to ('moi@moi.moi')->send (new Contact($request->except ('_token')));
        return redirect()->route('pages.home');
    }
}
