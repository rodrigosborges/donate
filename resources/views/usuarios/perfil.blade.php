@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset('owl-carousel/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('owl-carousel/owl.theme.default.min.css')}}">
@endsection
@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
	<div class="row justify-content-center">
		<div class="col-md-12 espacamento-bloco">
            <div class="py-4">
                <h2 class="">Dados Básicos</h2>
                <hr class="divisor">
            </div>
            <p class="ml-4"><strong>Nome: </strong>{{$usuario->nome}}</p>
            <hr>
            <p class="ml-4"><strong>E-mail: </strong>{{$usuario->email}}</p>
            <hr>
            <p class="ml-4"><strong>Cadastro: </strong>{{$usuario->data_criacao_formatada}}</p>
            <hr>
            <p class="ml-4"><strong>Avaliação: </strong>{{$avaliacaoMedia}}</p>
            <hr>
    		<p class="ml-4"><strong>Anúncios publicados: </strong>{{(count($anuncios))}}</p>
    		<hr>
    		<p class="ml-4"><strong>Anúncios ativos: </strong>{{(count($anuncios->where('doado', 0)))}}</p>
            <hr>

        </div>
            <div class="col-md-12 espacamento-bloco">
                <a class="ml-4 btn btn-danger" href="{{url('usuarios/editar/'.$usuario->id)}}">Editar informações</a>
                <a class="ml-4 btn btn-danger" href="{{url('usuarios/alterar-senha/'.$usuario->id)}}">Alterar senha</a>
            </div>
    </div>

    <div class="row justify-content-center">
		<div class="col-md-12 espacamento-bloco">
			<div class="py-4">
                <h2 class="">Anúncios deste usuário</h2>
                <hr class="divisor">
            </div>
            <div class="owl-carousel owl-theme">
    		@foreach($anuncios as $anuncio)
                <div class="anuncio-slider">
                    <h5 class="card-title titulo-inline">{{$anuncio->titulo}}</h5>
                    <img src={{asset("/storage/app/anuncio_".$anuncio->id."/DonateImage_0.png") }}/><br>
                    <span class="fa fa-map-marker-alt"></span>
                    <span>{{$anuncio->bairro->nome}}, 
                    {{$anuncio->bairro->cidade->nome}}</span><br>
                    <span class="fa fa-clock"></span>
                    <span>{{$anuncio->created_at}}</span><br><br>
                    <a href="{{url('doacoes/anuncio/'.$anuncio->id)}}" class="btn btn-danger">Ver mais</a>
                </div>
            @endforeach
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('owl-carousel/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
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

    $(document).ready(function(){

    });
    </script>
@endsection