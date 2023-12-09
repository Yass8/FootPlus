<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-6.1.1-web/css/all.css')}}">
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
            <input type="text" placeholder="Recherche rapide d'un championnat" id="search">
        </div>
    </header> 
    <div class="row justify-content-center resultatRecherche" style="">
        <div class="col-md-6 p-2 shadow mt-5" style="padding-left: 10px;border-radius:5px;/*border:1px solid #22673C*/">
            <h6 class="text-center text-muted">Résultats du recherche rapide</h6>
            <div id="listeResultats" class="p-5"></div>
        </div>  
    </div>
    <div class="blocJournee ">
        <div class="row col-md-12">
            <div class="col-md-4 p-4">

                <h3 style="color: #22673C;" class="anime" speed="150">@yield('saison') / @yield('etat') / @yield('division')</h3>            
            </div>
            <div class="col-md-1 ligne">

            </div>
            <div class="col-md-4">
                
            <h1 style="margin: 50px;" class="animeVert" speed="150" delay="8400">@yield('championnat')</h1>
                <h6 class="anime anime-typing m-2" speed="160" delay="12600">@yield('nom')</h6>

            </div>
        </div>
        <div class="m-1">
            <h5 style="color: #22673C;" class="anime anime-typing" speed="160" delay="12600">Editer le 30 mars 2021 - by FFC</h5>

        </div>
    </div>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 mt-5 pt-2">
            <a href="/" class="float-start text-success"> <i class="fa fa-home"></i> Home</a>
            
            <div class="text-center">@yield('btn-groupe')</div>

            @yield('content')
        </div>
    </div>
    
    
    <div class="card-footer text-center mt-3">
<p>By yass@com</p>
    </div>
    <script src="{{asset('assets/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- <script src="assets/bootstrap/js/dist/collapse.js"></script> -->
    <script src="{{asset('assets/jquery.min.js')}}"></script>
    <script src="{{asset('assets/fontawesome-free-6.1.1-web/js/all.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

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
        $(document).ready(function () {
            $('.btnJour').click(function (e) { 
                e.preventDefault();
                var idJournee = $(this).data('id');
                // console.log(idJournee);
                $.ajax({
                type: "GET",
                url: "/lesRencontres/"+idJournee,
                success: function (response) {
                    // console.log(response);

                    $('.tb'+idJournee).html("");
                    $.each(response.rencontres, function (key, item){
                        
                        $('.tb'+idJournee).append('<tr>\
                        <td>'+item.dat+'</td>\
                        <td>'+item.home+'</td>\
                        <td class="text-center score'+item.id+'">\
                            <strong>'+item.buts_home+' - '+item.buts_visit+'</strong>\
                        </td>\
                        <td>'+item.visit+'</td>\
                        <td>'+item.lieu+'</td>\
                        </tr>');
                        if(item.repporter==1)
                        {
                            $('.score'+item.id).html("");
                            $('.score'+item.id).append('<strong><span class="text-danger">REP</span></strong>');
                        }else{
                            if (item.jouer==0) {

                                $('.score'+item.id).html("");
                                $('.score'+item.id).append('<strong>-</strong>');
                                
                            }
                        }
                    });
                }
                });
            });
        });
    </script>
    @yield('Js')

</body>
</html>