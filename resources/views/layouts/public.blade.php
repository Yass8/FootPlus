<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FFC</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">

</head>
<body>
    {{-- <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #EBF1EF;">
          <div class="container">
            <a class="navbar-brand" href="index.html" style="color: #22673C;">FFC</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"></a>
                    </li>
                    <!-- <li class="nav-item drdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdonId" data-bs-toggle="drpdown" aria-haspopup="false" aria-expanded="false"></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="#">Action 1</a>
                            <a class="dropdown-item" href="#">Action 2</a>
                        </div>
                    </li>-->
                </ul> 
                <form class="d-flex my-2 my-lg-0">
                    <input class="form-control me-md-2 col-md-5" type="text" placeholder="Recheche rapide d'un championnat">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
      </div>
    </nav> --}}
    <header>
        <h1>FFC</h1>
        <div class="linput">
            <input type="text" id="search" placeholder="Recherche rapide d'un championnat">
        </div>
    </header> 
    <div class="row justify-content-center resultatRecherche" style="">
        <div class="col-md-6 p-2 shadow mt-5" style="padding-left: 10px;border-radius:5px;/*border:1px solid #22673C*/">
            <h6 class="text-center text-muted">Résultats du recherche rapide</h6>
            <div id="listeResultats" class="p-5">
                {{-- <p id="mot"></p> --}}
                {{-- <ul id="listeResultats">

                </ul> --}}
                {{-- <a href="" class="text-decoration-none text-success"><strong>Ligue 2 - poule A</strong></a> --}}
            </div>
            {{--<div>
                <p class="text-dark text-center"><strong class="noResultats"></strong></p>
            </div>--}}
        </div>
        
    </div>
    <div class="bloc" style="background-size: cover;background-image: url('{{asset('assets/images/football-g76ab2afd4_1920.jpg')}}');">
        <h1 style="color: #22673C;" class="anime" speed="150">FEDERATION DE FOOTBALL</h1>
        <h1 style="color: #22673C;" class="anime" speed="150" delay="4200">DES COMORES</h1>

        <h1 style="margin: 50px;" class="animeVert" speed="150" delay="8400">CHAMPIONNATS DES COMORES</h1>

        <h5 class="text-dark anime anime-typing" speed="160" delay="12600">NGAZIDJA-NDZUANI-MWALI</h5>
    </div>
    
    @yield('content')

    
    <div class="card-footer text-center">
        <p>By yass@com</p>
    </div>

    <script src="{{asset('assets/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/jquery.min.js')}}"></script>
    {{-- <script src="{{asset('assets/select2/dist/js/select2.min.js')}}"></script> --}}
    <script src="{{asset('js/main.js')}}"></script>
    {{-- <script>
        $(document).ready(function(){
            $('.select2').select2();
        });
    </script> --}}
    @yield('Js')

    <script>
        $(document).ready(function () {
            $('.resultatRecherche').hide();
            // $(document).on('',function)
            $('#search').keyup(function (e) { 
                e.preventDefault();
                var mot = $('#search').val();
                if (mot == "") {
                    $('.resultatRecherche').hide();
                } else {
                    $('.resultatRecherche').show();
                    // $('#mot').html(mot);
                    var datas = {
                        "_token": "{{ csrf_token() }}",
                        'mot' : mot,
                        
                    }
                    $.ajax({
                        type: "POST",
                        url: "/search",
                        data: datas,
                        dataType: "json",
                        success: function (response) {
                            $('#listeResultats').html("");
                            if (response.count >= 1) {
                                $('.noResultats').html("");
                                $.each(response.championnats, function(key, values) {
                                    $('#listeResultats').append(`<div>
                                        <h3><a href="/championnat/${values.cid}" class="text-decoration-none text-success"><strong>${values.nom_championnat}</strong></a></h3>
                                        <p>${values.nom_saison} / ${values.nom_etat} / ${values.nom_division}</p>
                                    </div>`);
                                });
                            } else {
                                $('#listeResultats').html("<p class='text-center'>Aucun correspondance de votre recherche !</p>");
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>