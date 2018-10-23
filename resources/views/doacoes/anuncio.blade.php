@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card anuncio-detalhado">
                <div class="card-header">Imagens</div>
                <div class="card-body text-center">
                    <img src={{asset("/storage/app/anuncio_".$anuncio->id."/DonateImage_0.png") }}/>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card anuncio-detalhado">
                <div class="card-header">Anúncio</div>
                <div class="card-body">
                    <div class="informacoes">
                        <h1>{{$anuncio->titulo}}</h1>
                        <hr>
                        <p><strong>Categoria: </strong>{{$anuncio->categoria->nome}}</p>
                        <p><strong>Doador: </strong>{{$anuncio->usuario->nome}}</p>
                        <p><span class="fa fa-map-marker-alt"></span> {{$anuncio->bairro->cidade->nome}}, {{$anuncio->bairro->nome}}</p>
                        <?php
                        if($anuncio->doado == 0){
                            echo "<p><strong>Status: </strong><span style='color:green'>Disponível</span></p>";
                        }else{
                            echo "<p><strong>Status: </strong><span style='color:red'>Indisponível</span></p>";
                        }
                        ?>
                        </p>
                        <hr>
                        <div class="col-md-12 text-center">
                        @auth
                            @if($anuncio->usuario_id != Auth::user()->id)
                                <a class="btn btn-primary" href="#">Enviar mensagem ao doador</a>
                            @else
                                <a class="btn btn-primary" href="{{url('doacoes/editar/'.$anuncio->id)}}">Editar</a>
                            @endif
                        @else
                            <p>Faça <a href="{{url('/login')}}">login</a> para entrar em contato com o doador.</p>
                            <p>Ainda não tem uma conta? <a href="{{url('/register')}}">Cadastre-se</a></p>
                        @endauth
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card espacamento">
                <div class="card-header">Descrição</div>
                <div class="card-body text-left">
                    <p>{{$anuncio->descricao}}</p>
                </div>
            </div>
            <div class="card espacamento">
                <div class="card-header">Avaliações</div>
                <div class="card-body text-left">
                    
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/anuncios/anuncios.js')}}"></script>
@endsection
