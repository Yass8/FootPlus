@extends('layouts.dash.dashboard')
@section('titre', $championnat->nom_championnat)
@section('Title', "Champioonats - FFC")

@section('content')

<input type="hidden" value="{{$championnat->idChamp}}" class="champ_id">
<input type="hidden" value="{{$championnat->cid}}" class="champ_cid">
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">{{$championnat->nom_saison}} | {{$championnat->nom_etat}} | {{$championnat->nom_division}}</li>
</ol>
<div class="text-success mb-3">
    <a href="" class="link_equipes">Equipes</a>
    <a href="" class="link_journees">Calendrier</a>
    <a href="" class="link_classement">Classement</a>
</div>
<div class="equipes">
    <div class="row">
        {{-- <div class="col-xl-5 col-md-6">
            <div class="card text-whit mb-4">
                <div class="card-body"><strong>Ajouter une équipe</strong></div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <ul id="errorListAddEquipe"></ul>
    
                    <form action="" method="post" id="formAddEquipe">
                        
                        <div class="mb-3">
                          <label for="" class="form-label">Equipe</label>
                          <input type="text" class="form-control equipe_add" name="" id="" placeholder="Nom de l'équipe">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Abréviation</label>
                            <input type="text" class="form-control abrev_add" name="" id="" placeholder="Abréviation de l'équipe">
                        </div>
                        <button type="submit" class="btn btn-success bouton_ajouter_equipe">Ajouter</button>
                    </form>
                </div>
            </div>
        </div> --}}

        
        <!-- Modal Add equipe -->
        <div class="modal fade" id="modalAddEquipe" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajout d'une équipe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
                    </div>
                    <div class="modal-body">
                        <ul id="errorListAddEquipe"></ul>
    
                    <form action="" method="post" id="formAddEquipe">
                        
                        <div class="mb-3">
                          <label for="" class="form-label">Equipe</label>
                          <input type="text" class="form-control equipe_add" name="" id="" placeholder="Nom de l'équipe">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Abréviation</label>
                            <input type="text" class="form-control abrev_add" name="" id="" placeholder="Abréviation de l'équipe">
                        </div>
                    </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                        {{-- <button type="button" class="btn btn-primary">Ajouter</button> --}}
                        <button type="submit" class="btn btn-success bouton_ajouter_equipe">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <strong>Listes des équipes</strong>
                    <button class="float-end btn btn-info" data-bs-toggle="modal" data-bs-target="#modalAddEquipe">Ajouter une équipe</button>
                </div>
                <div class="card-footer d-fle align-items-center justify-content-between">
    
                    <table class="table table-bordered table-stripped tb_equipes">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Equipes</th>
                                <th>Abreviations</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipes as $key=>$equipe)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$equipe->nom_equipe}}</td>
                                <td>{{$equipe->abreviation}}</td>
                                <td><a href=""
                                    class="btn btn-sm btn-success edit_btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modelIdEdit"
                                    data-id="{{ $equipe->id }}"
                                    data-equipe="{{ $equipe->nom_equipe }}"
                                    data-abrev="{{ $equipe->abreviation }}"
                                    >
                                    <i class="text-white fas fa-edit"></i>
                                    </a> 
                                    <a href="" class="btn btn-sm btn-danger delete_btn"
                                    data-bs-toggle="modal" data-bs-target="#modalSup"
                                    data-id="{{ $equipe->id }}"
                                    data-equipe="{{ $equipe->nom_equipe }}"
                                    >
                                    <i class="fas fa-trash"></i>
                                </a>
                                <a href="{{route('equipes.show', $equipe->ref_equipe)}}" class="btn btn-sm btn-info">
                                    <i class="text-white fas fa-info-circle"></i>
                                </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="journees">
    <div class="row">
        <div class="col-md-6">
            <div class="card text-whit mb-4">
                <div class="card-body"><strong>Ajouter une journée</strong></div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <ul id="errorListAddJournee"></ul>
    
                    <form action="" method="post" id="formAddJournee">
                        
                        <div class="mb-3">
                          <label for="" class="form-label">Nombre de journées du championnat : <strong><span class="nbJournee">{{$countJournee}}</span></strong></label>
                          {{-- <input type="text" class="form-control journee_add" name="" id="" placeholder="Journée"> --}}
                        </div>
                        <button type="submit" class="btn btn-success bouton_ajouter_journee mb-3">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body"><strong>Listes des journées</strong></div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <p class="mt-3">Cliquer ce menu déroulant pour choisir une journée afin de la méttre à jour.</p>
                    <div class="btn-group mb-4">
                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                    Liste des journées du championnat
                        </button>
                        <div class="dropdown-menu dropdown-menu-start" aria-labelledby="triggerId">
                            <table class="ls_journees">
                                @foreach ($journees as $journee)
                                    <tr>
                                        <td>
                                            <a class="dropdown-item btn-Edit-Journee"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modelIdEditJournee" 
                                                href=""
                                                data-id="{{$journee->id}}"
                                                data-journee="{{$journee->nom_journee}}">
                                                    {{$journee->nom_journee}}
                                            </a>  
                                        </td>
                                    </tr>                             
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-md-6">
            <div class="card text-whit mb-4">
                <div class="card-body"><strong>Ajouter une rencontre</strong></div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <ul id="errorListAddRecontre"></ul>
    
                    <form action="" method="post" id="formAddRecontre">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="" class="form-label">Home</label>
                                <select class="form-control home" name="" id="EquipesHomes">
                                    <option value=""></option>
                                    {{-- @foreach ($equipes as $equipe)
                                        <option value="{{$equipe->id}}">{{$equipe->nom_equipe}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="" class="form-label">Visiteur</label>
                                <select class="form-control visiteur" name="" id="EquipesVisits">
                                    <option value=""></option>
                                    {{-- @foreach ($equipes as $equipe)
                                        <option value="{{$equipe->id}}">{{$equipe->nom_equipe}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
    
                        <div class="mb-3">
                          <label for="" class="form-label">Journée</label>
                          <select class="form-control journ" name="" id="jrSelect">
                            <option value=""></option>
                                {{-- @foreach ($journees as $journee)
                                    <option value="{{$journee->id}}">{{$journee->nom_journee}}</option>
                                @endforeach --}}
                          </select>
                        </div>
    
                        <div class="mb-3">
                            <label for="" class="form-label">Stade</label>
                            <input type="text" class="form-control lieu" name="" id="" placeholder="Lieu de rencontre">
                        </div>
    
                        <div class="mb-3">
                            <label for="" class="form-label">Date du rencontre</label>
                            <input type="date" class="form-control date" name="" id="" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Heure du rencontre</label>
                            <input type="time" class="form-control heure" name="" id="" placeholder="">
                        </div>
    
                        <div class="text-center">
                            <button type="submit" class="btn btn-success bouton_ajouter_rencontre">Ajouter la rencontre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body"><strong>Calendrier</strong></div>
                <div class="card-footer d-fle align-items-center justify-content-between listeJournees">
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
                    {{-- @foreach ($journees as $k=>$j)
                    <button class="but" data-id="{{$k+1}}">BUT</button>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="classement">
    <div class="row">
        <div class="col-md-8">
            <div class="card text-whit mb-4">
                <div class="card-body"><strong>Classement <span class="m_office"> @if ($championnat->officiel === 1)
                    officiel
                @else
                    provisoir
                @endif
                </span>
                 du championnat</strong>
                </div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <table class="table table-responsive table-bordered text-center tb_classements">
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
                                <tr>
                                    <td @if ($loop->iteration <= $championnat->nombre_equipes_montes) class="bg-success" @endif
                                        @if ($loop->iteration >= $championnat->position_descente) class="bg-danger" @endif
                                    >{{$key+1}}</td>
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card text-whit mb-4">
                <div class="card-body">
                    <strong>Informations du championnats</strong>
                    <button class="btn btn-info float-end afficheModalAjoutInfo" data-bs-toggle="modal" data-bs-target="#modelClassementAdd">Ajouter une info</button>
                </div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <ul id="listeInfos">
                        <li><a href="" data-bs-toggle="modal" data-bs-target="#modelClassementEdit">Ajoutt de 3 points à l'équipe Petit original et kl</a></li>
                        <li><a href="" data-bs-toggle="modal" data-bs-target="#modelClassementEdit">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora totam laudantium veniam! Possimus aliquid veniam, maiores nostrum eaque illo modi tenetur unde omnis praesentium atque alias asperiores dignissimos ducimus aliquam.</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- Parametres du championnats --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card text-whit mb-4">
                <div class="card-body">
                    <strong>Paramètres du championnat</strong>
                </div>
                <div class="card-footer d-fle align-items-center justify-content-between">
                    <ul id="lesErreursDuParam"></ul>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre d'équipes qui vont à la division <strong>suppérieur</strong> la saison prochaine</label>
                        <div class="row">
                            <div class="col-2">
                                <input type="number" min="1" max="3" value="{{$championnat->nombre_equipes_montes}}" class="form-control nombre" id="nombre">
                            </div>
                            {{-- <div class="col-3">
                                <button class="btn btn-info">Mettre à jour</button>
                            </div> --}}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">A partir de quelle position les équipes seront dans la barre rouge ?</label>
                        <div class="row">
                            <div class="col-2">
                                <input type="number" min="1" value="{{$championnat->position_descente}}" class="form-control position" id="position">
                            </div>
                        </div>                           
                    </div>

                    <div class="mb-3">
                        <label for="office" class="form-label"><strong>Officialiser le classement</strong> </label>
                        <input type="checkbox" name="" class="form-check-inline officiel" id="office"
                        @if ($championnat->officiel === 1)
                            checked
                        @endif
                        >
                    </div>
                    <button class="btn btn-info col-4 BtnModParametre">Mettre à jour</button>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- @include('admin.championnats.editChampionnat') --}}

@endsection
@section('scriptJs')

<script>

    
    $(document).ready(function(){


        $(".journees").fadeOut(1, function(){
          $(".equipes").fadeIn(1000)
        });

        $(".classement").fadeOut(1, function(){
          $(".equipes").fadeIn(1000)
        });

        $(document).on('click', '.link_equipes', function(e){
            e.preventDefault();
            $('.equipes').fadeIn(1000);
            $('.classement').fadeOut(1);
            $(".journees").fadeOut(1);
        });

        $(document).on('click', '.link_journees', function(e){
            e.preventDefault();
            $('.equipes').fadeOut(1);
            $('.classement').fadeOut(1);
            $(".journees").fadeIn(1000);
        });

        $(document).on('click', '.link_classement', function(e){
            e.preventDefault();
            $('.equipes').fadeOut(1);
            $('.classement').fadeIn(1000);
            $(".journees").fadeOut(1);
        });

    });


</script>

@include('admin.equipes.equipe')
@include('admin.journees.journee')
@include('admin.rencontres.rencontre')
@include('admin.matchs.match')
@include('admin.classements.classement')

{!! Toastr::message() !!}
@endsection