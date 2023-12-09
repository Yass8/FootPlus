{{-- Modal Edit & Delete --}}


<!-- Modal -->
<div class="modal fade" id="modelIdEditRencontre" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form action="" method="post" id="formUptRencontre">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Modification d'une rencontre</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <ul id="errorListUpdateRencontre"></ul>

                        @csrf
                        <div class="mb-3">
                          <label for="" class="form-label">recontre</label>
                          <input type="text" class="form-control recontre_up" name="" id="" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Abréviation</label>
                            <input type="text" class="form-control abrev_up" name="" id="" placeholder="">
                        </div>
                    </div>
                    <input type="hidden" class="ID">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success BtnMod">Modifier</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    var modelIded = document.getElementById('modelIdEditRencontre');

    modelIded.addEventListener('show.bs.modal', function (event) {
          // Button that triggered the modal
          let button = event.relatedTarget;
          // Extract info from data-bs-* attributes
          let recipient = button.getAttribute('data-bs-whatever');

        // Use above variables to manipulate the DOM
    });
</script>



<!--- Suppression --->


<!-- Modal de suppression-->
{{-- <div class="modal fade" id="modalSup" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form id="Delrecontre">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Suppression d'une équipe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        <p>Êtes-vous sur de voiloire supprimer l'équipe <strong id="del_recontre"></strong> ?</p>
                        <p class="text-muted">Cliquez sur OUI pour Supprimer ou NON pour annuler l'opération.</p>
                        <input type="hidden" id="del_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NON</button>
                    <button type="button" class="btn btn-success BTN_SUP">OUI</button>
                </div>
            </div>
        </div>
    </form>
</div> --}}



