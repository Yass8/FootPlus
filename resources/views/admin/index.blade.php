@extends('layouts.dash.dashboard')

@section('content')
{{-- <div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Nombres des championnats des Comores</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                {{$nombreChampionnats}} championnats au niveau national 
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Nombres des équipes au Comores</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                {{$nombreEquipes}} équipes au niveau national
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Success Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Danger Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Statistiques
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="10"></canvas>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Niveau national</h5>
                        <p>Nombres d'îles : <strong>3</strong></p>
                        <p>Nombres des championnats des Comores au niveau national : <strong>{{$nombreChampionnats}}</strong></p>
                        <p>Nombres des équipes au Comores au niveau national : <strong>{{$nombreEquipes}}</strong></p>
                        {{-- <p>Nombres d'îles : <strong>3</strong></p> --}}
                    </div>
                    <div class="col-md-6">
                        <h5>Niveau régional</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Bar Chart Example
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div> --}}
</div>
@endsection