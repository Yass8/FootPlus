<!-- Button trigger modal --
<button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modelIdEdit">
  Launch
</button>-->

<!-- Modal -->
<div class="modal fade" id="modelIdEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form action="" method="post" id="formUpt">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Modification d'une division</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <ul id="errorListUpdate"></ul>

                        @csrf
                        <div class="mb-3">
                          <label for="" class="form-label">Division</label>
                          <input type="text" class="form-control division_up" name="" id="" placeholder="">
                          {{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
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

{{-- <script>
    var modelIded = document.getElementById('modelIdEdit');

    modelIded.addEventListener('show.bs.modal', function (event) {
          // Button that triggered the modal
          let button = event.relatedTarget;
          // Extract info from data-bs-* attributes
          let recipient = button.gdivisiontribute('data-bs-whatever');

        // Use above variables to manipulate the DOM
    });
</script> --}}



<!--- Suppression --->
<!-- Button trigger modal --
<button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalSup">
  Launch
</button>-->

<!-- Modal de suppression-->
<div class="modal fade" id="modalSup" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
<form id="Deldivision">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Suppression d'une division</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid text-center">
                    <p>Êtes-vous sûre de voiloire supprimer la division <strong id="del_division"></strong> ?</p>
                    <p class="text-muted">Cliquez OUI pour Supprimer ou NON pour annuler l'opération.</p>
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
