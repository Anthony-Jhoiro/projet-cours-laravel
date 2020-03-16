<?php

namespace App\Http\Controllers;

use App\Assets;
use App\Http\Requests\RecetteRequest;
use App\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DateTime;

class RecetteController extends Controller
{
    public function index(Request $request, $id){
        // chargement de la recette
        // TODO : use Eloquent
        $recette = DB::select('SELECT r.id, r.titre, r.auteur auteur_id, r.text, r.created_at, r.updated_at, u.name auteur, i.libelle FROM recettes r INNER JOIN users u ON r.auteur = u.id LEFT JOIN recette_ingredient ri ON r.id = ri.id_recette LEFT JOIN ingredients i ON ri.id_ingredient = i.id WHERE r.id = ?', [$id]);
        $recette = $recette[0];

        // Convertion du markdown au html
        $parser = new \Parsedown();
        $recette->text =  $parser->text($recette->text);

        // mise en forme de la date
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $recette->updated_at);
        $moisNb = (int) $date->format('m') - 1;
        $mois = HomeController::$lesMois[$moisNb]." ";
        $jour = $date->format("d")." ";
        $reste = $date->format('Y à H:i');
        $recette->updated_at = $jour.$mois.$reste;

        // chargement à part des ingrédients de la recette
        // TODO : use Eloquent
        $ingredients = DB::select('SELECT i.libelle FROM recettes r LEFT JOIN recette_ingredient ri ON r.id = ri.id_recette LEFT JOIN ingredients i ON ri.id_ingredient = i.id WHERE r.id = ?', [$id]);
        $ingredientsList = [];
        foreach ($ingredients as $ingredient) {
            array_push($ingredientsList, $ingredient->libelle);
        }

        // creation de l'objet recette
        $recette = new Recette($recette->titre, $recette->text, $recette->auteur, $recette->updated_at, $ingredientsList, []);

        // chargements des assets de la recette
        $assets = DB::select('SELECT url, type FROM assets WHERE id = ?', [$id]);
        foreach ($assets as $asset) {
            $asset = new Assets($asset->url, $id, $asset->type);
            array_push($recette->assets, $asset);
        }

        // chargement de la vue
        return view('recette', compact('recette'));
    }

    public function create()
    {
        $parametres = [
            'typeFormulaire' => 'POST',
            'recette' => new Recette(),
            'id' => -1
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
        $recette->save ();

        // Ajout des assets
        $photoUrls = $request->input('photoUrls');
        foreach ($photoUrls as $photoUrl) {
            Assets::create([
                'url' => $photoUrl,
                'recette' => $recette -> id
            ]);
        }

        // Ajout des ingredients
        $recette -> ingredients () -> attach ($request -> ingredientIds);

        return view ('home');
    }

    public function update(Request $request, $n)
    {

        Log::debug ("Update !");
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
