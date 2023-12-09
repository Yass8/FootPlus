

{{-- Modal Edit & Delete --}}


<!-- Modal -->
<div class="modal fade" id="modelIdEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form action="" method="post" id="formUpt">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Modification d'une équipe</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <ul id="errorListUpdate"></ul>

                        @csrf
                        <div class="mb-3">
                          <label for="" class="form-label">Equipe</label>
                          <input type="text" class="form-control equipe_up" name="" id="" placeholder="">
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
    var modelIded = document.getElementById('modelIdEdit');

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
<div class="modal fade" id="modalSup" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form id="DelEquipe">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Suppression d'une équipe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        <p>Êtes-vous sur de voiloire supprimer l'équipe <strong id="del_equipe"></strong> ?</p>
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
</div>



{{-- Script Equipes --}}
<script>
    $(document).ready(function () {

        optionsClubs();

        function optionsClubs()
        {
            $.ajax({
            type: "GET",
            url: "/options/"+$('.champ_id').val(),
            dataType: "json",
            success: function (response) {
                // console.log(response);
                // $('#jrSelect').html("");
                $('#EquipesHomes').html("");
                $('#EquipesVisits').html("");

                $.each(response.equipes, function(key, values) {
                    $('#EquipesHomes').append('<option value="'+values.id+'">'+values.nom_equipe+'</option>');
                    $('#EquipesVisits').append('<option value="'+values.id+'">'+values.nom_equipe+'</option>');
                    
                });
            }
            });
        }

        // Ajout equipe
        $('.bouton_ajouter_equipe').click(function (e) { 
            e.preventDefault();
            var donnees = {
                "_token": "{{ csrf_token() }}",
                'equipe': $('.equipe_add').val(),
                'abrev': $('.abrev_add').val(),
                'champ_id': $('.champ_id').val()
            }

            requete("POST","/equipes",donnees,(response)=>{
                if(response.status == 'success')
                {
                    $('#errorListAddEquipe').html("");
                    // $('#errorList').deleteClass('alert alert-danger');
                    $('#formAddEquipe')[0].reset();
                    // alert("championnat ajouté avec succèe");
                    $('.tb_equipes').load(location.href+' .tb_equipes');
                    $('.tb_classements').load(location.href+' .tb_classements');
                    optionsClubs();
                    $('#modalAddEquipe').modal('hide');
                    toast("Equipe enregistrée avec succès !");                        
                }
                if ("errors" in response) {
                    $('#errorListAddEquipe').html("");
                    $('#errorListAddEquipe').addClass('alert alert-danger');

                    $.each(response.errors, function(key, err_values) {
                            $('#errorListAddEquipe').append('<li>'+err_values+'</li>');
                    });
                }
            });

            /*$.ajax({
                type: "POST",
                url: "/equipes",
                data: donnees,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success')
                    {
                        $('#errorListAddEquipe').html("");
                        // $('#errorList').deleteClass('alert alert-danger');
                        $('#formAddEquipe')[0].reset();
                        // alert("championnat ajouté avec succèe");
                        $('.tb_equipes').load(location.href+' .tb_equipes');
                        $('.tb_classements').load(location.href+' .tb_classements');
                        optionsClubs();

                        Command: toastr["success"]("Equipe enregistrée avec succès", "success")

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

                    $('#errorListAddEquipe').html("");
                    $('#errorListAddEquipe').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                            $('#errorListAddEquipe').append('<li>'+err_values+'</li>');
                    });
                }    
                
            });*/
        });

        //Edit Modal
        $(document).on('click', '.edit_btn', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let equipe = $(this).data('equipe');
            let abrev = $(this).data('abrev');

            $('.equipe_up').val(equipe);
            $('.abrev_up').val(abrev);
            $('.ID').val(id);
            // console.log(equipe+" "+id);
        });

        //modification equipes
        $(document).on('click', '.BtnMod', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}",
                'equipe' : $('.equipe_up').val(),
                'abrev' : $('.abrev_up').val(),
                'id': $('.ID').val()
            }
            $.ajax({
                type: "PUT",
                url: "/equipes/"+$('.ID').val(),
                data: datas,
                dataType: "json",
                success: function(res){
                    if(res.status == 'success')
                    {
                        $('#errorListUpdate').html("");
                        $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#formUpt')[0].reset();
                        // alert("equipes Modifié avec succèe");
                        $('#modelIdEdit').modal('hide');
                        $('.tb_equipes').load(location.href+' .tb_equipes');

                        Command: toastr["success"]("Equipes modifiée avec succès", "success")

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
             let equipe = $(this).data('equipe');

             $('#del_equipe').html(equipe);
            $('#del_id').val(id);
            // console.log(equipes);
        });

        //Suppresion equipes
        $(document).on('click', '.BTN_SUP', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                type: "DELETE",
                url: "/equipes/"+$('#del_id').val(),
                data: datas,
                success: function(res){
                    if(res.status == 'success')
                    {
                        // $('#errorListUpdate').html("");
                        // $('#errorListUpdate').removeClass('alert alert-danger');
                        $('#DelEquipe')[0].reset();
                        // alert("equipes supprimé avec succès");
                        $('#modalSup').modal('hide');
                        $('.tb_equipes').load(location.href+' .tb_equipes');

                        Command: toastr["success"]("equipes supprimée avec succès", "success")

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