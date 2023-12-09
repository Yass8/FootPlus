<?php

namespace App\Http\Controllers\Matchs;

use App\Http\Controllers\Controller;
use App\Models\Home;
use App\Models\Rencontre;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchsController extends Controller
{

    public function ajoutScore(Request $request,$id,$champ_id)
    {
        $request->validate(
            [
            'buts_home' => 'required',
            'buts_visit' => 'required'
            ],[
                'buts_home.required' => "Le score de l'équipe home est obligatoire !",
                'buts_visit.required' => "Le score de l'équipe visiteur est obligatoire !",
            ]
        );
        $score = Rencontre::find($id);
        $score->buts_home = $request->buts_home;
        $score->buts_visit = $request->buts_visit;
        $score->jouer = 1;
        $score->update();

        //Select id équipes Joués
        $idEquipeHomeSel = DB::table('homes')->whereRencontreId($id)->select('homes.equipe_id')->first();
        $idEquipeVisitSel = DB::table('visits')->whereRencontreId($id)->select('visits.equipe_id')->first();

        $idEquipeHome = $idEquipeHomeSel->equipe_id;
        $idEquipeVisit = $idEquipeVisitSel->equipe_id;

        // echo $idEquipeHome."  ".$idEquipeVisit;

        //update Classement
        $but1 = $request->buts_home;$but2 = $request->buts_visit;
        if ($but1==$but2) {
            $this->MatchNul($idEquipeHome,$champ_id,$but1,$but2);   
            $this->MatchNul($idEquipeVisit,$champ_id,$but1,$but2);   
        }
        if ($but1>$but2) {
            $this->equipeGagnee($idEquipeHome,$champ_id,$but1,$but2);
            $this->equipePerdue($idEquipeVisit,$champ_id,$but2,$but1);
        }
        if ($but1<$but2) {
            $this->equipeGagnee($idEquipeVisit,$champ_id,$but2,$but1);
            $this->equipePerdue($idEquipeHome,$champ_id,$but1,$but2);
        }

        return response()->json([
            'status' => "success"
        ]);
    }


    
    private function equipeGagnee($idEquipe,$idChamp,$butsM,$butsEn)
    {
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
      
        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MJ' => $eq->MJ + 1,
            'MG' => $eq->MG + 1,
            'BM' => $eq->BM + $butsM,
            'BE' => $eq->BE + $butsEn,
            'DF' => ($eq->BM + $butsM) - ($eq->BE + $butsEn),
            'Pts' => $eq->Pts + 3
        ]);
    }

    private function equipePerdue($idEquipe,$idChamp,$butsM,$butsEn)
    {
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
        
        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MJ' => $eq->MJ + 1,
            'MP' => $eq->MP + 1,
            'BM' => $eq->BM + $butsM,
            'BE' => $eq->BE + $butsEn,
            'DF' => ($eq->BM + $butsM) - ($eq->BE + $butsEn)
        ]);
    }

    private function MatchNul($idEquipe,$idChamp,$butsM,$butsEn)
    {
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)->first();

        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MJ' => $eq->MJ + 1,
            'MN' => $eq->MN + 1,
            'BM' => $eq->BM + $butsM,
            'BE' => $eq->BE + $butsEn,
            'DF' => ($eq->BM + $butsM) - ($eq->BE + $butsEn),
            'Pts' => $eq->Pts + 1
        ]);
    }

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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idEquipeHomeSel = DB::table('homes')->whereRencontreId($id)->select('homes.equipe_id')->first();
        $idEquipeVisitSel = DB::table('visits')->whereRencontreId($id)->select('visits.equipe_id')->first();

        $idEquipeHome = $idEquipeHomeSel->equipe_id;
        $idEquipeVisit = $idEquipeVisitSel->equipe_id;

        $score = Rencontre::find($id);
        if ($score->buts_home > $score->buts_visit) {
            $this->effacePointsGagnesSup($idEquipeHome,$score->buts_home,$score->buts_visit);
            $this->ajoutPointsPerduitsSup($idEquipeVisit,$score->buts_visit,$score->buts_home);
        }
        if ($score->buts_home < $score->buts_visit) {
            $this->effacePointsGagnesSup($idEquipeVisit,$score->buts_visit,$score->buts_home);
            $this->ajoutPointsPerduitsSup($idEquipeHome,$score->buts_home,$score->buts_visit);
        }
        if ($score->buts_home === $score->buts_visit) {
            $this->effacePointsNulsSup($idEquipeHome,$score->buts_visit);
            $this->effacePointsNulsSup($idEquipeVisit,$score->buts_visit);
        }
        $score->delete();
        
        $hom = Home::find($idEquipeHome);
        $hom->delete();

        $vis = Visit::find($idEquipeVisit);
        $vis->delete();
    }


    public function updateScore(Request $request,$id,$champ_id)
    {
        $request->validate(
            [
            'buts_home' => 'required',
            'buts_visit' => 'required'
            ],[
                'buts_home.required' => "Le score de l'équipe home est obligatoire !",
                'buts_visit.required' => "Le score de l'équipe visiteur est obligatoire !",
            ]
        );

        //Select id équipes Joués
        $idEquipeHomeSel = DB::table('homes')->whereRencontreId($id)->select('homes.equipe_id')->first();
        $idEquipeVisitSel = DB::table('visits')->whereRencontreId($id)->select('visits.equipe_id')->first();

        $idEquipeHome = $idEquipeHomeSel->equipe_id;
        $idEquipeVisit = $idEquipeVisitSel->equipe_id;

        $score = Rencontre::find($id);
        if ($score->buts_home > $score->buts_visit) {
            $this->effacePointsGagnes($idEquipeHome,$champ_id,$score->buts_home,$score->buts_visit);
            $this->ajoutPointsPerduits($idEquipeVisit,$champ_id,$score->buts_visit,$score->buts_home);
        }
        if ($score->buts_home < $score->buts_visit) {
            $this->effacePointsGagnes($idEquipeVisit,$champ_id,$score->buts_visit,$score->buts_home);
            $this->ajoutPointsPerduits($idEquipeHome,$champ_id,$score->buts_home,$score->buts_visit);
        }
        if ($score->buts_home === $score->buts_visit) {
            $this->effacePointsNuls($idEquipeHome,$champ_id,$score->buts_visit);
            $this->effacePointsNuls($idEquipeVisit,$champ_id,$score->buts_visit);
        }
        $score->buts_home = $request->buts_home;
        $score->buts_visit = $request->buts_visit;
        $score->jouer = 1;
        $score->update();

        

        // echo $idEquipeHome."  ".$idEquipeVisit;

        //update Classement
        $but1 = $request->buts_home;$but2 = $request->buts_visit;
        if ($but1==$but2) {
            $this->updateMatchNul($idEquipeHome,$champ_id,$but1,$but2);   
            $this->updateMatchNul($idEquipeVisit,$champ_id,$but1,$but2);   
        }
        if ($but1>$but2) {
            $this->updateEquipeGagnee($idEquipeHome,$champ_id,$but1,$but2);
            $this->updateEquipePerdue($idEquipeVisit,$champ_id,$but2,$but1);
        }
        if ($but1<$but2) {
            $this->updateEquipeGagnee($idEquipeVisit,$champ_id,$but2,$but1);
            $this->updateEquipePerdue($idEquipeHome,$champ_id,$but1,$but2);
        }

        return response()->json([
            'status' => "success"
        ]);
    }

