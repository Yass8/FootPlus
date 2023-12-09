<?php

namespace App\Http\Controllers\Saisons;

use App\Models\Saison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SaisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saisons = Saison::orderBy('nom_saison','DESC')->paginate(5);

        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();
        
        return view('admin.saisons.saison', compact('saisons','champs'));
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
        // $valide = Validator::make($request->all(),[
        //     'saison' => 'required'

        // ]);
        //|unique:saisons,saison
        $request->validate(
        [
        'saison' => 'required|unique:saisons,nom_saison|min:9'
        ],[
            'saison.required' => 'La saison est obligatoire !',
            'saison.unique' => 'La saison saisie existe dans la base !',
            'saison.min' => 'Le nom de la saison doit être au minimum 9 caractères',
        ]
        );

        $saison = new Saison();
        $saison->nom_saison = $request->saison;
        $saison->save();

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
        //

        $request->validate(
            [
            'saison' => 'required|unique:saisons,nom_saison|min:9'
            ],[
                'saison.required' => 'La saison est obligatoire !',
                'saison.unique' => 'La saison saisie existe dans la base !',
                'saison.min' => 'Le nom de la saison doit être au minimum 9 caractères',
            ]
        );

        $saison = Saison::find($id);
        $saison->nom_saison = $request->saison;
        $saison->update();

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
        $sa = Saison::find($id);
        $sa->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
    
}
