<?php

namespace App\Http\Controllers\Championnats;

use App\Models\Equipe;
use App\Models\Saison;
use App\Models\Championnat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Journee;
use App\Models\Parametre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChampionnatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saisons = DB::table('saisons')->orderBy('nom_saison','DESC')->get();
        $etats = DB::table('etats')->get();
        $divisions = DB::table('divisions')->get();

        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();

        return view('admin.championnats.championnat', compact('champs','saisons','etats','divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getChampionnats($saison,$etat,$division){
        $championnats = DB::table('championnats')
        ->whereSaisonId($saison)
        ->whereEtatId($etat)
        ->whereDivisionId($division)
        ->get();
        return response()->json([
            'championnats' => $championnats
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [

            'championnat' => 'required|min:3',
            'saison' => 'required',
            'etat' => 'required',
            'division' => 'required',

            ],[

            'championnat.required' => "Le championnat est obligatoire !",
            'championnat.min' => "Le nom du championnat doit être au minimum 3 caractères",
            'etat.required' => "L'etat est obligatoire !",
            'saison.required' => "La saison est obligatoire !",
            'division.required' => "La division est obligatoire !",

            ]
        );
    
        $champ = new Championnat();
        $champ->cid = uniqid()."".$champ->id;
        $champ->nom_championnat = $request->championnat;
        $champ->saison_id = $request->saison;
        $champ->etat_id = $request->etat;
        $champ->division_id = $request->division;
        $champ->save();

        $param = new Parametre();
        $param->championnat_id = $champ->id;
        $param->save();
        
        return response()->json([
        'status' => "success"
        ]);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $championnat = Championnat::find($id);
        $championnat = DB::table('championnats')
        ->join('saisons','championnats.saison_id','=','saisons.id')
        ->join('etats','championnats.etat_id','=','etats.id')
        ->join('divisions','championnats.division_id','=','divisions.id')
        ->join('parametres','championnats.id','=','parametres.championnat_id')
        ->where('championnats.cid', $id)
        ->select('championnats.*','championnats.id as idChamp','saisons.*','etats.*','divisions.*','parametres.*')
        ->first();

        $equipes = DB::table('equipes')->whereChampionnatId($championnat->id)->get();
        $journees = DB::table('journees')->whereChampionnatId($championnat->id)->orderBy('id','desc')->get();

        $classements = DB::table('classements')
        ->join('equipes','classements.equipe_id','=','equipes.id')
        ->where('classements.championnat_id', $championnat->id)
        ->select('classements.*','equipes.*')
        ->orderBy('classements.Pts','DESC')
        ->orderBy('classements.DF','DESC')
        ->get();

        // $view->with('count', $this->users->count());
        $countJournee = Journee::where('championnat_id', $championnat->id)->count();

        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();

        return view('admin.championnats.showChampionnat', compact('champs','championnat','equipes','journees','classements','countJournee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [

            'championnat' => 'required|min:3',
            'saison' => 'required',
            'etat' => 'required',
            'division' => 'required',

            ],[

            'championnat.required' => "Le championnat est obligatoire !",
            'championnat.min' => "Le nom du championnat doit être au minimum 3 caractères",
            'etat.required' => "L'etat est obligatoire !",
            'saison.required' => "La saison est obligatoire !",
            'division.required' => "La division est obligatoire !",

            ]
        );
    
        $champ = Championnat::find($id);
        $champ->nom_championnat = $request->championnat;
        $champ->saison_id = $request->saison;
        $champ->etat_id = $request->etat;
        $champ->division_id = $request->division;
        $champ->save();

        return response()->json([
        'status' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ch = Championnat::find($id);
        $ch->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
}