//Pour les modifs du classement
    private function effacePointsGagnes($idEquipe,$idChamp,$butsM,$butsEn){
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
      
        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MG' => $eq->MG - 1,
            'BM' => $eq->BM - $butsM,
            'BE' => $eq->BE - $butsEn,
            'DF' => ($eq->BM - $butsM) - ($eq->BE - $butsEn),
            'Pts' => $eq->Pts - 3
        ]);
    }

    private function ajoutPointsPerduits($idEquipe,$idChamp,$butsM,$butsEn){
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
      
        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MP' => $eq->MP - 1,
            'BM' => $eq->BM - $butsM,
            'BE' => $eq->BE - $butsEn,
            'DF' => ($eq->BM - $butsM) - ($eq->BE - $butsEn),
            // 'Pts' => $eq->Pts - 3
        ]);
    }

    private function effacePointsNuls($idEquipe,$idChamp,$butsM){
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
      
        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MN' => $eq->MN - 1,
            'BM' => $eq->BM - $butsM,
            'BE' => $eq->BE - $butsM,
            'DF' => ($eq->BM - $butsM) - ($eq->BE - $butsM),
            'Pts' => $eq->Pts - 1
        ]);
    }
    
    private function updateEquipeGagnee($idEquipe,$idChamp,$butsM,$butsEn)
    {
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
      
        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MG' => $eq->MG + 1,
            'BM' => $eq->BM + $butsM,
            'BE' => $eq->BE + $butsEn,
            'DF' => ($eq->BM + $butsM) - ($eq->BE + $butsEn),
            'Pts' => $eq->Pts + 3
        ]);
    }

    

    private function updateEquipePerdue($idEquipe,$idChamp,$butsM,$butsEn)
    {
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
        
        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MP' => $eq->MP + 1,
            'BM' => $eq->BM + $butsM,
            'BE' => $eq->BE + $butsEn,
            'DF' => ($eq->BM + $butsM) - ($eq->BE + $butsEn)
        ]);
    }

    private function updateMatchNul($idEquipe,$idChamp,$butsM,$butsEn)
    {
        $eq = DB::table('classements')->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)->first();

        DB::table('classements')
        ->whereEquipeId($idEquipe)->whereChampionnatId($idChamp)
        ->update([
            'MN' => $eq->MN + 1,
            'BM' => $eq->BM + $butsM,
            'BE' => $eq->BE + $butsEn,
            'DF' => ($eq->BM + $butsM) - ($eq->BE + $butsEn),
            'Pts' => $eq->Pts + 1
        ]);
    }






// Pour les modifs du classement d'une supression d'un match

private function effacePointsGagnesSup($idEquipe,$butsM,$butsEn){
    $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
  
    DB::table('classements')
    ->whereEquipeId($idEquipe)
    ->update([
        'MG' => $eq->MG - 1,
        'BM' => $eq->BM - $butsM,
        'BE' => $eq->BE - $butsEn,
        'DF' => ($eq->BM - $butsM) - ($eq->BE - $butsEn),
        'Pts' => $eq->Pts - 3
    ]);
}

private function ajoutPointsPerduitsSup($idEquipe,$butsM,$butsEn){
    $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
  
    DB::table('classements')
    ->whereEquipeId($idEquipe)
    ->update([
        'MP' => $eq->MP - 1,
        'BM' => $eq->BM - $butsM,
        'BE' => $eq->BE - $butsEn,
        'DF' => ($eq->BM - $butsM) - ($eq->BE - $butsEn),
        // 'Pts' => $eq->Pts - 3
    ]);
}

private function effacePointsNulsSup($idEquipe,$butsM){
    $eq = DB::table('classements')->whereEquipeId($idEquipe)->first();
  
    DB::table('classements')
    ->whereEquipeId($idEquipe)
    ->update([
        'MN' => $eq->MN - 1,
        'BM' => $eq->BM - $butsM,
        'BE' => $eq->BE - $butsM,
        'DF' => ($eq->BM - $butsM) - ($eq->BE - $butsM),
        'Pts' => $eq->Pts - 1
    ]);
}

}