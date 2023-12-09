@extends('layouts.dash.dashboard')
@section('titre', "Championnats")
@section('Title', "Champioonats - FFC")

@section('content')

<div class="row">
    <div class="col-xl-5 col-md-6">
        <div class="card text-whit mb-4">
            <div class="card-body">Ajouter un championnat</div>
            <div class="card-footer d-fle align-items-center justify-content-between">
                <ul id="errorList"></ul>

                <form action="" method="post" id="formAdd">
                    <div class="mb-3">
                      <label for="" class="form-label">Saison</label>
                      <select class="form-control saison" name="" id="">
                        @foreach ($saisons as $saison)
                        <option value="{{ $saison->id }}">{{ $saison->nom_saison }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Etat</label>
                        <select class="form-control etat" name="" id="">
                            @foreach ($etats as $etat)
                            <option value="{{ $etat->id }}">{{ $etat->nom_etat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Division</label>
                        <select class="form-control division" name="" id="">
                            @foreach ($divisions as $div)
                            <option value="{{ $div->id }}">{{ $div->nom_division }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Championnat</label>
                      <input type="text" class="form-control championnat" name="" id="" placeholder="Nom du championnat">
                    </div>
                    <button type="submit" class="btn btn-success bouton_ajouter">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-md-6">
        <div class="card mb-4">
            <div class="card-body">Listes des championnats</div>
            <div class="card-footer d-fle align-items-center justify-content-between">

                <div class="mb-3">
                    <label for="" class="form-label">Saison</label>
                    <select class="form-control lesaison" name="" id="">
                      @foreach ($saisons as $saison)
                      <option value="{{ $saison->id }}">{{ $saison->nom_saison }}</option>
                      @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Etat</label>
                    <select class="form-control letat" name="" id="">
                        @foreach ($etats as $etat)
                        <option value="{{ $etat->id }}">{{ $etat->nom_etat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Division</label>
                    <select class="form-control ladivision" name="" id="">
                        @foreach ($divisions as $div)
                        <option value="{{ $div->id }}">{{ $div->nom_division }}</option>
                        @endforeach
                    </select>
                </div>

                <table class="table table-bordered table-stripped table-responsive">
                    <thead>
                        <tr>
                            <th>Championnats</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($championnats as $key=>$championnat)
                        <tr>
                            <td>{{$championnat->nom_championnat}}</td>
                            <td><a href=""
                                class="btn btn-sm btn-success edit_btn"
                                data-bs-toggle="modal"
                                data-bs-target="#modelIdEdit"
                                data-id="{{ $championnat->id }}"
                                data-championnat="{{ $championnat->nom_championnat }}"
                                >
                                <i class="text-white fas fa-edit"></i>
                                </a> 
                                <a href="" class="btn btn-sm btn-danger delete_btn"
                                data-bs-toggle="modal" data-bs-target="#modalSup"
                                data-id="{{ $championnat->id }}"
                                data-championnat="{{ $championnat->nom_championnat }}"
                                >
                                 <i class="fas fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.championnats.editChampionnat')

@endsection
@section('scriptJs')
<script>
    $(document).ready(function(){

        //
        // var clikSaison = document.querySelectorAll('.leSaison');
        clickSelect();

        function clickSelect() {
            $(document).on('click', '.lesaison' , function(e){
                e.preventDefault();
                var saison = $(this).val();
                var etat = $('.letat').val();
                var division = $('.ladivision').val();
                liste(saison,etat,division);

                
            });

            $(document).on('click', '.letat' , function(e){
                e.preventDefault();
                var etat = $(this).val();
                var saison = $('.lesaison').val();
                var division = $('.ladivision').val();
                liste(saison,etat,division);

                
            });

            $(document).on('click', '.ladivision' , function(e){
                e.preventDefault();
                var saison = $('.lesaison').val();
                var etat = $('.letat').val();
                var division = $(this).val();
                liste(saison,etat,division);

                
            });

        }

        function liste(saison,etat,division){
            // console.log(saison+"  "+etat+"   "+division);
            var datas = {
                'saison' : saison, 
                'etat' : etat, 
                'division' : division, 
            }

            // console.log(datas);

            $.ajax({
                type: "GET",
                url: "/championnats/"+saison+"/"+etat+"/"+division,
                data: datas,
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.championnats, function(key, champs) {
                            $('tbody').append('<tr>\
                                <td>'+champs.nom_championnat+'</td>\
                                <td><a href="/championnats/'+champs.cid+'" class="btn btn-sm btn-info"><i class="text-white fas fa-eye"></i></a>\
                                <a href=""\
                                class="btn btn-sm btn-success edit_btn"\
                                data-bs-toggle="modal"\
                                data-bs-target="#modelIdEdit"\
                                data-id="'+ champs.id +'"\
                                data-championnat="'+champs.nom_championnat+'"\
                                data-saison="'+champs.saison_id+'"\
                                data-etat="'+champs.etat_id+'"\
                                data-division="'+champs.division_id+'"\
                                >\
                                <i class="text-white fas fa-edit"></i>\
                                </a>\
                                <a href="" class="btn btn-sm btn-danger delete_btn"\
                                data-bs-toggle="modal" data-bs-target="#modalSup"\
                                data-id="'+ champs.id +'"\
                                data-championnat="'+champs.nom_championnat+'"\
                                >\
                                 <i class="fas fa-trash"></i>\
                            </a></td></tr>');
                    });
                }
            });
        }



        //INSERT
        $(document).on('click', '.bouton_ajouter', function(event){
            event.preventDefault();
            var data = { 
              "_token": "{{ csrf_token() }}",
              'saison': $('.saison').val(), 
              'etat': $('.etat').val(), 
              'division': $('.division').val(), 
              'championnat': $('.championnat').val()
            };
            
            $.ajax({
                type: "POST",
                url: "/championnats",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        $('#errorList').html("");
                        // $('#errorList').deleteClass('alert alert-danger');
                        $('#formAdd')[0].reset();
                        // alert("championnat ajouté avec succèe");
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("championnat enregistré avec succès", "success")

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
            let championnat = $(this).data('championnat');

            $('.championnat_up').val(championnat);
            $('.ID').val(id);
            $('.saison_up').val($(this).data('saison'));
            $('.etat_up').val($(this).data('etat'));
            $('.division_up').val($(this).data('division'));
            // console.log(championnat+" "+id);
        });

        //modification championnat
        $(document).on('click', '.BtnMod', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}",
                'championnat' : $('.championnat_up').val(),
                'saison': $('.saison_up').val(),
                'etat': $('.etat_up').val(),
                'division': $('.division_up').val(),
                'id': $('.ID').val()
            }
            $.ajax({
                type: "PUT",
                url: "/championnats/"+$('.ID').val(),
                data: datas,
                dataType: "json",
                success: function(res){
                    if(res.status == 'success')
                    {
                        $('#errorListUpdate').html("");
                        $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#formUpt')[0].reset();
                        // alert("championnat Modifié avec succèe");
                        $('#modelIdEdit').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("championnat modifié avec succès", "success")

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
             let championnat = $(this).data('championnat');

             $('#del_championnat').html(championnat);
            $('#del_id').val(id);
            // console.log(championnat);
        });

        //Suppresion championnat
        $(document).on('click', '.BTN_SUP', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                type: "DELETE",
                url: "/championnats/"+$('#del_id').val(),
                data: datas,
                success: function(res){
                    if(res.status == 'success')
                    {
                        // $('#errorListUpdate').html("");
                        // $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#Delchampionnat')[0].reset();
                        // alert("championnat supprimé avec succès");
                        $('#modalSup').modal('hide');
                        $('.table').load(location.href+' .table');

                        Command: toastr["success"]("championnat supprimée avec succès", "success")

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