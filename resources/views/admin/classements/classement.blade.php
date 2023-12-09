
<!-- Button trigger modal --
<button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modelId">
  Launch
</button>-->

{{-- Modal ajout info --}}
<div class="modal fade" id="modelClassementAdd" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajout d'une info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="ErrorAddInfo"></ul>
                <form action="" method="post" id="formAddInfo">
                    <input type="hidden" value="" id="idChampionnat">
                    <div class="mb-3">
                    <label for="info" class="form-label">Info</label>
                    <textarea class="form-control float-left message" name="" id="" placeholder="Saisir votre message">
                        
                    </textarea>
                    {{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-danger">Supprimer</button> --}}
                <button type="button" class="btn btn-primary btnAjoutInfo">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit-->
<div class="modal fade" id="modelClassementEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="lesErreursDuRequete"></ul>
                <form action="" method="post" id="formUptInfo">
                    <div class="mb-3">
                        <input type="hidden" class="idInfoEdit"><br>
                        <label for="info" class="form-label">Info</label>
                        <textarea class="form-control float-left MsgE" name="" id="" rows="5">
                          Ajoutt de 3 points à l'équipe Petit original et Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae veritatis fuga aliquid, omnis corporis facilis iusto mollitia perferendis quam, ratione illum hic, architecto ipsam obcaecati quae commodi aspernatur sint distinctio.
                        </textarea>
                        {{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-danger BtnSupprInfo">Supprimer</button>
                <button type="button" class="btn btn-primary BtnModInfo">Modifier</button>
            </div>
        </div>
    </div>
</div>

<script>
    listesInfos();
    function listesInfos()
    {
        $.ajax({
        type: "GET",
        url: "/infos/"+$('.champ_id').val(),
        dataType: "json",
        success: function (response) {
            $('#listeInfos').html("");
            $.each(response.pvs, function(key, values) {
                $('#listeInfos').append(`<li>
                    <a href="" class="btnAfficheModalEdit"
                    data-bs-toggle="modal" data-bs-target="#modelClassementEdit"
                    onClick="document.querySelector('.MsgE').value = '${values.message}';document.querySelector('.idInfoEdit').value = '${values.id}';"
                    >${values.message}</a>
                </li>`);

            });
        }
        });
    }
    
    // modifier les parametres
    $(document).on('click', '.BtnModParametre', function(e){
            e.preventDefault();
            let officiel = 0;
            // console.log($('.officiel').get(0).checked);
            if ($('.officiel').get(0).checked) {
                officiel = 1;
            }
            var datas = {
                "_token": "{{ csrf_token() }}",
                'nombre' : $('.nombre').val(),
                'position' : $('.position').val(),
                'officiel' : officiel
            }
            // console.log(datas);
            
            requete("PUT","/parametres/"+$('.champ_id').val(),datas,function (rep) { 
                // console.log(rep);
                if ("status" in rep && rep.status === "success") {
                    $('#lesErreursDuParam').html("");
                    $('#lesErreursDuParam').removeClass('alert alert-danger');
                    $('.tb_classements').load(location.href+' .tb_classements');
                    $('.m_office').html(rep.officiel);
                    console.log(rep.officiel);
                    toast("Paramètres modifiés avec succès !");
                    
                }
                if ("errors" in rep) {
                    // console.log(rep.errors);
                    $('#lesErreursDuParam').html("");
                    $('#lesErreursDuParam').addClass('alert alert-danger');

                    $.each(rep.errors, function(key, err_values) {
                        $('#lesErreursDuParam').append('<li>'+err_values+'</li>');
                    });
                }
            });

    });

    // modifier l'info
    $(document).on('click', '.BtnModInfo', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}",
                'message' : $('.MsgE').val()
            }

            //;
            requete("PUT","/infos/"+$('.idInfoEdit').val(),datas,function (rep) { 
                // console.log(rep);
                if ("status" in rep && rep.status === "success") {
                    $('#lesErreursDuRequete').html("");
                    $('#lesErreursDuRequete').removeClass('alert alert-danger');
                    $('#formUptInfo')[0].reset();
                    $('#modelClassementEdit').modal('hide');
                    toast("Info modifiée avec succès !");
                    listesInfos();
                }
                if ("errors" in rep) {
                    // console.log(rep.errors);
                    $('#lesErreursDuRequete').html("");
                    $('#lesErreursDuRequete').addClass('alert alert-danger');

                    $.each(rep.errors, function(key, err_values) {
                        $('#lesErreursDuRequete').append('<li>'+err_values+'</li>');
                    });
                }
            });

    });

    // supprimer l'info
    $(document).on('click', '.BtnSupprInfo', function(e){
            e.preventDefault();
            var datas = {
                "_token": "{{ csrf_token() }}",
            }

            //;
            requete("DELETE","/infos/"+$('.idInfoEdit').val(),datas,function (rep) { 
                // console.log(rep);
                if ("status" in rep && rep.status === "success") {
                    $('#lesErreursDuRequete').html("");
                    $('#lesErreursDuRequete').removeClass('alert alert-danger');
                    $('#formUptInfo')[0].reset();
                    $('#modelClassementEdit').modal('hide');
                    toast("Info supprimé avec succès !");
                    listesInfos();
                }
            });

    });

    

    //affiche modal to edit
    $(document).on('click','.btnAfficheModalEdit',(e)=>{
        e.preventDefault();
        let id = $(this).data('id');

        // let id = $(this).data('id');
        let message = $(this).data('message');
        // console.log($(this).data('idC'));
    });

    //Affiche modal to add info
    $(document).on('click','.afficheModalAjoutInfo',(event)=>{
        event.preventDefault();
        $('#idChampionnat').val($('.champ_id').val());
    });
    //Ajout une info
    $(document).on('click','.btnAjoutInfo', (e)=>{
        e.preventDefault();
        var data = {
            "_token": "{{ csrf_token() }}",
            'championnat' : $('#idChampionnat').val(),
            'info': $('.message').val()
        }

        $.ajax({
            type: "POST",
            url: "/infos",
            data: data,
            dataType: "json",
            success: function (response) {
                    if(response.status == 'success')
                    {
                        $('#ErrorAddInfo').html("");
                        // $('#errorList').deleteClass('alert alert-danger');
                        $('#formAddInfo')[0].reset();
                        $('#modelClassementAdd').modal('hide');
                        // alert("championnat ajouté avec succèe");
                        // $('.tb_equipes').load(location.href+' .tb_equipes');
                        listesInfos();

                        Command: toastr["success"]("Information enregistrée avec succès", "success")

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

                    $('#ErrorAddInfo').html("");
                    $('#ErrorAddInfo').addClass('alert alert-danger');

                    $.each(error.errors, function(key, err_values) {
                        $('#ErrorAddInfo').append('<li>'+err_values+'</li>');
                    });
                } 
        });
    });
</script>