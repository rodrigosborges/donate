@extends('layouts.app')
@section('style')

@endsection

@section('content')

<div class="container">
     @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" >Categorias</div>
                <div class="card-body categorias">
                    <div class="categoria">
                        <h6>Animal</h6>
                        <span class="fa fa-paw"></span>
                    </div>
                    <div class="categoria">
                        <h6>Doméstico</h6>
                        <span class="fa fa-home"></span>
                    </div>
                    <div class="categoria">
                        <h6>Educação</h6>
                        <span class="fa fa-graduation-cap"></span>
                    </div>
                    <div class="categoria">
                        <h6>Eletrônico</h6>
                        <span class="fa fa-mobile-alt"></span>
                    </div>
                    <div class="categoria">
                        <h6>Esporte e Lazer</h6>
                        <span class="fa fa-bicycle"></span>
                    </div>
                    <div class="categoria">
                        <h6>Infantil</h6>
                        <span class="fa fa-child"></span>
                    </div>
                    <div class="categoria">
                        <h6>Música</h6>
                        <span class="fa fa-music"></span>
                    </div>
                    <div class="categoria">
                        <h6>Vestuário</h6>
                        <span class="fa fa-tshirt"></span>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Últimos Anúncios</div>
                <div class="card-body">
                    @foreach($anuncios as $anuncio)
                        <div class="anuncio">
                            <h6><strong>{{$anuncio->titulo}}</strong></h6>
                            <img src={{asset("/storage/app/anuncio_".$anuncio->id."/DonateImage_0.png") }}/><br>
                            <span class="fa fa-map-marker-alt"></span>
                            <span>{{$anuncio->bairro->nome}}, 
                            {{$anuncio->bairro->cidade->nome}}</span><br>
                            <span class="fa fa-clock"></span>
                            <span>{{$anuncio->created_at}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('js')

@endsection