{{-- Script recontres --}}
<script>
    $(document).ready(function () {


        /*function p() {
            $.ajax({
            type: "GET",
            url: "/options/"+$('.champ_id').val(),
            dataType: "json",
            success: function (response) {
                console.log(response.journees);
                $('.listeJournees').html("");
                $.each(response.journees, function(key, item){
                    $('.listeJournees').append(`<p class="mt-2">
                        <button class="btn btn-outline-success form-control btnJour"
                        data-id="${item.id}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#content${item.id}" aria-expanded="false"
                        aria-controls="content${item.id}"
                        >${item.nom_journee}</button>
                        </p>
                        
                        <div class="collapse card pb-2" id="content${item.id}">
                             <table class="table-bordered table-striped tbRENCONTRE">
                                 <thead>
                                     <tr>
                                         <th>Date</th>
                                         <th>Hôte</th>
                                         <th>Scores</th>
                                         <th>Visiteurs</th>
                                         <th>Stades</th>
                                     </tr>
                                 </thead>
                                 <tbody class="tb${item.id}">
                                    
                                 </tbody>
                             </table>
                         </div>    
                    `);

                });
            }
            });
        }*/

        
        //
        

        $('.btnJour').click(function (e) { 
            e.preventDefault();
            var idJournee = $(this).data('id');
            console.log(idJournee);
            $.ajax({
                type: "GET",
                url: "/lesRencontres/"+idJournee,
                success: function (response) {
                    // console.log(response)

                    $('.tb'+idJournee).html("");
                    $.each(response.rencontres, function (key, item){
                        
                        $('.tb'+idJournee).append('<tr>\
                            <td>'+item.dat+'</td>\
                            <td>'+item.home+'</td>\
                            <td class="text-center score'+item.id+'">\
                                <a href=""\
                                        class="btnMatch"\
                                        data-bs-toggle="modal" data-bs-target="#modalEditMatch"\
                                        data-id="'+item.id+'"\
                                        data-journee="'+item.nom_journee+'"\
                                        data-home="'+item.home+'"\
                                        data-visit="'+item.visit+'"\
                                        data-butshome="'+item.buts_home+'"\
                                        data-butsvisit="'+item.buts_visit+'"\
                                        data-jouer="'+item.jouer+'"\
                                        data-date="'+item.date_ren+'"\
                                        data-heure="'+item.heure_ren+'"\
                                        data-lieu="'+item.lieu+'"\
                                        data-repporte="'+item.repporter+'"\
                                        >'+item.buts_home+' - '+item.buts_visit+'</strong></a>\
                            </td>\
                            <td>'+item.visit+'</td>\
                            <td>'+item.lieu+'</td>\
                            </tr>');
                            if(item.repporter==1)
                            {
                                $('.score'+item.id).html("");
                                $('.score'+item.id).append('<a href=""\
                                        class="btnMatch"\
                                        data-bs-toggle="modal" data-bs-target="#modalEditMatch"\
                                        data-id="'+item.id+'"\
                                        data-journee="'+item.nom_journee+'"\
                                        data-home="'+item.home+'"\
                                        data-visit="'+item.visit+'"\
                                        data-butsHome="'+item.buts_home+'"\
                                        data-butsVisit="'+item.buts_visit+'"\
                                        data-jouer="'+item.jouer+'"\
                                        data-date="'+item.date_ren+'"\
                                        data-heure="'+item.heure_ren+'"\
                                        data-lieu="'+item.lieu+'"\
                                        data-repporte="'+item.repporter+'"\
                                        ><span class="text-danger">REP</span></a>');
                            }else{
                                if (item.jouer==0) {

                                    $('.score'+item.id).html("");
                                    $('.score'+item.id).append('<a href=""\
                                        class="btnMatch"\
                                        data-bs-toggle="modal" data-bs-target="#modalEditMatch"\
                                        data-id="'+item.id+'"\
                                        data-journee="'+item.nom_journee+'"\
                                        data-home="'+item.home+'"\
                                        data-visit="'+item.visit+'"\
                                        data-butsHome="'+item.buts_home+'"\
                                        data-butsVisit="'+item.buts_visit+'"\
                                        data-jouer="'+item.jouer+'"\
                                        data-date="'+item.date_ren+'"\
                                        data-heure="'+item.heure_ren+'"\
                                        data-lieu="'+item.lieu+'"\
                                        data-repporte="'+item.repporter+'"\
                                        ><i class="fa fa-edit" aria-hidden="true"></i></a>');
                                    
                                }
                            }
                         
                       });
                }
            });
        });

        // Ajout recontre
        $('.bouton_ajouter_rencontre').click(function (e) { 
            e.preventDefault();

            if ($('.home').val()==$('.visiteur').val()) {
                $('#errorListAddRecontre').html("");
                $('#errorListAddRecontre').addClass('alert alert-danger');
                $('#errorListAddRecontre').append('<li>Les deux équipes ne doivent pas être les mêmes.</li>');

            } else {
                var donnees = {
                    "_token": "{{ csrf_token() }}",
                    'home': $('.home').val(),
                    'visiteur': $('.visiteur').val(),
                    'journee': $('.journ').val(),
                    'lieu': $('.lieu').val(),
                    'date': $('.date').val(),
                    'heure': $('.heure').val(),
                }
            $.ajax({
                type: "POST",
                url: "/rencontres",
                data: donnees,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        $('#errorListAddRecontre').html("");
                        $('#formAddRecontre')[0].reset();
                        // $('.tb_recontres').load(location.href+' .tb_recontres');

                        Command: toastr["success"]("Recontre enregistrée avec succès", "success")

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

                    $('#errorListAddRecontre').html("");
                    $('#errorListAddRecontre').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                            $('#errorListAddRecontre').append('<li>'+err_values+'</li>');
                    });
                }    
                
            });
        }    
            
            
        });



       //Modifier la rencontre
       $(document).on('click','.btnMdfRenctre', function(event){
            event.preventDefault();
            var donneeUp = {
                "_token": "{{ csrf_token() }}",
                'lieu': $('.lieu_upd').val(),
                'date': $('.date_upd').val(),
                'heure': $('.heure_upd').val(),
            }
            
            $.ajax({
                type: "PUT",
                url: "/rencontres/"+$('#ID_rencontre').val(),
                data: donneeUp,
                dataType: "json",
                success: function(res){
                    if(res.status == 'success')
                    {
                        $('#errorListUpdateRctre').html("");
                        $('#errorListUpdateRctre').removeClass('alert alert-danger');
                        // $('#formUpt')[0].reset();

                        $('#modalEditMatch').modal('hide');

                        //$('.tb_recontres').load(location.href+' .tb_recontres');

                        Command: toastr["success"]("Rencontre modifiée avec succès", "success")

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

                    $('#errorListUpdateRctre').html("");
                    $('#errorListUpdateRctre').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                            $('#errorListUpdateRctre').append('<li>'+err_values+'</li>');
                    });
                }
            });
        });

        //Suppresion rencontre
        // $(document).on('click', '.btnSupp', function(e){
        //     e.preventDefault();
        //     var datas = {
        //         "_token": "{{ csrf_token() }}"
        //     }
        //     $.ajax({
        //         type: "DELETE",
        //         url: "/rencontres/"+$('#ID_rencontre').val(),
        //         data: datas,
        //         success: function(res){
        //             if(res.status == 'success')
        //             {
        //                 // $('#Deljournee')[0].reset();
        //                 $('#modalEditMatch').modal('hide');

        //                 Command: toastr["success"]("Rencontre supprimée avec succès", "success")

        //                 toastr.options = {
        //                     "closeButton": true,
        //                     "debug": false,
        //                     "newestOnTop": false,
        //                     "progressBar": true,
        //                     "positionClass": "toast-top-right",
        //                     "preventDuplicates": false,
        //                     "onclick": null,
        //                     "showDuration": "300",
        //                     "hideDuration": "1000",
        //                     "timeOut": "5000",
        //                     "extendedTimeOut": "1000",
        //                     "showEasing": "swing",
        //                     "hideEasing": "linear",
        //                     "showMethod": "fadeIn",
        //                     "hideMethod": "fadeOut"
        //                 }
        //             }
        //         },error:function(err){
                    
        //         }
        //     });

        // });
    });
</script>