<?php

namespace App\Http\Controllers\Clients;

use App\Models\Pv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Championnat;

class ChampionnatControlle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getChampionnat($saison,$etat,$division){
        $championnats = DB::table('championnats')->whereSaisonId($saison)->whereEtatId($etat)->whereDivisionId($division)->get();
        return response()->json([
            'championnats' => $championnats
        ]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate(
            [

            'championnat' => 'required',
            'saison' => 'required',
            'etat' => 'required',
            'division' => 'required',

            ],[

            'championnat.required' => "Le championnat est obligatoire !",
            'etat.required' => "L'etat est obligatoire !",
            'saison.required' => "La saison est obligatoire !",
            'division.required' => "La division est obligatoire !",

            ]
        );
        $championnat = DB::table('championnats')
        ->join('saisons','championnats.saison_id','=','saisons.id')
        ->join('etats','championnats.etat_id','=','etats.id')
        ->join('divisions','championnats.division_id','=','divisions.id')
        ->join('parametres','championnats.id','=','parametres.championnat_id')
        ->where('championnats.id', $request->championnat)
        ->select('championnats.*','championnats.id as idChamp','saisons.*','etats.*','divisions.*','parametres.*')
        ->first();

        $classements = DB::table('classements')
        ->join('equipes','classements.equipe_id','=','equipes.id')
        ->where('classements.championnat_id', $request->championnat)
        ->select('classements.*','equipes.*')
        ->orderBy('classements.Pts','DESC')
        ->orderBy('classements.DF','DESC')
        ->get();

        $journees = DB::table('journees')->whereChampionnatId($request->championnat)->get();


        return view('publics.journees',compact('classements','journees','championnat'));
    }

    //search championnat
    public function search(Request $request)
    {
        $mot = $request->mot;

        $champs = Championnat::join('etats','championnats.etat_id','=','etats.id')
        ->join('divisions','championnats.division_id','=','divisions.id')
        ->join('saisons','championnats.saison_id','=','saisons.id')
        ->where('nom_championnat','like','%'.$mot.'%')
        ->orderBy('nom_championnat','ASC')
        ->select('championnats.*','championnats.id as IDchamp','saisons.*','etats.*','divisions.*')
        ->get();
        // dd($champs);
        return response()->json([
            'count' => count($champs),
            'championnats' => $champs
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
        $championnat = DB::table('championnats')
        ->join('saisons','championnats.saison_id','=','saisons.id')
        ->join('etats','championnats.etat_id','=','etats.id')
        ->join('divisions','championnats.division_id','=','divisions.id')
        ->join('parametres','championnats.id','=','parametres.championnat_id')
        ->where('championnats.cid', $id)
        ->select('championnats.*','championnats.id as idChamp','saisons.*','etats.*','divisions.*','parametres.*')
        ->first();

        $classements = DB::table('classements')
        ->join('equipes','classements.equipe_id','=','equipes.id')
        ->where('classements.championnat_id', $championnat->idChamp)
        ->select('classements.*','equipes.*')
        ->orderBy('classements.Pts','DESC')
        ->orderBy('classements.DF','DESC')
        ->get();

        $journees = DB::table('journees')->whereChampionnatId($championnat->idChamp)->get();

        $msgs = Pv::where('championnat_id',$championnat->idChamp)->orderBy('id','DESC')->get();
        $countMsg = count($msgs);

        return view('publics.journees',compact('classements','journees','championnat','msgs','countMsg'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
