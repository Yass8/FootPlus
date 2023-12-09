@extends('layouts.dash.dashboard')
@section('titre', "Utilisateurs")
@section('Title', "Utilisateurs - FFC")

@section('content')
<div class="row">
    {{-- <div class="col-xl-5 col-md-6">
        <div class="card text-whit mb-4">
            <div class="card-body">Ajouter un utilisateur</div>
            <div class="card-footer d-flx align-iems-center justify-conent-between">
                <ul id="errorList"></ul>
                
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                
                <form action="{{route('register')}}" method="POST" id="formAdd">
                    @csrf
                    <div class="mb-3">
                      <label for="" class="form-label">Nom</label>
                      <input type="text" class="form-control user" name="nom" id="" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Prénom</label>
                        <input type="text" class="form-control user" name="prenom" id="" placeholder="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control user" name="email" id="" placeholder="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control user" name="password" id="" placeholder="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Confirme mot de passe</label>
                        <input type="password" class="form-control user" name="password_confirmation" id="" placeholder="">
                      </div>
                    <button type="submit" class="btn btn-success">Ajouter</button>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="col-md-12">
        {{-- <div class="card mb-4">
            <div class="card-body">Listes des users</div>
            <div class="card-footer d-fle align-items-center justify-content-between">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>nom</th>
                            <th>prenom</th>
                            <th>email</th>
                            <th>rôles</th>
                            <th>Championnats</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key=>$user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{$user->nom}}</td>
                            <td>{{$user->prenom}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{ implode(', ', $user->roles()->get()->pluck('nom_role')->toArray()) }}</td>
                            <td>{{ implode(', ', $user->championnats()->get()->pluck('nom_championnat')->toArray()) }}</td>
                            <td><a href="{{route('users.edit', $user->id )}}"
                                class="btn btn-sm btn-success"
                                >
                                <i class="text-white fas fa-edit"></i>
                            </a> 
                            <a href="" class="btn btn-sm btn-danger delete_btn_user"
                             data-bs-toggle="modal" data-bs-target="#modalSupUser"
                             data-id="{{ $user->id }}"
                             data-username="{{ $user->nom }}"
                             data-userlastname="{{ $user->prenom }}"
                             >
                                 <i class="fas fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $users->links() !!}
            </div>
        </div> --}}

        {{-- <a href="{{route('email')}}" class="btn btn-info mb-3">Ajouter un utilisateur</a> --}}
        <div class="row">
            <a href="" class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#ModalAddUser">Ajouter un utilisateur</a>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="ModalAddUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Ajout d'un utilisateur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <ul id="errAddUser"></ul>
                            <form action="" method="post" id="FormAddUser">
                                <div class="mb-3">
                                  <label for="" class="form-label">Nom</label>
                                  <input type="text" class="form-control nom" name="" id="" placeholder="Nom de l'utilasteur">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Prénom</label>
                                    <input type="text" class="form-control prenom" name="" id="" placeholder="Prénom de l'utilasteur">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control email" name="" id="" placeholder="Email de l'utilasteur">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-info btnADD">Ajouter l'utilisateur</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            var modelIda = document.getElementById('ModalAddUser');
        
            modelIda.addEventListener('show.bs.modal', function (event) {
                  // Button that triggered the modal
                  let button = event.relatedTarget;
                  // Extract info from data-bs-* attributes
                  let recipient = button.getAttribute('data-bs-whatever');
        
                // Use above variables to manipulate the DOM
            });
        </script>
        

        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="card">
                    <div class="card-body">
                         <h3>Liste des utilisateurs</h3>
                    </div>
                    <div class="card-footer p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover mt-2" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>nom</th>
                                        <th>prenom</th>
                                        <th>email</th>
                                        <th>rôles</th>
                                        <th>Championnats</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @foreach ($users as $key=>$user)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$user->nom}}</td>
                            <td>{{$user->prenom}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{ implode(', ', $user->roles()->get()->pluck('nom_role')->toArray()) }}</td>
                            <td>{{ implode(', ', $user->championnats()->get()->pluck('nom_championnat')->toArray()) }}</td>
                            <td><a href="{{route('users.edit', $user->id )}}"
                                class="btn btn-sm btn-success"
                                >
                                <i class="text-white fas fa-edit"></i>
                            </a> 
                            <a href="" class="btn btn-sm btn-danger delete_btn_user"
                             data-bs-toggle="modal" data-bs-target="#modalSupUser"
                             data-id="{{ $user->id }}"
                             data-username="{{ $user->nom }}"
                             data-userlastname="{{ $user->prenom }}"
                             >
                                 <i class="fas fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>



    </div>
</div>
<!-- Modal de suppression-->
<div class="modal fade" id="modalSupUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form id="DelForm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Suppression d'un utilisateur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        <p>Êtes-vous sûre de vouloire supprimer l'utilisateur <strong id="nom_user"></strong> ?</p>
                        <p class="text-muted">Cliquez sur OUI pour Supprimer ou NON pour annuler l'opération.</p>
                        <input type="hidden" id="idUser">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NON</button>
                    <button type="button" class="btn btn-success BTN_SUP_USER">OUI</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- @include('admin.users.edituser') --}}
@endsection
@section('scriptJs')
<script src="{{asset('js/dataTables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables/dataTables.bootstrap.js')}}"></script>
    <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
<script>
    $(document).ready(function(){

        //Ajouter un utilisateur
        $(".btnADD").click(function (e) { 
            e.preventDefault();
            var data = { 
              "_token": "{{ csrf_token() }}",
              'nom': $('.nom').val(),
              'prenom': $('.prenom').val(),
              'email': $('.email').val()
            };

            requete("POST","/users",data,function (response) { 
                if("status" in response && response.status === 'success')
                {
                    $('#ModalAddUser').modal('hide');
                    $('#errAddUser').html("");
                    $('#FormAddUser')[0].reset();

                    toast("Utilisateur enregistré avec succès !");

                    window.location.href = "/email/" + response.idUser + "/" + response.mdp;

                    
                }
                if ("errors" in response) {
                    $('#errAddUser').html("");
                    $('#errAddUser').addClass('alert alert-danger');

                    $.each(response.errors, function(key, err_values) {
                            $('#errAddUser').append('<li>'+err_values+'</li>');
                    });
                }
            });
        });

        //Delete Modal
        $(document).on('click', '.delete_btn_user', function(e){
            e.preventDefault();
             let id = $(this).data('id');
             let username = $(this).data('username');
             let userprenom = $(this).data('userlastname');

             $('#nom_user').html(username+" "+userprenom);
            $('#idUser').val(id);
        });

        //Suppresion user
        $(document).on('click', '.BTN_SUP_USER', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                type: "DELETE",
                url: "/users/"+$('#idUser').val(),
                data: datas,
                success: function(res){
                    if(res.status == 'success')
                    {
                        // $('#errorListUpdate').html("");
                        // $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#DelForm')[0].reset();
                        // alert("user supprimé avec succès");
                        $('#modalSupUser').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("Utilisateur supprimé avec succès", "success")

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

                        window.location.href = "/users";

                    }
                },error:function(err){
                    
                }
            });

        });
    });
</script>
{!! Toastr::message() !!}
@endsection