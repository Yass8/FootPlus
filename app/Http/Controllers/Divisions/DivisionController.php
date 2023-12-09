<?php

namespace App\Http\Controllers\Divisions;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::all();
        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();
        return view('admin.divisions.division', compact('champs','divisions'));
        
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
            'division' => 'required|unique:divisions,nom_division|min:3'
            ],[
                'division.required' => "La division est obligatoire !",
                'division.unique' => "La division saisie existe dans la base !",
                'division.min' => "Le nom de la division doit être au minimum 3 caractères",
            ]
        );
    
            $division = new Division();
            $division->nom_division = $request->division;
            $division->save();
    
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
            'division' => 'required|unique:divisions,nom_division|min:3'
            ],[
                'division.required' => "La division est obligatoire !",
                'division.unique' => "La division saisie existe dans la base !",
                'division.min' => "Le nom de la division doit être au minimum 3 caractères",
            ]
        );

        $division = Division::find($id);
        $division->nom_division = $request->division;
        $division->update();

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
        $dv = Division::find($id);
        $dv->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
}
