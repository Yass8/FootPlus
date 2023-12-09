<?php

use App\Models\Saison;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Etats\EtatController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Matchs\MatchsController;
use App\Http\Controllers\ProcesVebal\PvControlle;
use App\Http\Controllers\Saisons\SaisonController;
use App\Http\Controllers\Equipes\EquipesController;
use App\Http\Controllers\Journees\JourneesController;
use App\Http\Controllers\Clients\ChampionnatControlle;
use App\Http\Controllers\Divisions\DivisionController;
use App\Http\Controllers\Rencontre\RencontresController;
use App\Http\Controllers\Parametres\ParametresController;
use App\Http\Controllers\Championnats\ChampionnatController;
use App\Http\Controllers\Email\EmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/acceuil', function () {
    $saisons = DB::table('saisons')->orderBy('nom_saison','DESC')->get();
    $etats = DB::table('etats')->orderBy('nom_etat','DESC')->get();
    $divisions = DB::table('divisions')->get();
    return view('publics/index', compact('saisons','etats','divisions'));
})->name('acceuil');

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/journee', function () {
    return view('publics/journees');
})->name('journees');

Route::get('/classement', function () {
    return view('publics/classement');
})->name('classement');

Route::get('/dashboard', function () {
    // $champs = Auth::user()->championnats->get([1]);

    // $champs = Auth::users()->roles()->get();
    // dd($user);
    $champs = DB::table('championnats')
    ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
    ->join('users','championnat_user.user_id','=','users.id')
    ->where('users.id',Auth::user()->id)
    ->select('championnats.*','championnats.id as idChampionnat')
    ->get();

    $dernierSaison = Saison::max("id");

    // dd($dernierSaison);
    $nC = DB::table('championnats')
    ->join('saisons','championnats.saison_id','=','saisons.id')
    ->where('saisons.id',$dernierSaison)
    ->get();

    $nombreChampionnats = count($nC);

    $nE = DB::table('championnats')
    ->join('saisons','championnats.saison_id','=','saisons.id')
    ->join('equipes','championnats.id','=','equipes.championnat_id')
    ->where('saisons.id',11)
    ->get();

    $nombreEquipes = count($nE);

    

    return view('admin.index',compact('champs','nombreChampionnats','nombreEquipes'));
})->middleware(['auth'])->name('dashboard');

//  Ressource
Route::resource('saisons', SaisonController::class)->middleware(['auth']);
Route::resource('etats', EtatController::class)->middleware(['auth']);
Route::resource('divisions', DivisionController::class)->middleware(['auth']);
Route::resource('championnats', ChampionnatController::class)->middleware(['auth']);
Route::resource('equipes', EquipesController::class)->middleware(['auth']);
Route::resource('journees', JourneesController::class)->middleware(['auth']);
Route::resource('rencontres', RencontresController::class)->middleware(['auth']);
Route::resource('matchs', RencontresController::class)->middleware(['auth']);
Route::resource('infos', PvControlle::class)->middleware(['auth']);
Route::resource('parametres', ParametresController::class)->middleware(['auth']);

/* ressource client */
Route::resource('championnat', ChampionnatControlle::class);
Route::get('/championnat/{saison}/{etat}/{division}', [ChampionnatControlle::class,'getChampionnat']);
Route::post('/search', [ChampionnatControlle::class,'search']);


// End Ressource


Route::get('/championnats/{saison}/{etat}/{division}', [ChampionnatController::class,'getChampionnats'])->middleware(['auth']);
Route::get('/lesRencontres/{id}', [RencontresController::class,'getRencontres']);
Route::get('/repport/{id}', [RencontresController::class,'repport'])->middleware(['auth']);
Route::put('/ajoutScore/{id}/{champ_id}', [MatchsController::class,'ajoutScore'])->middleware(['auth']);
Route::put('/updateScore/{id}/{champ_id}', [MatchsController::class,'updateScore'])->middleware(['auth']);
Route::put('/updateUsersChampionnats/{id}', [UsersController::class,'updateUsersChampionnats'])->name('users_championnats.update')->middleware(['auth']);

Route::get('/options/{idChamp}', [RencontresController::class,'options'])->middleware(['auth']);

Route::put('/add_points/{id}', [EquipesController::class,'addPoints'])->name('addpoints')->middleware(['auth']);
Route::put('/delete_points/{id}', [EquipesController::class,'deletePoints'])->name('deletepoint')->middleware(['auth']);

Route::put('/add_buts/{id}', [EquipesController::class,'addButs'])->name('addbuts')->middleware(['auth']);
Route::put('/delete_buts/{id}', [EquipesController::class,'deleteButs'])->name('deletebut')->middleware(['auth']);

// Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){
    Route::resource('users',UsersController::class)->middleware(['auth']);
    Route::get('/email/{idUser}/{mdp}', [UsersController::class,'envoiEmail'])->middleware(['auth']);

    Route::put('/profil_user/{id}', [UsersController::class,'updateProfil'])->name('updateProfil')->middleware(['auth']);
    Route::put('/email_user/{id}', [UsersController::class,'updateEmail'])->name('updateEmail')->middleware(['auth']);
    Route::put('/edit_mdp/{id}', [UsersController::class,'updateMDP'])->name('updateMDP')->middleware(['auth']);
    
// });
Route::get('/email', [EmailController::class,'sendMail'])->middleware(['auth'])->name('email');
Route::get('/rand', [UsersController::class,'tableauRand'])->middleware(['auth'])->name('tableauRand');

require __DIR__.'/auth.php';
