

{{-- Edit Math --}}

<!-- Modal -->
<div class="modal fade" id="modalEditMatch" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Information du match</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <ul id="errorListScore"></ul>

                <div class="card">
                    <div class="card-body">Resultat du match - <span class="LaJournee">Journée 1</span></div>
                <div class="card-footer d-flex align-items-center justify-content-center col-sm-12 mb-4 ">
                    <table class="table-responsive text-center">
                        <tr>
                            <td><strong class="eqHome">Equipe 1</strong></td>
                            <td class="text-center p-0 col-2"><input type="number" min="0" class="col-12 text-center butsHome"></td>
                            <td class="text-center p-0 col-2"><input type="number" min="0" class="col-12 text-center butsVisit"></td>
                            <td><strong class="eqVisit">Equipe 1</strong></td>
                        </tr>
                    </table>

                </div>
                <div class="text-center">
                    <button class="btn btn-success AjouterScore">Ajouter un score</button>
                    <button class="btn btn-info UpdateScore">Mettre à jour le score</button>
                </div>
                <input type="hidden" id="ID_rencontre">
                <input type="hidden" id="MatchJouer">
                </div>
                <hr class="text-dark" style="border: 2px solid black">
                <ul id="errorListUpdateRctre"></ul>

                <div class="mb-3">
                    <label for="" class="form-label">Stade</label>
                    <input type="text" class="form-control lieu_upd" name="" id="" placeholder="Lieu de rencontre">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Date de la rencontre <span class="text-muted dat"></span></label>
                    <input type="date" class="form-control date_upd" name="" id="" placeholder="">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Heure de la rencontre <span class="text-muted hr"></span></label>
                    <input type="time" class="form-control heure_upd" name="" id="" placeholder="">
                </div>

                <div class="text-center">
                    <button class="btn btn-outline-warning btnRepport">Répporter</button>
                    <button class="btn btn-outline-danger btnSuppRctre">Supprimer</button>
                    <button type="submit" class="btn btn-outline-success btnMdfRenctre">Modifier la rencontre</button>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div> --}}
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        //ouvrir le modal
        $(document).on('click','.btnMatch', function (e) { 
            e.preventDefault();

            // console.log("ez");

            var id = $(this).data('id');
            var home = $(this).data('home');
            var visit = $(this).data('visit');
            var lieu = $(this).data('lieu');
            var dt = $(this).data('date');
            var hr = $(this).data('heure');
            var butsH = $(this).data('butshome');
            var butsV = $(this).data('butsvisit');
            var repporter = $(this).data('repporte');
            var jouer = $(this).data('jouer');
            // console.log(jouer);
            if (jouer===1) {
                $('.butsHome').val(butsH);
                $('.butsVisit').val(butsV);
                $('.btnRepport').prop('disabled',true);
                $('.btnSuppRctre').prop('disabled',true);
                $('.btnMdfRenctre').prop('disabled',true);

                $('.AjouterScore').fadeOut(1);
                $('.UpdateScore').fadeIn(1);

            }else{
                
                if (repporter===1) {
                    $('.btnRepport').prop('disabled',true);
                    // $('.btnSuppRctre').prop('disabled',true);
                    $('.AjouterScore').prop('disabled',true);
                    $('.UpdateScore').fadeOut(1);

                }else{

                    if (jouer===0) {
                        $('.butsHome').val("");
                        $('.butsVisit').val("");
                        $('.UpdateScore').fadeOut(1);
                        $('.AjouterScore').fadeIn(1);
                        $('.btnRepport').prop('disabled',false);
                        $('.btnSuppRctre').prop('disabled',false);
                        $('.btnMdfRenctre').prop('disabled',false);
                        $('.AjouterScore').prop('disabled',false);

                    }
                }
            }
            // console.log(dt);
            $('.lieu_upd').val(lieu);
            $('.heure_upd').val(hr);
            $('.date_upd').val(dt);
            // $('.dat').html(dt);
            // $('.hr').html(hr);
            $('.eqHome').html(home);
            $('.eqVisit').html(visit);
            $('.LaJournee').html($(this).data('journee'));
            $('#ID_rencontre').val(id);
            $('#MatchJouer').val(jouer);

        });

        //Ajouter le score
        $(document).on('click','.AjouterScore', function(e){
            e.preventDefault();

            var data = {
                "_token": "{{ csrf_token() }}",
                'buts_home': $('.butsHome').val(),
                'buts_visit': $('.butsVisit').val(),
            };
            // console.log(data);
            $.ajax({
                type: "PUT",
                url: "/ajoutScore/"+$('#ID_rencontre').val()+"/"+$('.champ_id').val(),
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        // $('#errorListAddRecontre').html("");
                        // $('#formAddRecontre')[0].reset();
                        $('.tb_classements').load(location.href+' .tb_classements');

                        $('#modalEditMatch').modal('hide');

                        Command: toastr["success"]("Score ajouté avec succès", "success")

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

                    $('#errorListScore').html("");
                    $('#errorListScore').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                            $('#errorListScore').append('<li>'+err_values+'</li>');
                    });
                }
            });
        });

        //Mettre à jour le score
        $(document).on('click','.UpdateScore', function(e){
            e.preventDefault();

            var data = {
                "_token": "{{ csrf_token() }}",
                'buts_home': $('.butsHome').val(),
                'buts_visit': $('.butsVisit').val(),
            };
            // console.log(data);
            $.ajax({
                type: "PUT",
                url: "/updateScore/"+$('#ID_rencontre').val()+"/"+$('.champ_id').val(),
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        // $('#errorListAddRecontre').html("");
                        // $('#formAddRecontre')[0].reset();
                        $('.tb_classements').load(location.href+' .tb_classements');

                        $('#modalEditMatch').modal('hide');

                        Command: toastr["success"]("Score modifé avec succès", "success")

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

                    $('#errorListScore').html("");
                    $('#errorListScore').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                            $('#errorListScore').append('<li>'+err_values+'</li>');
                    });
                }
            });
        });

        //Supprimer le la recontre et mettre à jour le classement
        $(document).on('click','.btnSuppRctre', function(e){
            e.preventDefault();
            // console.log("id : "+$('#MatchJouer').val());
            if ($('#MatchJouer').val()==0) {
                var datas = {
                "_token": "{{ csrf_token() }}"
                }
                $.ajax({
                    type: "DELETE",
                    url: "/rencontres/"+$('#ID_rencontre').val(),
                    data: datas,
                    success: function(res){
                        if(res.status == 'success')
                        {
                            // $('#Deljournee')[0].reset();
                            $('#modalEditMatch').modal('hide');

                            Command: toastr["success"]("Rencontre supprimée avec succès", "success")

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
            }

            if ($('#MatchJouer').val()==1) {
                var datas = {
                "_token": "{{ csrf_token() }}"
                }
                $.ajax({
                    type: "DELETE",
                    url: "/match/"+$('#ID_rencontre').val(),
                    data: datas,
                    success: function(res){
                        if(res.status == 'success')
                        {
                            // $('#Deljournee')[0].reset();
                            $('#modalEditMatch').modal('hide');

                            Command: toastr["success"]("Rencontre supprimée avec succès", "success")

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
            }



            // var data = {
            //     "_token": "{{ csrf_token() }}",
            //     'buts_home': $('.butsHome').val(),
            //     'buts_visit': $('.butsVisit').val(),
            // };
            // // console.log(data);
            // $.ajax({
            //     type: "PUT",
            //     url: "/updateScore/"+$('#ID_rencontre').val()+"/"+$('.champ_id').val(),
            //     data: data,
            //     dataType: "json",
            //     success: function (response) {
            //         if(response.status == 'success')
            //         {
            //             // $('#errorListAddRecontre').html("");
            //             // $('#formAddRecontre')[0].reset();
            //             $('.tb_classements').load(location.href+' .tb_classements');

            //             $('#modalEditMatch').modal('hide');

            //             Command: toastr["success"]("Score modifé avec succès", "success")

            //             toastr.options = {
            //             "closeButton": true,
            //             "debug": false,
            //             "newestOnTop": false,
            //             "progressBar": true,
            //             "positionClass": "toast-top-right",
            //             "preventDuplicates": false,
            //             "onclick": null,
            //             "showDuration": "300",
            //             "hideDuration": "1000",
            //             "timeOut": "5000",
            //             "extendedTimeOut": "1000",
            //             "showEasing": "swing",
            //             "hideEasing": "linear",
            //             "showMethod": "fadeIn",
            //             "hideMethod": "fadeOut"
            //             }
            //         }
            //     },error:function(err){
            //         let error = err.responseJSON;

            //         $('#errorListScore').html("");
            //         $('#errorListScore').addClass('alert alert-danger');

            //         $.each(error.errors, function(key, err_values) {
            //                 $('#errorListScore').append('<li>'+err_values+'</li>');
            //         });
            //     }
            // });
        });

        //btn répporter
        $(document).on('click','.btnRepport', function(e){
            e.preventDefault();

            $.ajax({
                type: "GET",
                url: "/repport/"+$('#ID_rencontre').val(),
                success: function (response) {
                    if(response.status == 'success')
                    {

                        $('#modalEditMatch').modal('hide');

                        Command: toastr["success"]("Match repporté", "success")

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
                }
            });

        });

        

    });
</script>