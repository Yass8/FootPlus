@extends('layouts.dash.dashboard')
@section('titre', $equipe->nom_equipe)
@section('Title', "Champioonats - FFC")

@section('content')

<input type="hidden" value="{{$equipe->idEquipe}}" class="equipe_id">
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">{{$equipe->nom_championnat}} {{--| {{$championnat->nom_etat}} | {{$championnat->nom_division}}--}}</li>
</ol>
<div class="equipes">
    <div class="row">
        <div class="col-xl-5 col-md-6">
            <div class="card text-whit mb-4">
                <div class="card-body"><strong>Information de l'équipe</strong></div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <table class="table responsive">
                        <tr>
                            <td>Championnat</td>
                            <td>: <strong>{{$equipe->nom_championnat}}</strong></td>
                        </tr>
                        <tr>
                            <td>Nom Equipe</td>
                            <td>: <strong>{{$equipe->nom_equipe}}</strong></td>
                        </tr>
                        <tr>
                            <td>Abréviation</td>
                            <td>: <strong>{{$equipe->abreviation}}</strong></td>
                        </tr>
                        <tr>
                            <td>Réference</td>
                            <td>: <strong>{{$equipe->nom_equipe}}</strong></td>
                        </tr>
                        
                        <tr>
                            <td>Nombre de points</td>
                            <td>: <strong id="lesPoints">{{$equipe->Pts}}</strong></td>
                        </tr>
                        <tr>
                            <td>Diff buts</td>
                            <td>: <strong id="diff">{{$equipe->DF}}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-6">
            <div class="card mb-4">
                <div class="card-body"><strong>Modifications des points et des buts</strong></div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <ul id="errorListPoints"></ul>
                    <form action="" method="post" id="formAddPoints">
                        <div class="mb-3">
                          <label for="" class="form-label">Nombre de points à ajouter ou à retirer à l'équipe</label>
                          <input type="number" min="1" class="form-control points" name="" id="" placeholder="Nombre de points">
                          {{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
                        </div>
                        <input type="submit" class="btn btn-sm btn-primary btnAddPoints" value="Ajouter les points">
                        <input type="submit" class="btn btn-sm btn-warning btnDelPoints" value="Retirer les points">
                        <hr>
                        <ul id="errorListbuts"></ul>

                        <div class="mb-3">
                            <label for="" class="form-label">Nombre de buts à ajouter ou à retirer à l'équipe</label>
                            <input type="number" min="1" class="form-control buts" name="" id="" placeholder="Nombre de buts">
                            {{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
                        </div>
                          <input type="submit" class="btn btn-sm btn-primary btnAddButs" value="Ajouter les buts">
                          <input type="submit" class="btn btn-sm btn-warning btnDelButs" value="Retirer les buts">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @include('admin.championnats.editChampionnat') --}}

@endsection
@section('scriptJs')

<script>

    // fct add or delete points
    function points(action,data){
        // let action = act;
        let msg = "";
        if (action==="add_points") {
            msg = "ajoutés";
        }
        if (action==="delete_points") {
            msg = "enlevés";
        }

            $.ajax({
            type: "PUT",
            url: "/"+action+"/"+$('.equipe_id').val(),
            data: data,
            dataType: "json",
            success: function (response) {
                if(response.status == 'success')
                {
                    $('#errorListPoints').html("");
                    // $('#errorList').deleteClass('alert alert-danger');
                    $('#formAddPoints')[0].reset();
                   
                    $('#lesPoints').html(response.points.Pts);

                    Command: toastr["success"]("Points "+msg+" avec succès", "success")

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

                $('#errorListPoints').html("");
                $('#errorListPoints').addClass('alert alert-danger');

                $.each(error.errors, function(key, err_values) {
                        $('#errorListPoints').append('<li>'+err_values+'</li>');
                });
            }    
            
            });
        
    }
    //btn add points
    $(document).on('click','.btnAddPoints',(e)=>{
        e.preventDefault();
        //console.log("btnAddPoints");

        var donnees = {
            "_token": "{{ csrf_token() }}",
            'points': $('.points').val()
        }

        points("add_points",donnees);

    });
    //btn delete points
    $(document).on('click','.btnDelPoints',(e)=>{
        e.preventDefault();
        //console.log("btnAddPoints");

        var donnees = {
            "_token": "{{ csrf_token() }}",
            'points': $('.points').val()
        }

        points("delete_points",donnees);

    });

    /*************************************************************************/

    // fct add or delete but
    function buts(action,data){
        
        let msg = "";
        if (action==="add_buts") {
            msg = "ajoutés";
        }
        if (action==="delete_buts") {
            msg = "enlevés";
        }

            $.ajax({
            type: "PUT",
            url: "/"+action+"/"+$('.equipe_id').val(),
            data: data,
            dataType: "json",
            success: function (response) {
                if(response.status == 'success')
                {
                    $('#errorListbuts').html("");
                    // $('#errorList').deleteClass('alert alert-danger');
                    $('#formAddPoints')[0].reset();
                   
                    $('#diff').html(response.buts.DF);

                    Command: toastr["success"]("Buts "+msg+" avec succès", "success")

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

                $('#errorListbuts').html("");
                $('#errorListbuts').addClass('alert alert-danger');

                $.each(error.errors, function(key, err_values) {
                        $('#errorListbuts').append('<li>'+err_values+'</li>');
                });
            }    
            
            });
        
    }
    //btn add buts
    $(document).on('click','.btnAddButs',(e)=>{
        e.preventDefault();
        var donnees = {
            "_token": "{{ csrf_token() }}",
            'buts': $('.buts').val()
        }

        buts("add_buts",donnees);

    });
    //btn delete buts
    $(document).on('click','.btnDelButs',(e)=>{
        e.preventDefault();
        //console.log("btnAddPoints");

        var donnees = {
            "_token": "{{ csrf_token() }}",
            'buts': $('.buts').val()
        }

        buts("delete_buts",donnees);

    });

</script>

{!! Toastr::message() !!}
@endsection