<?php

namespace App\Http\Controllers\Rencontre;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\Home;
use App\Models\Journee;
use App\Models\Rencontre;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RencontresController extends Controller
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
            'journee' => 'required',
            'lieu' => 'required|min:3',
            'home' => 'required',
            'visiteur' => 'required',
            'date' => 'required',
            'heure' => 'required',
            ],[
                'journee.required' => "La journée de la rencontre est obligatoire !",
                'home.required' => "L'équipe 1 de la rencontre est obligatoire !",
                'visiteur.required' => "L'équipe 2 de la rencontre est obligatoire !",
                'heure.required' => "L'heure de la rencontre est obligatoire !",
                'date.required' => "La date de la rencontre est obligatoire !",
                'lieu.required' => "Le lieu de la rencontre est obligatoire !",
                'lieu.min' => "Le lieu doit être au minimum 3 caractères",
            ]
        );
        $equipeHome = Equipe::find($request->home);
        $equipeVisit = Equipe::find($request->visiteur);
    
        $recontre = new Rencontre();
        $recontre->home = $equipeHome->abreviation;
        $recontre->visit = $equipeVisit->abreviation;
        $recontre->journee_id = $request->journee;
        $recontre->lieu = $request->lieu;
        $recontre->date_ren = $request->date;
        $recontre->heure_ren = $request->heure;
        $recontre->save();

        $home = new Home();

            $home->equipe_id = $request->home;
            $home->buts = 0;
            $home->rencontre_id = $recontre->id;
            $home->save();

        $visit = new Visit();

            $visit->equipe_id = $request->visiteur;
            $visit->buts = 0;
            $visit->rencontre_id = $recontre->id;
            $visit->save();

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

    public function getRencontres($id)
    {
        // $rencontres = DB::table('rencontres')
        // ->join('journees','rencontres.journee_id','=','journees.id')
        // ->whereJourneeId($id)
        // ->select('journees.nom_journee','rencontres.*',DB::raw('DATE_FORMAT(rencontres.date_ren, "%d %b %Y") as dat','DATE_FORMAT(rencontres.heure_ren, "%H:%i") as heure'))
        // // ->select('rencontres.*',DB::raw('DATE_FORMAT(rencontres.date_ren, "%d %b %Y à %H:%i") as dat'))
        // ->orderBy('dat','ASC')
        // ->get();
        dd($id);
        // return response()->json([
        //     'rencontres' => $rencontres
        // ]);
    }

    public function repport($id)
    {
        $ren = Rencontre::find($id);
        $ren->repporter = 1;
        $ren->update();

        return response()->json([
            'status' => "success"
        ]);
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
            'lieu' => 'required|min:3',
            'date' => 'required',
            'heure' => 'required',
            ],[
                'date.required' => "La date de la rencontre est obligatoire !",
                'heure.required' => "L'heure de la rencontre est obligatoire !",
                'lieu.required' => "Le lieu de la rencontre est obligatoire !",
                'lieu.min' => "Le lieu doit être au minimum 3 caractères",
            ]
        );

        $recontre = Rencontre::find($id);
        $recontre->lieu = $request->lieu;
        $recontre->date_ren = $request->date;
        $recontre->heure_ren = $request->heure;
        $recontre->repporter = 0;
        $recontre->update();

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
        $r = Rencontre::find($id);
        $r->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }

    public function options($idChamp)
    {
        $equipes = DB::table('equipes')->whereChampionnatId($idChamp)->get();
        $journees = DB::table('journees')->whereChampionnatId($idChamp)->orderBy('id','desc')->get();

        $nombreJornees = count($journees);

        return response()->json([
            'equipes' => $equipes,
            'journees' => $journees,
            'nombreJournee' => $nombreJornees
        ]);
    }
}
