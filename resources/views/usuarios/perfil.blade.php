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
		<div class="col-md-6 espacamento-bloco">
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

        <div class="col-md-6 espacamento-bloco">
            <div class="card">
                <div class="card-header">Avaliações</div>
                <div class="card-body">
                     <canvas id="grafico-avaliacoes"></canvas>
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