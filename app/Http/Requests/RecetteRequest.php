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
            'titre' => 'bail|required|between:5,255|alpha',
            'text' => 'bail|required',
            'photoUrls' => ''
        ];
    }


    public function getPersonalRecettes(){
        $recettes = App\Recette::all();
    }

    public function tempGetRecettes(){
        return [
            [
                "id" => "1",
                "text" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum eos vel ipsum, minima deserunt neque nobis tempora numquam voluptate consequatur consequuntur facilis dicta rerum alias facere. Recusandae illum quisquam rerum",
                "created_at" => new Date("2020-02-06" ),
                "updated_at" => "",
                "auteur" => ""
            ],

        ];
    }
}
