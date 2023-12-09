<?php

namespace App\Http\Controllers\Equipes;

use App\Models\Equipe;
use App\Models\Classement;
use App\Models\Championnat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EquipesController extends Controller
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
            'equipe' => 'required|min:3',
            'abrev' => 'required|min:3',
            ],[
                'equipe.required' => "L'équipe est obligatoire !",
                'equipe.min' => "Le nom de l'équipe doit être au minimum 3 caractères",
                'abrev.required' => "L'abreviation est obligatoire !",
                'abrev.min' => "L'abréviation doit être au minimum 3 caractères",
            ]
        );

        $equipe = new Equipe();
        $equipe->ref_equipe = $equipe->id."".uniqid();
        $equipe->nom_equipe = $request->equipe;
        $equipe->abreviation = $request->abrev;
        $equipe->championnat_id = $request->champ_id;
        $equipe->save();


        $classm = new Classement();
        $classm->equipe_id = $equipe->id;
        $classm->championnat_id = $request->champ_id;
        $classm->save();

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
        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();
        
        $equipe = DB::table('equipes')
        ->join('championnats','equipes.championnat_id','=','championnats.id')
        ->join('classements','equipes.id','=','classements.equipe_id')
        ->where('equipes.ref_equipe',$id)
        ->select('equipes.*','equipes.id as idEquipe','championnats.*','classements.*')
        ->first();

        return view('admin.equipes.showEquipe', compact('equipe','champs'));
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
            'equipe' => 'required|min:3',
            'abrev' => 'required|min:3',
            ],[
                'equipe.required' => "L'équipe est obligatoire !",
                'equipe.min' => "Le nom de l'équipe doit être au minimum 3 caractères",
                'abrev.required' => "L'abreviation est obligatoire !",
                'abrev.min' => "L'abréviation doit être au minimum 3 caractères",
            ]
        );
    
        $equipe = Equipe::find($id);
        $equipe->nom_equipe = $request->equipe;
        $equipe->abreviation = $request->abrev;
        $equipe->update();

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
        $eq = Equipe::find($id);
        $eq->delete();

        $cl = Classement::where('equipe_id', $id);
        $cl->delete();

        return response()->json([
            'status'=>'success'
        ]);
    }


    public function addPoints(Request $requ, $id)
    {
        $requ->validate(
            [
            'points' => 'required',
            ],[
                'points.required' => "Les points sont obligatoire !"
            ]
        );
        $cla = Classement::where('equipe_id',$id)->first();
        $cla->Pts = $cla->Pts + $requ->points;
        $cla->update();

        return response()->json([
            'status'=>'success',
            'points' => $cla
        ]);
    }

    public function deletePoints(Request $requ, $id)
    {
        $requ->validate(
            [
            'points' => 'required',
            ],[
            'points.required' => "Les points sont obligatoire !"
            ]
        );
        $cla = Classement::where('equipe_id',$id)->first();
        $cla->Pts = $cla->Pts - $requ->points;
        $cla->update();

        return response()->json([
            'status'=>'success',
            'points' => $cla
        ]);
    }


    public function addButs(Request $reque, $id)
    {
        $reque->validate(
            [
            'buts' => 'required',
            ],[
                'buts.required' => "Les buts sont obligatoire !"
            ]
        );
        $cla = Classement::where('equipe_id',$id)->first();
        $cla->DF = $cla->DF + $reque->buts;
        $cla->update();

        return response()->json([
            'status'=>'success',
            'buts' => $cla
        ]);
    }

    public function deleteButs(Request $reque, $id)
    {
        $reque->validate(
            [
            'buts' => 'required',
            ],[
                'buts.required' => "Les buts sont obligatoire !"
            ]
        );
        $cla = Classement::where('equipe_id',$id)->first();
        $cla->DF = $cla->DF - $reque->buts;
        $cla->update();

        return response()->json([
            'status'=>'success',
            'buts' => $cla
        ]);        

    }
}
