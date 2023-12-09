<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Models\Parametre;
use Illuminate\Http\Request;

class ParametresController extends Controller
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
        //
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
            'nombre' => 'required',
            'position' => 'required',
            ],[
                'nombre.required' => "Le nombre d'équipe est obligatoire !",
                'position.required' => "La position est obligatoire !"
            ]
        );
    
        $p = Parametre::where('championnat_id',$id)->first();
        $p->nombre_equipes_montes = $request->nombre;
        $p->position_descente = $request->position;
        $p->officiel = $request->officiel;
        $p->save();

        $officiel = "provisoir";
        if ($p->officiel == 1) {
            $officiel = "officiel";
        }

        return response()->json([
            'status' => "success",
            'officiel' => $officiel
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
        //
    }
}
