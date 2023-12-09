@extends('layouts.publicJC')
@section('title', "Journees- Div II")
@section('nom', "Journées du championnat")
@section('saison', $championnat->nom_saison)
@section('etat', $championnat->nom_etat)
@section('division', $championnat->nom_division)
@section('championnat', $championnat->nom_championnat)


@section('btn-groupe')
<div class="btn-group pb-3">
    <a href="" class="btn btn-success btn-group text-warning linkJournees">Journée</a>
    <a href="" class="btn btn-success btn-group linkClassement">Classement</a>
</div>
@endsection

@section('content')
<div class="card p-3 journees">


    @foreach ($journees as $journee)
        <p class="mt-3">
            <button class="btn btn-outline-success form-control btnJour" data-id="{{$journee->id}}"  type="button" data-bs-toggle="collapse" data-bs-target="#content{{$journee->id}}" aria-expanded="false"
                    aria-controls="content{{$journee->id}}">
                    {{$journee->nom_journee}}
            </button>
        </p>
        <div class="collapse card pb-2" id="content{{$journee->id}}">
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
                <tbody class="tb{{$journee->id}}">
                    
                </tbody>
            </table>
        </div>
    @endforeach

    {{--
    <p class="mt-3">
        <button class="btn btn-outline-success form-control" type="button" data-bs-toggle="collapse" data-bs-target="#contentId" aria-expanded="false"
                aria-controls="contentId">
            Journée 1
        </button>
    </p>
    <div class="collapse card pb-2" id="contentId">
        <table class="table-bordered">
            <tr>
                <th>Date</th>
                <th>Hôte</th>
                <th>Scores</th>
                <th>Visiteurs</th>
                <th>Stades</th>
            </tr>
            <tr>
                    <td>Le 12mars2022</td>
                    <td>CoinNord</td>
                    <td class="text-center">2-0</td>
                    <td>Apache Club</td>
                    <td>Mitsamiouli</td>
                
            </tr>
        </table>
    </div>

    <p>
        <button class="btn btn-outline-success form-control" type="button" data-bs-toggle="collapse" data-bs-target="#contentId2" aria-expanded="false"
                aria-controls="contentId">
            Journée 2
        </button>
    </p>
    <div class="collapse card" id="contentId2">
        <table>
            <tr>
                <th>Date</th>
                <th>Hôte</th>
                <th>Scores</th>
                <th>Visiteurs</th>
                <th>Stades</th>
            </tr>
            <tr>
                    <td>Le 12mars2022</td>
                    <td>CoinNord</td>
                    <td>2-0</td>
                    <td>Apache Club</td>
                    <td>Mitsamiouli</td>
                
            </tr>
        </table>
    </div>--}}
</div>

<div class="classement">
    <div class="card-header text-center">
        
            Classement <strong>
           @if ($championnat->officiel == 0)
               provisoir 
               @else
               officiel
           @endif </strong> : {{$championnat->nom_championnat}} / {{$championnat->nom_etat}} / {{$championnat->nom_division}} / {{$championnat->nom_saison}}
        
    </div>
    <div class="card-footer p-3">
        
     
        <table class="table text-center table-responsive table-bordered tb_classements">
            <tr>
                <thead>
                    <tr>
                        <th>Rg</th>
                        <th>Club</th>
                        <th>MJ</th>
                        <th>MG</th>
                        <th>MN</th>
                        <th>MP</th>
                        <th>BM</th>
                        <th>BE</th>
                        <th>DF</th>
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classements as $key=>$cls)
                    <tr @if ($loop->iteration <= $championnat->nombre_equipes_montes) class="bg-success" @endif
                        @if ($loop->iteration >= $championnat->position_descente) class="bg-danger" @endif
                    >
                        <td>{{$key+1}}</td>
                        <td>{{$cls->abreviation}}</td>
                        <td>{{$cls->MJ}}</td>
                        <td>{{$cls->MG}}</td>
                        <td>{{$cls->MN}}</td>
                        <td>{{$cls->MP}}</td>
                        <td>{{$cls->BM}}</td>
                        <td>{{$cls->BE}}</td>
                        <td>{{$cls->DF}}</td>
                        <td><strong>{{$cls->Pts}}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </tr>
        </table>
    </div>

    {{--  --}}<hr>
    <div class="row">
        @if ($countMsg != 0)
        <div class="col-md-12 text-left">
            <div class="car text-whit mt-4">
                <div class="card-body">
                    <strong>Informations du championnats</strong>
                    {{-- <button class="btn btn-info float-end afficheModalAjoutInfo" data-bs-toggle="modal" data-bs-target="#modelClassementAdd">Ajouter une info</button> --}}
                </div>
                <div class="card-foote">
                    <ul id="">
                        @foreach ($msgs as $msg)
                            <li>{{ $msg->message }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>


@endsection
@section('Js')
    <script>
        $(document).ready(function(){


            $(".classement").fadeOut(1, function(){
            $(".journees").fadeIn(1000)
            });


            $(document).on('click', '.linkJournees', function(e){
                e.preventDefault();
                $('.classement').fadeOut(1);
                $(".journees").fadeIn(1000);
                $('.linkJournees').addClass("text-warning");
                $(".linkClassement").removeClass("text-warning");
            });

            $(document).on('click', '.linkClassement', function(e){
                e.preventDefault();
                $('.classement').fadeIn(1000);
                $(".journees").fadeOut(1);
                $('.linkClassement').addClass("text-warning");
                $(".linkJournees").removeClass("text-warning");
            });

        });
    </script>
@endsection 