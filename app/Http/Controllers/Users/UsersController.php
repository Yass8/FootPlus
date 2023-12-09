<?php

namespace App\Http\Controllers\Users;

use App\Models\Role;
use App\Models\User;
use App\Mail\TestMail;
use App\Models\Saison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Email\EmailController;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (Auth::user()->hasRole) {
        //     # code...
        // }
        $users = User::orderBy('id','ASC')->paginate(10);
        $users = User::orderBy('id','ASC')->get();
        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();

        return view('admin.users.listeUsers', compact('users','champs'));
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
        // dd($request->email);
        $request->validate(
            [

            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|unique:users,email',

            ],[

            'nom.required' => "Le nom est obligatoire !",
            'prenom.required' => "Le prénom est obligatoire !",
            'email.required' => "L'émail est obligatoire !",
            'email.unique' => "L'émail déjà existe, essayer un autre",

            ]
        );
    
        $alpha = array_merge(range('a','z'), range('A','Z'));
        
        shuffle($alpha);
        $mdp = substr(implode($alpha), 0, 8);


        $useer = new User();
        $useer->nom = $request->nom;
        $useer->prenom = $mdp;
        $useer->email = $request->email;

        
        $useer->password = Hash::make($mdp);
        //$useer->save();

        Mail::to("yassirali2015@gmail.com")->send(new TestMail());

        // $mail = new EmailController();

        // $mail->de;

        return response()->json([
            'status' => "success",
            'idUser' => $useer->id,
            'mdp' => $mdp
        ]);
    }

    /**
     * Envoie un émail apr
     *
     * @return void
     */
    public function envoiEmail($idUser,$mdp)
    {
        $user = User::find($idUser);
        $roles = Role::all();

        return view('admin.users.sendMail', compact('user','mdp','roles'));
    }

    public function tableauRand()
    {
        
        $alpha = array_merge(range('a','z'), range('A','Z'));
        
        shuffle($alpha);
        return substr(implode($alpha), 0, 8);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);


        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();

        return view('admin.users.compte', compact('user','champs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*if (Gate::denies('edit-users')) {
            return redirect()->route('users.index');
        }*/
        $maxSaison = Saison::max('id');
        $championnats = DB::table('championnats')
        ->join('saisons','championnats.saison_id','=','saisons.id')
        ->where('championnats.saison_id',$maxSaison)
        ->select('championnats.*','saisons.*','championnats.id as idChamp')
        ->orderBy('nom_championnat','ASC')->get();

        // $championnatsUsers = DB::table('championnats')
        // ->join('saisons','championnats.saison_id','=','saisons.id')
        // ->where('championnats.saison_id',$maxSaison)
        // ->where('')
        // ->select('championnats.*','saisons.*','championnats.id as idChamp')
        // ->orderBy('nom_championnat','ASC')->get();

        $user = User::find($id);
        
        $roles = Role::all();

        $saisons = DB::table('saisons')->orderBy('nom_saison','DESC')->get();
        $etats = DB::table('etats')->get();
        $divisions = DB::table('divisions')->get();

        $champs = DB::table('championnats')
        ->join('championnat_user','championnats.id','=','championnat_user.championnat_id')
        ->join('users','championnat_user.user_id','=','users.id')
        ->where('users.id',Auth::user()->id)
        ->select('championnats.*','championnats.id as idChampionnat')
        ->get();

        return view('admin.users.editUsers', compact('user','roles','championnats','champs','saisons','etats','divisions'));
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
        $user = User::find($id);

        $user->roles()->sync($request->roles);
        
        Session::flash("roleOK","Mise à jour des rôles éffectuée avec succès !");

        return redirect()->route('users.edit', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfil(Request $request, $id)
    {
        $request->validate(
            [
            'nom' => 'required',
            'prenom' => 'required'
            ],[
                'nom.required' => 'Le nom est obligatoire !',
                'prenom.required' => 'Le prénom est obligatoire !'                
            ]
        );

        $user = User::find($id);

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->update();

        return response()->json([
            'status' => "success"
        ]);
    }

    public function updateEmail(Request $req, $id)
    {
        $req->validate(
            [
            'email' => 'required|unique:users,email'
            ],[
                'email.required' => 'L\' émail est obligatoire !',
                'email.unique' => 'L\' émail saisi est déjà utlisé !',
                
            ]
        );

        $user = User::find($id);

        $user->email = $req->email;
        $user->update();

        return response()->json([
            'status' => "success"
        ]);
    }

    public function updateMDP(Request $request, $id)
    {
        $request->validate(
            [
            'mdp' => 'required',
            'new_mdp' => 'required|min:8',
            'conf_mdp' => 'required',
            ],[
                'mdp.required' => 'Le mot de passe actuel est obligatoire !',
                'new_mdp.required' => 'Le nouveau mot de passe est obligatoire !',
                'conf_mdp.required' => 'Le mot de passe de confirmation est obligatoire !',
                'new_mdp.min' => 'Le mot de passe doit être au minimum 8 caractères !',                
            ]
        );

        $user = User::find($id);

        $mdp = $request->mdp;

        $status = "";
        $message = "";

        if (Hash::check($mdp, $user->password)) {
            if ($request->new_mdp == $request->conf_mdp) {
                $user->password = Hash::make($request->new_mdp);
                $user->update();
                $status = "success";
                $message = "Modification du mot de passe réussi !";
            }else{
                $status = "erreur";
                $message = "Les mots de passe ne sont pas identiques";
            }
        } else {
            $status = "erreur";
            $message = "Le mot de passe est incorrect";
        }


        return response()->json([
            'status'=> $status,
            'message' => $message
        ]);

    }

    public function updateUsersChampionnats(Request $req, $id)
    {
        $user = User::find($id);

        $user->championnats()->sync($req->championnats);
        
        Session::flash("msOK","Mise à jour éffectuée avec succès !");

        return redirect()->route('users.edit',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $us = User::find($id);
        $us->roles()->detach();
        $us->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
}
