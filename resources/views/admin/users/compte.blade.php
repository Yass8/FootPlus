@extends('layouts.dash.dashboard')
@section('titre', 'Mon compte')
@section('Title', $user->nom." ".$user->prenom." - FFC")

@section('content')
<input type="hidden" id="idUser" value="{{$user->id}}">
<div class="row">
    <div class="col-md-12">
        


        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="card">
                    <div class="card-body d-block">
                         <h3>Informations de mon compte</h3>
                         {{-- <button class="btn btn-info float-end">Ajouter un utilisateur</button> --}}
                    </div>
                    <div class="card-footer p-4">
                        <div class="d-flex justify-content-center">
                            <div class="container col-md-6 p-5" style="box-shadow: 1px 1px 2px 1px rgb(145, 143, 143)">
                                <table class="table">
                                    <tr>
                                        <td>Nom</td>
                                        <td>: <strong>{{$user->nom}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Prénom</td>
                                        <td>: <strong>{{$user->prenom}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>: <strong>{{$user->email}}</strong></td>
                                    </tr>
                                </table>
                                <div class="text-center mt-5">
                                    <a href="" class="btn btn-sm btn-info m-2" data-bs-toggle="modal" data-bs-target="#modalMettreAJour">Mettre à jour mon profil</a>
                                    <a href="" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalMDP">Modifier le mot de passe</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>



<!-- Modal Mettre à jour mon profil -->
<div class="modal fade" id="modalMettreAJour" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mise à jour du profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="EditProfil">
                    @csrf

                    <ul id="LaListeErreurs"></ul>

                    <div class="mb-3">
                      <label for="nom" class="form-label">Nom</label>
                      <input type="text" class="form-control nom" name="nom" id="" aria-describedby="helpId" value="{{$user->nom}}">
                      <small id="helpId" class="form-text text-muted"></small>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control prenom" name="prenom" id="" aria-describedby="helpId" value="{{$user->prenom}}">
                        <small id="helpId" class="form-text text-muted"></small>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button> --}}
                        <button type="button" class="btn btn-info BtnMettreAJour">Mettre à jour mon profil</button>
                    </div><hr>
                    <ul id="LaListeErreursEmail"></ul>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control email" name="email" id="" aria-describedby="helpId" value="{{$user->email}}">
                        <small id="helpId" class="form-text text-muted"></small>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button> --}}
                        <button type="button" class="btn btn-info BtnMettreAJourEmail">Mettre à jour l'email</button>
                    </div>
                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-info BtnMettreAJour">Mettre à jour</button>
            </div> --}}
        </div>
    </div>
</div>

<!-- Modifier le mot de passe -->
<div class="modal fade" id="modalMDP" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mise à jour du profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="EditMDP">
                    @csrf

                    <ul id="LaListeErreursMDP"></ul>

                    <div class="mb-3">
                      <label for="mdp" class="form-label">Mot de passe actuel</label>
                      <input type="password" class="form-control mdp" name="mdp" id="">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control new_mdp1" name="prenom" id="">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Confirmer mot de passe</label>
                        <input type="password" class="form-control new_mdp2" name="prenom" id="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-info btnModifMDP">Modifier</button>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scriptJs')
<script>
$(document).ready(function () {

    //Modifier le mot de passe
    $(".btnModifMDP").click(function (e) { 
        e.preventDefault();
        
        let mdp = $(".mdp").val();
        let new_mdp1 = $(".new_mdp1").val();
        let new_mdp2 = $(".new_mdp2").val();

        var datas = {
            "_token": "{{ csrf_token() }}",
            'mdp' : mdp,
            'new_mdp' : new_mdp1,
            'conf_mdp' : new_mdp2
        }

        requete("PUT","/edit_mdp/"+$('#idUser').val(),datas,(res)=>{
            if(res.status == 'success')
            {
                $('#LaListeErreursMDP').html("");
                $('#LaListeErreursMDP').removeClass('alert alert-danger');
                $('#EditMDP')[0].reset();
                $('#modalMDP').modal('hide');

                toast(res.message);

                window.location.href = "/users/"+$('#idUser').val();

            }
            if (res.status == 'erreur') {
                $('#LaListeErreursMDP').html("");
                $('#LaListeErreursMDP').addClass('alert alert-danger');
                $('#LaListeErreursMDP').append('<li>'+res.message+'</li>');

            }
            if ("errors" in res) {
                $('#LaListeErreursMDP').html("");
                $('#LaListeErreursMDP').addClass('alert alert-danger');

                $.each(res.errors, function(key, err_values) {
                    $('#LaListeErreursMDP').append('<li>'+err_values+'</li>');
                });
            }
        });

    });


   //modification Utilitilisateur
   $(document).on('click', '.BtnMettreAJour', function(e){
        e.preventDefault();
        var datas = {
            "_token": "{{ csrf_token() }}",
            'nom' : $('.nom').val(),
            'prenom' : $('.prenom').val()
        }

        requete("PUT","/profil_user/"+$('#idUser').val(),datas,(res)=>{
            if(res.status == 'success')
            {
                $('#LaListeErreurs').html("");
                $('#LaListeErreurs').removeClass('alert alert-danger');
                $('#EditProfil')[0].reset();
                $('#modalMettreAJour').modal('hide');
                // $('.table').load(location.href+' .table');

                toast("Mise à jour éffectuer avec succès !");

                window.location.href = "/users/"+$('#idUser').val();

            }
            if ("errors" in res) {
                $('#LaListeErreurs').html("");
                $('#LaListeErreurs').addClass('alert alert-danger');

                $.each(res.errors, function(key, err_values) {
                        $('#LaListeErreurs').append('<li>'+err_values+'</li>');
                });
            }
        });

    });
    
    
    //modification Email
   $(document).on('click', '.BtnMettreAJourEmail', function(e){
        e.preventDefault();
        var datas = {
            "_token": "{{ csrf_token() }}",
            'email': $('.email').val()
        }

        requete("PUT","/email_user/"+$('#idUser').val(),datas,(res)=>{
            if(res.status == 'success')
            {
                $('#LaListeErreursEmail').html("");
                $('#LaListeErreursEmail').removeClass('alert alert-danger');
                $('#EditProfil')[0].reset();
                $('#modalMettreAJour').modal('hide');
                // $('.table').load(location.href+' .table');

                toast("Mise à jour éffectuer avec succès !");

                window.location.href = "/users/"+$('#idUser').val();

            }
            if ("errors" in res) {
                $('#LaListeErreursEmail').html("");
                $('#LaListeErreursEmail').addClass('alert alert-danger');

                $.each(res.errors, function(key, err_values) {
                        $('#LaListeErreursEmail').append('<li>'+err_values+'</li>');
                });
            }
        });

    });
});
</script>
@endsection