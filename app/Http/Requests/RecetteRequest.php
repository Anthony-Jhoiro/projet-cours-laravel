<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecetteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titre' => 'bail|required|between:5,255',
            'text' => 'bail|required',
            'photoUrls' => ''
        ];
    }


    public function getPersonalRecettes(){
        $recettes = App\Recette::all();
    }
}
