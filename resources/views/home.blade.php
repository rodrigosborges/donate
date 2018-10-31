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

    @if (session('warning'))
        <div class="alert alert-warning" role="alert">
            {{ session('warning') }}
        </div>
    @endif

    <div class="row text-center">
        <div class="col-md-12">
            <div class="frases"><p style='font-size:3em'>Bem vindo ao Donate!</p></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12 espacamento-bloco">
            <form method="POST" action="{{url('doacoes/pesquisa/')}}">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><span class="fa fa-search"></span></div>
                        </div>
                       <input name="termos" class="form-control form-control-lg" type="text" placeholder="O que você está procurando?">
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn btn-danger" type="submit">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card espacamento-bloco">
                <div class="card-header" >Categorias</div>
                <div class="card-body categorias">
                    <a href="{{url('doacoes/anuncios/1')}}" class="categoria rounded">
                        <h6>Animal</h6>
                        <span class="fa fa-paw"></span>
                    </a>
                    <a href="{{url('doacoes/anuncios/2')}}" class="categoria rounded">
                        <h6>Doméstico</h6>
                        <span class="fa fa-home"></span>
                    </a>
                    <a href="{{url('doacoes/anuncios/3')}}" class="categoria rounded">
                        <h6>Educação</h6>
                        <span class="fa fa-graduation-cap"></span>
                    </a>
                    <a href="{{url('doacoes/anuncios/4')}}" class="categoria rounded">
                        <h6>Eletrônico</h6>
                        <span class="fa fa-mobile-alt"></span>
                    </a>
                    <a href="{{url('doacoes/anuncios/5')}}" class="categoria rounded">
                        <h6>Esporte e Lazer</h6>
                        <span class="fa fa-bicycle"></span>
                    </a>
                    <a href="{{url('doacoes/anuncios/6')}}" class="categoria rounded">
                        <h6>Infantil</h6>
                        <span class="fa fa-child"></span>
                    </a>
                    <a href="{{url('doacoes/anuncios/7')}}" class="categoria rounded">
                        <h6>Música</h6>
                        <span class="fa fa-music"></span>
                    </a>
                    <a href="{{url('doacoes/anuncios/8')}}" class="categoria rounded">
                        <h6>Vestuário</h6>
                        <span class="fa fa-tshirt"></span>
                    </a>
                </div>
            </div>
        </div>
    </div> 

    <div class="row justify-content-center">
        <div class="col-md-12 text-center espacamento-bloco">
            <a class="btn btn-lg btn-red" href="{{url('doacoes/anuncios/all')}}">Ver todos os anúncios</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Últimos Anúncios</div>
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
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        var frases = [
            'Texto 1',
            'Texto 2',
            'Texto 3',
            'Texto 4',
        ];

        var i = 0;
        setInterval(function(){
            $(".frases").fadeIn(2000).delay(5000);
            $(".frases").fadeOut(2000, function(){
                $(".frases").html("<p style='font-size:3em'>"+frases[i]+"</p>");
                i++;
                if(i == frases.length){
                    i = 0;
                }
            });
        }, 2000);

    })
 
</script>
@endsection
