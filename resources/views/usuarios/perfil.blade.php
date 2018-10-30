@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset('owlcarousel/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('owlcarousel/owl.theme.default.min.css')}}">
@endsection
@section('content')
<div class="container">
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
	<div class="row justify-content-center">
		<div class="col-md-12 espacamento-bloco">
			<div class="card">
	            <div class="card-header">Perfil</div>
                <div class="card-body">
            		<h2 class="text-center">{{$usuario->nome}}</h2>
            		<p><strong>Anúncios publicados: </strong></p>
            		<hr>
            		<p><strong>Doações efetuadas: </strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
		<div class="col-md-12 espacamento-bloco">
			<div class="card">
	            <div class="card-header">Anúncios</div>
                <div class="card-body">
        		@foreach($anuncios as $anuncio)
                    <div class="anuncio">
                        <h5 class="card-title">{{$anuncio->titulo}}</h5>
                        <img src={{asset("/storage/app/anuncio_".$anuncio->id."/DonateImage_0.png") }}/><br>
                        <span class="fa fa-map-marker-alt"></span>
                        <span>{{$anuncio->bairro->nome}}, 
                        {{$anuncio->bairro->cidade->nome}}</span><br>
                        <span class="fa fa-clock"></span>
                        <span>{{$anuncio->created_at}}</span><br>
                        <a href="{{url('doacoes/anuncio/'.$anuncio->id)}}" class="btn btn-danger">Ver mais</a>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
		<div class="col-md-12 espacamento-bloco">
			<div class="card">
	            <div class="card-header">Avaliações</div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('owlcarousel/owl.carousel.min.js')}}"></script>
@endsection
@section('js')

@endsection