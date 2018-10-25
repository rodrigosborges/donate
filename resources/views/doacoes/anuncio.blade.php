@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card anuncio-detalhado">
                <div class="card-header">Imagens</div>
                <div class="card-body text-center">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                      <ol class="carousel-indicators">
                        @foreach($anuncio->getImagens() as $key => $imagem)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="active"></li>
                        @endforeach
                      </ol>
                      <div class="carousel-inner">
                        @foreach($anuncio->getImagens() as $key => $imagem)
                        <div class="carousel-item {{($key == 0 ? 'active' : '')}}">
                            <img class="d-block w-100" src={{asset(explode('donate/', $imagem)[1])}}/>
                        </div>
                        @endforeach
                      </div>
                      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
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
                        if($anuncio->aprovado == 0){
                            echo "<p><strong>Status: </strong><span style='color:red'>Em análise para aprovação</span></p>";
                        }
                        else if($anuncio->doado == 0){
                            echo "<p><strong>Status: </strong><span style='color:green'>Disponível</span></p>";
                        }else{
                            echo "<p><strong>Status: </strong><span style='color:red'>Este ítem já foi doado</span></p>";
                        }
                        ?>
                        </p>
                        <hr>
                        <div class="col-md-12 text-center">
                        @auth
                            @if($anuncio->usuario_id != Auth::user()->id)
                                <a class="btn btn-primary" href="#">Enviar mensagem ao doador</a>
                            @else
                                @if($anuncio->aprovado == 1)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form method="POST" action="{{url('doacoes/mudarStatus')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$anuncio->id}}">
                                                <input type="hidden" name="tipo" value="doado">
                                                <input type="hidden" name="valor" value="{{($anuncio->doado == 0) ? 1 : 0}}">
                                                <input class="btn btn-danger" type="submit" value="{{($anuncio->doado == 0) ? 'Marcar como doado' : 'Marcar como disponível'}}"/>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-primary" href="{{url('doacoes/editar/'.$anuncio->id)}}">Editar</a>
                                        </div>
                                    </div>
                                @endif
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
