@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset('owl-carousel/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('owl-carousel/owl.theme.default.min.css')}}">
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
                    <p><strong>Cadastro: </strong>{{$usuario->data_criacao_formatada}}</p>
                    <hr>
            		<p><strong>Anúncios publicados: </strong>{{(count($anuncios))}}</p>
            		<hr>
            		<p><strong>Doações efetuadas: </strong>{{(count($anuncios->where('doado', 1)))}}</p>
                    <hr>
                    <p><strong>Avaliação: </strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
		<div class="col-md-12 espacamento-bloco">
			<div class="card">
	            <div class="card-header">Anúncios deste usuário</div>
                <div class="card-body owl-carousel owl-theme">
        		@foreach($anuncios as $anuncio)
                    <div class="anuncio-slider">
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
@endsection
@section('js')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('owl-carousel/owl.carousel.min.js')}}"></script>
    <script type="text/javascript">
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:20,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    })
    </script>
@endsection