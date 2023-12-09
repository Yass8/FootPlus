@extends('layouts.publicJC')
@section('title', "Classement- Div II")
@section('nom', "Classement du championnat")

@section('btn-groupe')
<div class="btn-group pb-3">
    <a href="{{route('journees')}}" class="btn btn-success btn-group">Journée</a>
    <a href="{{route('classement')}}" class="btn btn-success btn-group"><span class="text-warning">Classement</span></a>
</div>
@endsection

@section('content')



<div class="card p-3">
    <p class="text-center">
        2021-2022 / Ngazidja / Deuxième division / Division II - poule B
    </p>
 
    <table class="table table-responsive table-bordered tb_classements">
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
                    <td>{{$key+1}}</td>
                    <td>{{$cls->nom_equipe}}</td>
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
@endsection

{{-- <table class="table-bordered">
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
                <tr>
                 <td>1</td>
                 <td>CoinNord</td>
                 <td>9</td>
                 <td>6</td>
                 <td>3</td>
                 <td>0</td>
                 <td>10</td>
                 <td>2</td>
                 <td>8</td>
                 <td><strong>21</strong></td>
                </tr>
            </tbody>
        </tr>
    </table> --}}