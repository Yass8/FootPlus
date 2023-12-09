@extends('layouts.dash.dashboard')
@section('titre', $user->nom." ". $user->prenom)
@section('Title', "Utilisateurs - FFC")

@section('content')
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#ModalEditProfilUser">Voir son profil</button>
<div class="modal fade" id="ModalEditProfilUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Profil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <ul id="errAddUser"></ul>
                    <form action="" method="post" id="FormAddUser">
                        <div class="mb-3">
                          <label for="" class="form-label">Nom</label>
                          <input type="text" class="form-control nom" name="" id="" value="{{$user->nom}}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Prénom</label>
                            <input type="text" class="form-control prenom" name="" id="" value="{{$user->prenom}}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control email" name="" id="" value="{{$user->email}}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-info btnADD">Ajouter l'utilisateur</button> --}}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        @if (Session::has('roleOK'))
            <p class="alert alert-success">{{ Session::get("roleOK") }}</p>
        @endif
        <div class="card mb-4">
            <div class="card-body">Modifier les rôles de <strong> {{ $user->nom }} {{ $user->prenom }}</strong></div>
            <div class="card-footer d-fle align-items-center justify-content-between">
                <form action="{{route('users.update', $user->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    @foreach ($roles as $role)
                        <div class="form-group form-check">
                            <input type="checkbox" name="roles[]" id="{{$role->id}}" value="{{$role->id}}"
                            @foreach ($user->roles as $userRoles)
                                @if ($userRoles->id === $role->id)
                                    checked
                                @endif
                            @endforeach
                            >
                            <label for="{{$role->id}}" class="form-check-label">{{$role->nom_role}}</label>
                        </div>
                    @endforeach
                    <input type="submit" value="Modifier les rôles" class="btn btn-info mt-3">
                </form>
            </div>
        </div>
    </div>
</div>

{{-- @foreach ($user->roles as $userRoles)
    @if ($userRoles->id === $role->id)
       {{ $userRoles->nom_role }}
    @endif
@endforeach --}}

