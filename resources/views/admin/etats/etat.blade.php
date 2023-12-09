@extends('layouts.dash.dashboard')
@section('titre', "Etats")
@section('Title', "Etats - FFC")

@section('content')

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card text-whit mb-4">
            <div class="card-body">Ajouter une île</div>
            <div class="card-footer d-fle align-items-center justify-content-between">
                <ul id="errorList"></ul>

                <form action="" method="post" id="formAdd">
                    <div class="mb-3">
                      <label for="" class="form-label">Etat</label>
                      <input type="text" class="form-control etat" name="" id="" placeholder="Nom de l'île">
                    </div>
                    <button type="submit" class="btn btn-success bouton_ajouter">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card mb-4">
            <div class="card-body">Listes des Etats</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>Iles</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($etats as $key=>$etat)
                        <tr>
                            <td>{{$etat->nom_etat}}</td>
                            <td><a href=""
                                class="btn btn-sm btn-success edit_btn"
                                data-bs-toggle="modal"
                                data-bs-target="#modelIdEdit"
                                data-id="{{ $etat->id }}"
                                data-etat="{{ $etat->nom_etat }}"
                                >
                                <i class="text-white fas fa-edit"></i>
                                </a> 
                                <a href="" class="btn btn-sm btn-danger delete_btn"
                                data-bs-toggle="modal" data-bs-target="#modalSup"
                                data-id="{{ $etat->id }}"
                                data-etat="{{ $etat->nom_etat }}"
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
</div>
@include('admin.etats.editEtat')

@endsection
@section('scriptJs')
<script>
    $(document).ready(function(){
        //INSERT
        $(document).on('click', '.bouton_ajouter', function(event){
            event.preventDefault();
            var data = { 
              "_token": "{{ csrf_token() }}",
              'etat': $('.etat').val()
            };
            
            $.ajax({
                type: "POST",
                url: "/etats",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        $('#errorList').html("");
                        // $('#errorList').deleteClass('alert alert-danger');
                        $('#formAdd')[0].reset();
                        // alert("etat ajouté avec succèe");
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("Etat enregistré avec succès", "success")

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
            let etat = $(this).data('etat');

            $('.etat_up').val(etat);
            $('.ID').val(id);
            // console.log(etat+" "+id);
        });

        //modification etat
        $(document).on('click', '.BtnMod', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}",
                'etat' : $('.etat_up').val(),
                'id': $('.ID').val()
            }
            $.ajax({
                type: "PUT",
                url: "/etats/"+$('.ID').val(),
                data: datas,
                dataType: "json",
                success: function(res){
                    if(res.status == 'success')
                    {
                        $('#errorListUpdate').html("");
                        $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#formUpt')[0].reset();
                        // alert("etat Modifié avec succèe");
                        $('#modelIdEdit').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("etat modifiée avec succès", "success")

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
             let etat = $(this).data('etat');

             $('#del_etat').html(etat);
            $('#del_id').val(id);
            // console.log(etat);
        });

        //Suppresion etat
        $(document).on('click', '.BTN_SUP', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                type: "DELETE",
                url: "/etats/"+$('#del_id').val(),
                data: datas,
                success: function(res){
                    if(res.status == 'success')
                    {
                        // $('#errorListUpdate').html("");
                        // $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#DelEtat')[0].reset();
                        // alert("etat supprimé avec succès");
                        $('#modalSup').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("etat supprimée avec succès", "success")

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