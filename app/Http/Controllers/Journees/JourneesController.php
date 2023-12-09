<?php

namespace App\Http\Controllers\Journees;

use App\Http\Controllers\Controller;
use App\Models\Journee;
use Illuminate\Http\Request;

class JourneesController extends Controller
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
        /*$request->validate(
            [
            'journee' => 'required|min:8',
            ],[
                'journee.required' => "La journée est obligatoire !",
                'journee.min' => "La journée doit être au minimum 8 caractères",
            ]
        );*/

        $countJournee = Journee::where('championnat_id', $request->champ_id)->count();
    
        $journee = new Journee();
        $journee->nom_journee = "Journée ".$countJournee + 1;
        $journee->championnat_id = $request->champ_id;
        $journee->save();

        $newCountJournee = Journee::where('championnat_id', $request->champ_id)->count();
        

        return response()->json([
        'status' => "success",
        'countJournee' => $newCountJournee
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
            'journee' => 'required|min:8',
            ],[
                'journee.required' => "La journée est obligatoire !",
                'journee.min' => "La journée doit être au minimum 8 caractères",
            ]
        );
    
        $journee = Journee::find($id);
        $journee->nom_journee = $request->journee;
        $journee->update();

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
        $jr = Journee::find($id);
        $jr->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
}