@foreach ($user->roles as $userRoles)
    @if ($userRoles->id === $role->id)

        @if (Session::has('msOK'))
            <p class="col-md-7 alert alert-success">{{ Session::get("msOK") }}</p>
        @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-body">Affectation d'un championnat</div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <p>En tant que Chager d'une(des) compétition(s), Choisir le(s) championnat(s) pour lui affecter.</p>
                    <form action="{{route('users_championnats.update', $user->id)}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Saison</label>
                                    <select class="form-control lesaison" name="" id="saison">
                                      @foreach ($saisons as $saison)
                                      <option value="{{ $saison->id }}">{{ $saison->nom_saison }}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Etat</label>
                                    <select class="form-control letat" name="" id="etat">
                                        @foreach ($etats as $etat)
                                        <option value="{{ $etat->id }}">{{ $etat->nom_etat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Division</label>
                                    <select class="form-control ladivision" name="" id="division">
                                        @foreach ($divisions as $div)
                                        <option value="{{ $div->id }}">{{ $div->nom_division }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="championnat">
                            @foreach ($championnats as $key=>$champ)
                                <div class="form-group form-check">
                                    <input type="checkbox" name="championnats[]" id="" value="{{$champ->idChamp}}"
                                    @foreach ($user->championnats as $userChamp)
                                        @if ($userChamp->id === $champ->idChamp)
                                            checked
                                        @endif
                                    @endforeach
                                    >
                                    <label for="" class="form-check-label">{{$champ->nom_championnat}}</label>
                                </div>
                            @endforeach
                        </div>
                        <div id="submi">
                         <input type="submit" value="Affecter" class="btn btn-info mt-3 btnAffecter">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (count($user->championnats) > 0)
        
    
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-body">Désaffection d'un championnat</div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <h5>Liste des championnats affectés à l'utilisateur.</h5>
                    <p>Décocher pour détacher  l'utilisateur du championnat.</p>
                    <form action="{{route('users_championnats.update', $user->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        @foreach ($user->championnats as $userChamp)
                        <div class="form-group form-check">
                            <input type="checkbox" name="championnats[]" id="" value="{{$userChamp->id}}" checked>
                            <label for="" class="form-check-label">{{$userChamp->nom_championnat}}</label>
                        </div>
                            {{-- @if ($userChamp->id === $champ->idChamp)
                                checked
                            @endif --}}
                        @endforeach
                        <input type="submit" value="Détacher" class="btn btn-warning mt-3">
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
@endforeach


{{-- @include('admin.users.edituser') --}}
@endsection
@section('scriptJs')
<script>
    $(document).ready(function(){

        clickSelect();

        function clickSelect() {
            $(document).on('click', '#saison' , function(e){
                e.preventDefault();
                var saison = $(this).val();
                var etat = $('#etat').val();
                var division = $('#division').val();
                liste(saison,etat,division);

                
            });

            $(document).on('click', '#etat' , function(e){
                e.preventDefault();
                var etat = $(this).val();
                var saison = $('#saison').val();
                var division = $('#division').val();
                liste(saison,etat,division);

                
            });

            $(document).on('click', '#division' , function(e){
                e.preventDefault();
                var saison = $('#saison').val();
                var etat = $('#etat').val();
                var division = $(this).val();
                liste(saison,etat,division);

                
            });

        }

        function liste(saison,etat,division){

            var datas = {
                'saison' : saison, 
                'etat' : etat, 
                'division' : division, 
            }
            // console.log(datas);
            $.ajax({
                type: "GET",
                url: "/championnat/"+saison+"/"+etat+"/"+division,
                data: datas,
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    $('#championnat').html("");
                    $('#submi').html("");
                    $.each(response.championnats, function(key, champs) {
                        //$('#championnat').append('<option value="'+champs.cid+'">'+champs.nom_championnat+'</option>');
                        $("#championnat").append(`<div class="form-group form-check">
                            <input type="checkbox" name="championnats[]" class="boxCheck" id="champi${champs.id}" value="${champs.id}"
                            >
                            <label for="champi${champs.id}" class="form-check-label">${champs.nom_championnat}</label>
                        </div>`);
                        
                    });
                    $('#submi').append(`<input type="submit" value="Affecter" class="btn btn-info mt-3 btnAffecter">`);

                }
            });
        }





        const box = document.querySelectorAll('.boxCheck');
        // console.log(box);
        for (const b of box) {
            if (b.checked) {
                $('.btnAffecter').prop(disabled,false);
                
            } else {
                $('.btnAffecter').prop(disabled,true);
            }
        }




        //INSERT
        $(document).on('click', '.bouton_ajouter', function(event){
            event.preventDefault();
            var data = { 
              "_token": "{{ csrf_token() }}",
              'user': $('.user').val()
            };
            
            $.ajax({
                type: "POST",
                url: "/users",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        $('#errorList').html("");
                        // $('#errorList').deleteClass('alert alert-danger');
                        $('#formAdd')[0].reset();
                        // alert("user ajouté avec succèe");
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("user enregistrée avec succès", "success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                    }
                },error:function(err){
                    // console.log(err.responseText);
                    let error = err.responseJSON;

                    $('#errorList').html("");
                    $('#errorList').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                            $('#errorList').append('<li>'+err_values+'</li>');
                    });
                }
            });
        });

        //Edit Modal
        $(document).on('click', '.edit_btn', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let user = $(this).data('user');

            $('.user_up').val(user);
            $('.ID').val(id);
        });

        //modification user
        $(document).on('click', '.BtnMod', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}",
                'user' : $('.user_up').val(),
                'id': $('.ID').val()
            }
            $.ajax({
                type: "PUT",
                url: "/users/"+$('.ID').val(),
                data: datas,
                dataType: "json",
                success: function(res){
                    if(res.status == 'success')
                    {
                        $('#errorListUpdate').html("");
                        $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#formUpt')[0].reset();
                        // alert("user Modifié avec succèe");
                        $('#modelIdEdit').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("user modifiée avec succès", "success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                    }
                },error:function(err){
                    let error = err.responseJSON;

                    $('#errorListUpdate').html("");
                    $('#errorListUpdate').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                        $('#errorListUpdate').append('<li>'+err_values+'</li>');
                    });
                }
            });

        });

        //Delete Modal
        $(document).on('click', '.delete_btn', function(e){
            e.preventDefault();
             let id = $(this).data('id');
             let user = $(this).data('user');

             $('#del_user').html(user);
            $('#del_id').val(id);
            // console.log(user);
        });

        //Suppresion user
        $(document).on('click', '.BTN_SUP', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                type: "DELETE",
                url: "/users/"+$('#del_id').val(),
                data: datas,
                success: function(res){
                    if(res.status == 'success')
                    {
                        // $('#errorListUpdate').html("");
                        // $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#Deluser')[0].reset();
                        // alert("user supprimé avec succès");
                        $('#modalSup').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("user supprimée avec succès", "success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                    }
                },error:function(err){
                    
                }
            });

        });
    });
</script>
{!! Toastr::message() !!}
@endsection