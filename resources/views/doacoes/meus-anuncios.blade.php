@extends('layouts.app')

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
                <div class="card-header">Meus Anúncios</div>
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
                            <a href="#" class="btn btn-primary">Ver/Editar</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/anuncios/anuncios.js')}}"></script>
@endsection
