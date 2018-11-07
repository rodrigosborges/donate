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
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="grafico-avaliacoes"></canvas>
                            </div>
                            <div class="col-md-6">
                            @auth
                                @if($avaliacaoExistente !== null)
                                    <div id="ja-avaliado">
                                        <p style="font-size:1.4em">Você avaliou este doador com {{$avaliacaoExistente->nivel}} estrelas!</p>
                                    </div>
                                @endif
                                <div id="avaliacao" style={{($avaliacaoExistente !== null) ? "display:none" : ""}}>
                                    <p>Avalie este doador!</p>
                                    <i id="star-1" class="far fa-star"></i>
                                    <i id="star-2" class="far fa-star"></i>
                                    <i id="star-3" class="far fa-star"></i>
                                    <i id="star-4" class="far fa-star"></i>
                                    <i id="star-5" class="far fa-star"></i>
                                </div>
                                <p id="p-mudar-avaliacao" style={{($avaliacaoExistente !== null) ? "" : "display:none"}}>Clique <span id="btn-mudar-avaliacao">aqui</span> para mudar a sua avaliação!</p>
                            @else
                                <p>Faça <a href="{{url('/login')}}">login</a> para avaliar o doador.</p>
                                <p>Ainda não tem uma conta? <a href="{{url('/register')}}">Cadastre-se</a></p>
                            @endauth
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        <?php if(Auth::user()){ ?>

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
                $("#avaliacao p").hide();
                $("#avaliacao .fa-star").hide();
                $("#p-mudar-avaliacao").show();
                $("#avaliacao").prepend('<p style="font-size:1.4em">Você avaliou este doador com '+data.nivel+' estrelas!');

            });

        });

        $(document).on('click', '#btn-mudar-avaliacao', function(){
            $("#ja-avaliado").hide();
            $("#p-mudar-avaliacao").hide();
            $("#avaliacao p").hide();
            $("#avaliacao").prepend("<p>Avalie este doador!</p>");
            $("#avaliacao").show();
            $("#avaliacao .fa-star").show();
        });

        <?php } ?>


        var ctx = document.getElementById('grafico-avaliacoes').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'horizontalBar',
            // The data for our dataset
            data: {
                labels: ["1 Estrela", "2 Estrelas", "3 Estrelas", "4 Estrelas", "5 Estrelas"],
                datasets: [{
                    label: "Avaliações",
                    backgroundColor: 'gold',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [
                    <?php echo $qtdAvaliacoes['1-star']; ?>,
                    <?php echo $qtdAvaliacoes['2-star']; ?>,
                    <?php echo $qtdAvaliacoes['3-star']; ?>,
                    <?php echo $qtdAvaliacoes['4-star']; ?>,
                    <?php echo $qtdAvaliacoes['5-star']; ?>
                    ],
                }]
            },

            

            // Configuration options go here
            options: {
                legend: {
                display: false
                },
                tooltips: {
                    callbacks: {
                       label: function(tooltipItem) {
                              return tooltipItem.yLabel;
                       }
                    }
                }
            }
        });

    });
</script>
@endsection
