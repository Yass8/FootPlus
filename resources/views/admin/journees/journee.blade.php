

{{-- Modal Edit & Delete --}}


<!-- Modal -->
<div class="modal fade" id="modelIdEditJournee" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form action="" method="post" id="formUptJournee">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Modification d'une journée</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <ul id="errorListUpdateJournee"></ul>

                        @csrf
                        <div class="mb-3">
                          <label for="" class="form-label">Journée</label>
                          <input type="text" class="form-control journee_up" name="" id="" placeholder="">
                        </div>
                    </div>
                    <input type="hidden" id="IDJOURNEE">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-danger BTN_SUP_Journee">Supprimer</button>
                    <button type="button" class="btn btn-success BtnModJournee">Modifier</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    var modelIded = document.getElementById('modelIdEditJournee');

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
    <form id="Deljournee">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Suppression d'une équipe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        <p>Êtes-vous sur de voiloire supprimer l'équipe <strong id="del_journee"></strong> ?</p>
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



{{-- Script journees --}}
<script>
    $(document).ready(function(){


        options();
        // rencontres();
        function options()
        {
            $.ajax({
            type: "GET",
            url: "/options/"+$('.champ_id').val(),
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $('#jrSelect').html("");
                // $('.listeJournees').html("");
                $('.nbJournee').html("");
                $('.nbJournee').html(response.nombreJournee);

                

                $.each(response.journees, function(key, values) {
                    $('#jrSelect').append('<option value="'+values.id+'">'+values.nom_journee+'</option>');
                    
                });

                /*$.each(response.journees, function(key, values) {
                   $('.listeJournees').append(`<button class="but" data-id="${key+1}">BUT</button>`);
                    /*$('.listeJournees').append(`<p class="mt-3">
                            <button data-id="${values.id}"  type="button" data-bs-toggle="collapse" data-bs-target="#content${values.id}" aria-expanded="false"
                                    aria-controls="content${values.id}" class="btn btn-outline-success form-control jrt">
                                    ${values.nom_journee}
                            </button>
                            <div class="collapse card pb-2" id="content${values.id}">
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
                                <tbody class="tb${values.id}">
                                    
                                </tbody>
                            </table>
                        </div>
                        </p>`);*
                });*/

                
            }
            });
        }

        

        // $(selector).load("url", "data", function (response, status, request) {
        //     this; // dom element
            
        // });

        // Ajout journee
        $('.bouton_ajouter_journee').click(function (e) { 
            e.preventDefault();
            var donnees = {
                "_token" : "{{ csrf_token() }}",
                // 'journee': $('.journee_add').val(),
                'champ_id': $('.champ_id').val()
            }
            
            $.ajax({
                type: "POST",
                url: "/journees",
                data: donnees,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        $('#errorListAddJournee').html("");
                        // $('#errorList').deleteClass('alert alert-danger');
                        $('#formAddJournee')[0].reset();
                        // alert("championnat ajouté avec succèe");
                        $('.ls_journees').load(location.href+' .ls_journees');
                        //$('.nbJournee').html(response.countJournee);
                        

                        options();

                        Command: toastr["success"]("Journée enregistrée avec succès", "success")

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

                        window.location.href = "/championnats/"+$('.champ_cid').val();

                    }
                },error:function(err){
                    // console.log(err.responseText);
                    let error = err.responseJSON;

                    $('#errorListAddJournee').html("");
                    $('#errorListAddJournee').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                            $('#errorListAddJournee').append('<li>'+err_values+'</li>');
                    });
                }    
                
            });
        });

        //Edit Modal
        $(document).on('click', '.btn-Edit-Journee', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let journee = $(this).data('journee');

            $('.journee_up').val(journee);
            $('#IDJOURNEE').val(id);
            // console.log(journee+" "+id);
        });

        //modification journees
        $(document).on('click', '.BtnModJournee', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}",
                'journee' : $('.journee_up').val(),
                'id': $('#IDJOURNEE').val()
            }
            $.ajax({
                type: "PUT",
                url: "/journees/"+$('#IDJOURNEE').val(),
                data: datas,
                dataType: "json",
                success: function(res){
                    if(res.status == 'success')
                    {
                        $('#errorListUpdateJournee').html("");
                        $('#errorListUpdateJournee').removeClass('alert alert-danger');
                        $('#formUptJournee')[0].reset();
                        $('#modelIdEditJournee').modal('hide');
                        $('.ls_journees').load(location.href+' .ls_journees');

                        options();

                        Command: toastr["success"]("Journees modifiée avec succès", "success")

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

                    $('#errorListUpdateJournee').html("");
                    $('#errorListUpdateJournee').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                            $('#errorListUpdateJournee').append('<li>'+err_values+'</li>');
                    });
                }
            });

        });

        //Suppresion journees
        $(document).on('click', '.BTN_SUP_Journee', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                type: "DELETE",
                url: "/journees/"+$('#IDJOURNEE').val(),
                data: datas,
                success: function(res){
                    if(res.status == 'success')
                    {
                        // $('#Deljournee')[0].reset();
                        $('#modelIdEditJournee').modal('hide');
                        $('.ls_journees').load(location.href+' .ls_journees');
                        options();
                        Command: toastr["success"]("Journées supprimée avec succès", "success")

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