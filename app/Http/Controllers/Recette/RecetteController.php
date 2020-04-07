<?php

namespace App\Http\Controllers\Recette;

use App\Assets;
use App\Events\NouvelleRecette;
use App\Http\Controllers\Controller;
use App\Categorie;
use App\Http\Controllers\DateController;
use App\Http\Controllers\PreferencesController;
use App\Http\Requests\PreferencesCategoriesRequest;
use App\Http\Requests\RecetteRequest;
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
    const RecetteAffichageMax = 10;
    protected $preferencesController;
    protected $dateController;

    /**
     * RecetteController constructor for deêndencies injection
     * @param PreferencesController $preferencesController
     * @param DateController $dateController
     */
    public function __construct(PreferencesController $preferencesController, DateController $dateController)
    {
        $this->preferencesController = $preferencesController;
        $this->dateController = $dateController;
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
        $recette->formatDate = $this->dateController->getFormatDate ($recette->updated_at);

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
     * Créé la recette en base
     * @param RecetteRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function store( RecetteRequest $request )
    {
        // Verification de l'unicité du titre
        $recette = Recette ::where ( 'titre', $request -> titre ) -> get ();
        if (count ( $recette ) != 0) throw new \Exception( "Le nom de la recette est déjà pris" );

        // Creation de la recette en base
        $recette = new Recette( [
            'titre' => $request -> input ( 'titre' ),
            'text' => $request -> input ( 'text' ),
            'auteur' => Auth ::user () -> id
        ] );

        $recette -> save ();

        // Ajout des assets
        $photoUrls = $request -> input ( 'photoUrls' );
        if ($photoUrls === null) $photoUrls = [];

        foreach ($photoUrls as $photoUrl) {
            Assets ::create ( [
                'url' => $photoUrl,
                'recette_id' => $recette -> id
            ] );
        }

        // Ajout des ingredients

        $recette -> getIngredients () -> attach ( $request -> ingredients );

        $recette -> getCategories () -> attach ( $request -> categories );

        // Déclanchement de l'événement `NouvelleRecette` qui permettra via le listener
        // `NouvelleRecetteListener` d'envoyer un mail à toutes les personnes abonnés à l'auteur
        event ( new NouvelleRecette( $recette ) );

        return 'success';
    }

    public function update(RecetteRequest $request, $id)
    {
        $recette = Recette::findOrFail($id);

        if ($recette->auteur != Auth::user ()->id) throw new \Exception("Vous n'êtes pas autorisé");

        // changements dans la table recette
        // TODO : Titre unique
        $recette->titre = $request->titre;
        $recette->text = $request->text;
        $recette->save();

        // Mis à jour des assets
        $recette->getAssets->each->delete();

        $photoUrls = $request -> input ( 'photoUrls' );
        if ($photoUrls === null) $photoUrls = [];


        foreach ($photoUrls as $photoUrl) {
            Assets ::create ( [
                'url' => $photoUrl,
                'recette_id' => $recette -> id
            ] );
        }


        // Mise à jour des ingredients
        $ingredients = $recette->getIngredients;
        foreach ($ingredients as $ingredient) {
            $recette->getIngredients()->detach($ingredient);
        }

        $recette -> getIngredients () -> attach ( $request -> ingredients );

        // Mise à jour des categories
        $categories = $recette -> getCategories;
        foreach ($categories as $categorie) {
            $recette -> getCategories()->detach($categorie);
        }
        $recette -> getCategories () -> attach ( $request -> categories );


        return "success";
    }

    public function delete(Request $request, $id) {
        $recette = Recette::find($id);

        if ($recette->auteur == Auth::user ()->id) {
            $recette->forceDelete();
        } else {
            // TODO : Renvoyer une erreur
        }

    }
}
