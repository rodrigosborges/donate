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
                <div class="card-body">
                    <div class="col-md-12 text-center">
                        <div id="avaliacao">
                            @if($avaliacaoExistente !== null)
                                <p>Você avaliou este doador com {{$avaliacaoExistente->nivel}} estrelas!
                                <p>Clique <span style="color:blue; cursor:pointer" id="mudar-avaliacao">aqui</span> para mudar a sua avaliação.</p>
                            @endif
                            <p>Avalie este doador!</p>
                            <i id="star-1" class="far fa-star"></i>
                            <i id="star-2" class="far fa-star"></i>
                            <i id="star-3" class="far fa-star"></i>
                            <i id="star-4" class="far fa-star"></i>
                            <i id="star-5" class="far fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $(".fa-star").mouseenter(function(){
            var id = this.id;
            var posicao = id.split("-")[1]
            $(".fa-star:lt("+posicao+")").css({'color':'gold', 'transition':'0.2s', 'cursor':'pointer'})
        }).mouseleave(function(){
            $(".fa-star").css('color', 'black')
        }).click(function(){
            var id = this.id;
            var level = id.split("-")[1];
            
            var request = $.ajax({
              method: "GET",
              url: '/donate/avaliacoes/avaliar',
              data: { nivel: level, avaliador_id: <?php echo Auth::id(); ?>, avaliado_id: <?php echo $anuncio->usuario_id; ?>},
              dataType: "json"
              });

            request.done(function(data) {
                $("#avaliacao .fa-star").hide();
                $("#avaliacao p").hide();
                $("#avaliacao").append('<p>Você avaliou este doador com '+data.nivel+' estrelas!<p>Clique <span style="color:blue; cursor:pointer" id="mudar-avaliacao">aqui</span> para mudar a sua avaliação.</p>');
            });

        });

        $(document).on('click', '#mudar-avaliacao', function(){
            $("#avaliacao p").hide();
            $("#avaliacao").prepend("<p>Avalie este doador!</p>");
            $("#avaliacao .fa-star").show();
        });

    });
</script>
@endsection
