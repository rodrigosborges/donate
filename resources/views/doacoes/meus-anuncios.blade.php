@extends('layouts.app')

@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="px-4 py-4">
            <h2 class="">Meus Anúncios</h2>
            <hr class="divisor">
        </div>
        @if(count($anuncios) == 0)
        <div class="col-md-12 text-center">
            <span style="font-size:1.7em">Você ainda não possui nenhum anúncio.<br><i class="far fa-frown"></i></span><br>
            <span style="font-size:1.7em">Anuncie clicando <a href="{{url('/doacoes/create')}}">aqui</a></span>
        </div>
        @endif
        @foreach($anuncios as $anuncio)
            <div class="anuncio">
                <h5 class="card-title">{{$anuncio->titulo}}</h5>
                <img src={{asset("/storage/app/anuncio_".$anuncio->id."/DonateImage_0.png") }}/><br>
                <span class="fa fa-map-marker-alt"></span>
                <span>{{$anuncio->bairro->nome}}, 
                {{$anuncio->bairro->cidade->nome}}</span><br>
                <span class="fa fa-clock"></span>
                <span>{{$anuncio->created_at}}</span><br>
                <span>Situação:</span>
                <span hidden class="situacao">{{$anuncio->aprovado}}</span>
                <?php
                if($anuncio->aprovado == 1){
                    echo '<span>Aprovado</span>';
                }else{
                    echo '<span>Em análise</span>';
                }
                ?>
                <br>
                <a href="{{url('doacoes/anuncio/'.$anuncio->id)}}" class="btn btn-danger">Ver mais</a>
            </div>
        @endforeach
    </div>
</div> 
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/anuncios/anuncios.js')}}"></script>
@endsection
