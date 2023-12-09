@extends('layouts.public')

@section('content')
<div class="align-items-center d-flex justify-content-center items-center contenu">
    {{-- <div class="col-md-4"></div> --}}
    <div class="col-md-6 col-sm-12 shadow mt-5 p-5 mb-5" style="opacity: 0.8;border-radius:5px;border: 1px solid #22673C;">
      {{-- <form action="{{route('championnat.store')}}" method="post">  
        @csrf --}}
          <table class="table table-borderless table-responsive-sm table-responsive-xl">
                <tr>
                    <td><label for="saison" class="form-label">Saison</label></td>
                    <td><div class="mb-3 ">
                      
                      <select class="form-control " name="saison" id="saison">
                        @foreach ($saisons as $saison)
                            <option value="{{$saison->id}}">{{$saison->nom_saison}}</option>
                        @endforeach
                      </select>
                    </div></td>
                </tr>
                <tr>
                    <td><label for="etat" class="form-label">Etat</label></td>
                    <td><div class="mb-3">
                      
                      <select class="form-control" name="etat" id="etat">
                        @foreach ($etats as $etat)
                            <option value="{{$etat->id}}">{{$etat->nom_etat}}</option>
                        @endforeach
                      </select>
                    </div></td>
                </tr>
                <tr>
                    <td><label for="division" class="form-label">Division</label></td>
                    <td><div class="mb-3">
                      <select class="form-control" name="division" id="division">
                        @foreach ($divisions as $division)
                            <option value="{{$division->id}}">{{$division->nom_division}}</option>
                        @endforeach
                      </select>
                    </div></td>
                </tr>
                <tr>
                    <td><label for="championnat" class="form-label">Championnat</label></td>
                    <td><div class="mb-3">
                      
                      <select class="form-control" name="championnat" id="championnat">
                        
                      </select>
                      <small id="cHelp" class="text-danger"></small>
                    </div>
                  </td>
                </tr>
          </table>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-success form-control recherche">Rechercher</button>
                {{-- <a href="" class="btn btn-outline-success form-control recherche">Rechercher</a> --}}
            </div>
      {{-- </form> --}}
    </div>
</div>

@endsection
@section('Js')
<script>
  $(document).ready(function () {

    $(document).on('click','.recherche', function (e) {
      e.preventDefault();
      // console.log($("#championnat").val());
      if ($("#championnat").val() == null) {
        $('#cHelp').html("Veuillez sélectionner un championnat !")
      } else {
        window.location.href = "/championnat/"+$("#championnat").val();
        
      }

      
    });

        clickSelect();

        function clickSelect() {
            $(document).on('click', '#saison' , function(e){
                e.preventDefault();
                var saison = $(this).val();
                var etat = $('#etat').val();
                var division = $('#division').val();
                liste(saison,etat,division);

                
            });

            $(document).on('click', '#etat' , function(e){
                e.preventDefault();
                var etat = $(this).val();
                var saison = $('#saison').val();
                var division = $('#division').val();
                liste(saison,etat,division);

                
            });

            $(document).on('click', '#division' , function(e){
                e.preventDefault();
                var saison = $('#saison').val();
                var etat = $('#etat').val();
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
                url: "/championnat/"+saison+"/"+etat+"/"+division,
                data: datas,
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    $('#championnat').html("");
                    $.each(response.championnats, function(key, champs) {
                            $('#championnat').append('<option value="'+champs.cid+'">'+champs.nom_championnat+'</option>');
                    });
                }
            });
        }
  });
</script>  
@endsection