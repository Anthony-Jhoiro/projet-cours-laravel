<?php

namespace App\Http\Controllers;

use App\Assets;
use App\Categorie;
use App\Http\Requests\RecetteRequest;
use App\Recette;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DateTime;

class RecetteController extends Controller
{
    public function index(Request $request, $id){
        /**
         * @var Recette $recette
         */
        // chargement de la recette
        $recette = Recette::find($id);

        // Sil recette n'existe pas on renvoie une erreure 404
        if ($recette == NULL) abort (404);


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


        // chargements des assets de la recette
        $recette->assets = $recette->getAssets;

        // On retourne de la vue
        return view('recette', compact ('recette'));
    }

    public function create()
    {
        $parametres = [
            'typeFormulaire' => 'POST',
            'recette' => new Recette(),
            'id' => -1,
            'categories' => Categorie::all()
        ];
        return view ('recetteEdit', $parametres);
    }

    public function store(RecetteRequest $request)
    {
        // Vérification de l'unicité du titre
        $recette = Recette::where('titre', $request->titre)->get();
        if (count($recette) != 0) throw new \Exception("Le nom de la recette est déjà pris");

        // Création de la recette en base
        $recette = new Recette([
            'titre' => $request->input ('titre'),
            'text' => $request->input ('text'),
            'auteur' => Auth::user ()->id
        ]);

        $recette -> save ();

        $id = $recette ->id;

        // Ajout des assets
        $photoUrls = $request->input('photoUrls');
        foreach ($photoUrls as $photoUrl) {
            Assets::create([
                'url' => $photoUrl,
                'recette_id' => $recette -> id
            ]);
        }

        // Ajout des ingredients
        $recette -> getIngredients () -> attach ($request -> ingredientIds);

        $recette -> getCategories () -> attach($request -> categories);

        return self::index ();
    }

    public function update(Request $request, $n)
    {
        $recette = Recette::find($n);
        $recette->titre = $request->input ('titre');
        $recette->titre = $request->input ('text');
        $recette->save();
        return view ('home');
    }

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
