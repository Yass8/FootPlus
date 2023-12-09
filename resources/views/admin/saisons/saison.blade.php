@extends('layouts.dash.dashboard')
@section('titre', "Saisons")
@section('Title', "Saisons - FFC")

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card text-whit mb-4">
            <div class="card-body">Ajouter une saison</div>
            <div class="card-footer d-flx align-iems-center justify-conent-between">
                {{-- <a class="small text-white stretched-link" href="#">View Details</a> --}}
                {{-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> --}}
                <ul id="errorList"></ul>
                
                
                <form action="{{route('saisons.store')}}" method="POST" id="formAdd">
                    @csrf
                    <div class="mb-3">
                      <label for="" class="form-label">Saison</label>
                      <input type="text" class="form-control saison" name="" id="" placeholder="yyyy-yyyy">
                      {{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
                    </div>
                    <button type="submit" class="btn btn-success bouton_ajouter">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-md-6">
        <div class="card mb-4">
            <div class="card-body">Listes des saisons</div>
            <div class="card-footer d-fle align-items-center justify-content-between">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Saisons</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saisons as $key=>$saison)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{$saison->nom_saison}}</td>
                            <td><a href=""
                                class="btn btn-sm btn-success edit_btn"
                                data-bs-toggle="modal"
                                data-bs-target="#modelIdEdit"
                                data-id="{{ $saison->id }}"
                                data-saison="{{ $saison->nom_saison }}"
                                >
                                <i class="text-white fas fa-edit"></i>
                            </a> 
                            <a href="" class="btn btn-sm btn-danger delete_btn"
                             data-bs-toggle="modal" data-bs-target="#modalSup"
                             data-id="{{ $saison->id }}"
                             data-saison="{{ $saison->nom_saison }}"
                             >
                                 <i class="fas fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $saisons->links() !!}
            </div>
        </div>
    </div>
</div>

@include('admin.saisons.editSaison')
@endsection
@section('scriptJs')
<script>
    $(document).ready(function(){
        //INSERT
        $(document).on('click', '.bouton_ajouter', function(event){
            event.preventDefault();
            var data = { 
              "_token": "{{ csrf_token() }}",
              'saison': $('.saison').val()
            };

            requete("POST","/saisons",data,function (response) { 
                if("status" in response && response.status === 'success')
                {
                    $('#errorList').html("");
                    // $('#errorList').deleteClass('alert alert-danger');
                    $('#formAdd')[0].reset();
                    // alert("Saison ajouté avec succèe");
                    $('.table').load(location.href+' .table');

                    toast("Saison enregistrée avec succès !");
                }
                if ("errors" in response) {
                    $('#errorList').html("");
                    $('#errorList').addClass('alert alert-danger');

                    $.each(response.errors, function(key, err_values) {
                            $('#errorList').append('<li>'+err_values+'</li>');
                    });
                }
            });
            /*$.ajax({
                type: "POST",
                url: "/saisons",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        $('#errorList').html("");
                        // $('#errorList').deleteClass('alert alert-danger');
                        $('#formAdd')[0].reset();
                        // alert("Saison ajouté avec succèe");
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("Saison enregistrée avec succès", "success")

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
            });*/
        });

        //Edit Modal
        $(document).on('click', '.edit_btn', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let saison = $(this).data('saison');

            $('.saison_up').val(saison);
            $('.ID').val(id);
        });

        //modification saison
        $(document).on('click', '.BtnMod', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}",
                'saison' : $('.saison_up').val(),
                'id': $('.ID').val()
            }

            requete("PUT","/saisons/"+$('.ID').val(),datas,(res)=>{
                if(res.status == 'success')
                {
                    $('#errorListUpdate').html("");
                    $('#errorListUpdate').removeClass('alert alert-danger');
                    $('#formUpt')[0].reset();
                    // alert("Saison Modifié avec succèe");
                    $('#modelIdEdit').modal('hide');
                    $('.table').load(location.href+' .table');

                    toast("Saison modifiée avec succès !");
                }
                if ("errors" in res) {
                    $('#errorListUpdate').html("");
                    $('#errorListUpdate').addClass('alert alert-danger');

                    $.each(res.errors, function(key, err_values) {
                            $('#errorListUpdate').append('<li>'+err_values+'</li>');
                    });
                }
            });
            /*$.ajax({
                type: "PUT",
                url: "/saisons/"+$('.ID').val(),
                data: datas,
                dataType: "json",
                success: function(res){
                    if(res.status == 'success')
                    {
                        $('#errorListUpdate').html("");
                        $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#formUpt')[0].reset();
                        // alert("Saison Modifié avec succèe");
                        $('#modelIdEdit').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("Saison modifiée avec succès", "success")

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
            });*/

        });

        //Delete Modal
        $(document).on('click', '.delete_btn', function(e){
            e.preventDefault();
             let id = $(this).data('id');
             let saison = $(this).data('saison');

             $('#del_saison').html(saison);
            $('#del_id').val(id);
            // console.log(saison);
        });

        //Suppresion saison
        $(document).on('click', '.BTN_SUP', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}"
            }

            requete("DELETE", "/saisons/"+$('#del_id').val(), datas, (res)=>{
                if(res.status == 'success')
                    {
                        // $('#errorListUpdate').html("");
                        // $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#DelSaison')[0].reset();
                        // alert("Saison supprimé avec succès");
                        $('#modalSup').modal('hide');
                        $('.table').load(location.href+' .table');

                        toast("Saison supprimée avec succès !");

                        
                    }
            });

           /* $.ajax({
                type: "DELETE",
                url: "/saisons/"+$('#del_id').val(),
                data: datas,
                success: function(res){
                    if(res.status == 'success')
                    {
                        // $('#errorListUpdate').html("");
                        // $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#DelSaison')[0].reset();
                        // alert("Saison supprimé avec succès");
                        $('#modalSup').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("Saison supprimée avec succès", "success")

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
            });*/

        });
    });
</script>
{!! Toastr::message() !!}
@endsection