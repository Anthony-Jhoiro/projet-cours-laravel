<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Http\Requests\PreferencesCategoriesRequest;
use App\Ingredients;
use App\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use DateTime;
use phpDocumentor\Reflection\Types\Null_;

class RecetteController extends Controller
{

    protected $preferencesController;

    /**
     * RecetteController constructor for deêndencies injection
     * @param PreferencesController $preferencesController
     */
    public function __construct(PreferencesController $preferencesController)
    {
        $this->preferencesController = $preferencesController;
    }

    /**
     * Charge les informations nécessaires à l'affichage d'une recette
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $id){
        /**
         * @var Recette $recette
         */
        // chargement de la recette, on renvoie une erreure 404 si elle n'est pas trouvée
        $recette = Recette::findOrFail($id);

        // Convertion du markdown au html
        $parser = new \Parsedown();
        $recette->text =  $parser->text($recette->text);

        // mise en forme de la date
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $recette->updated_at);
        $moisNb = (int) $date->format('m') - 1;
        $mois = HomeController::$lesMois[$moisNb]." ";
        $jour = $date->format("d")." ";
        $reste = $date->format('Y à H:i');
        $recette->formatDate = $jour.$mois.$reste;

        $recette->auteurNom = $recette->author->name;

        // chargement des ingrédients de la recette
        $recette->ingredients = $recette->getIngredients;


        $recette->categories = $recette->getCategories;


        // chargements des assets de la recette
        $recette->assets = $recette->getAssets;

        if (Auth::user () != NULL) {
            foreach ($recette->categories as $category) {
                $this->preferencesController->storeForInjection ( $category->id );
            }
        }

        // On retourne de la vue
        return view('recette', compact ('recette'));
    }

    /**
     * Charge la page d'édition d'une recette en mode création
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $parametres = [
            'typeFormulaire' => 'POST',
            'recette' => new Recette(),
            'id' => -1,
            'categories' => Categorie::all(),
            'ingredients' => Ingredients::all ()
        ];

        return view ('recetteEdit', $parametres);
    }


    public function update(Request $request, $n)
    {
        $recette = Recette::find($n);
        $recette->titre = $request->input ('titre');
        $recette->titre = $request->input ('text');
        $recette->save();
        return view ('home');
    }

    /**
     * Charge la page d'édition d'une recette en mode edition
     * @param Request $request
     * @param $n
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit (Request $request, $n) {
        $recette = Recette::find($n);

        if (!isset($recette)) {
            abort(404);
        }
        $parametres = [
            'typeFormulaire' => 'PATCH',
            'recette' => $recette,
            'id' => $n
        ];
        return view ('recetteEdit', $parametres);
    }

    public function creer (Request $request) {
        // Vérifier les infos reçus
        $validator = Validator::make($request->all(), [
            'nom' => 'bail|required|between:5,20|alpha',
            'email' => 'bail|required|email',
            'message' => 'bail|required|max:250'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        return view('recetteEdit');


        // Ajouter les infos en base
    }

    public function modifier () {
        // Vérifier les infos reçus

        // Modifier les données en base
    }
}
