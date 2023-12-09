<?php

namespace App\Http\Controllers\Etats;

use App\Models\Etat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EtatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etats = Etat::all();
        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();
        return view('admin.etats.etat', compact('etats','champs'));
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
        $request->validate(
            [
            'etat' => 'required|unique:etats,nom_etat|min:3'
            ],[
                'etat.required' => "L'etat est obligatoire !",
                'etat.unique' => "L'etat saisie existe dans la base !",
                'etat.min' => "Le nom de l'etat doit être au minimum 9 caractères",
            ]
            );
    
            $etat = new Etat();
            $etat->nom_etat = $request->etat;
            $etat->save();
    
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
        //
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
            'etat' => 'required|unique:etats,nom_etat|min:3'
            ],[
                'etat.required' => "L'etat est obligatoire !",
                'etat.unique' => "L'etat saisie existe dans la base !",
                'etat.min' => "Le nom de l'etat doit être au minimum 9 caractères",
            ]
        );

        $etat = Etat::find($id);
        $etat->nom_etat = $request->etat;
        $etat->update();

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
        $et = Etat::find($id);
        $et->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
}
