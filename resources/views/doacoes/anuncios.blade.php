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
	            <div class="card-header">Anúncios</div>
	                <div class="card-body">
	                	@foreach($anuncios as $key => $anuncio)
	                		<div class="anuncio-grande">
	                			<div class="row">
	                				<div class="col-sm-4">
                            			<img src={{asset("/storage/app/anuncio_".$anuncio->id."/DonateImage_0.png") }}/>
                            		</div>
                            		<div class="col-sm-8">
			                            <h2>{{$anuncio->titulo}}</h2>
			                            <div class="descricao">
			                            	<p class="descricao text-justify">{{$anuncio->descricao}}</p>
			                            </div>
			                            <div class="dados">
				                            <span><i class="fa fa-map-marker-alt"></i></span> {{$anuncio->bairro->nome}}, 
				                            {{$anuncio->bairro->cidade->nome}}</span><br>
				                            <span><i class="fa fa-clock"></i> {{$anuncio->created_at}}</span>
				                        </div>
		                            	<a href="{{url('doacoes/anuncio/'.$anuncio->id)}}" class="btn btn-danger">Ver mais</a>
	                            	</div>
	                            </div>
	                        </div>
	                        @if($key != count($anuncios) - 1)
	                        <hr class="espacamento-linha">
	                        @endif
	                	@endforeach
	                </div>
	            </div>
	        </div>
	    </div>
    </div>

@endsection