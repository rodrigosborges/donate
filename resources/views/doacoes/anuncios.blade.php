@extends('layouts.app')
@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
    <div class="row justify-content-center">
    	<div class="col-md-12">
            <div class="px-4 py-4">
                <form id="filtro_cidade" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" method="GET" action="{{url('doacoes/pesquisa/')}}">
                    <div class="input-group">
                        <input hidden type="text" name="termos" value="{{isset($termos) ? $termos : ''}}">
                        <label class="mr-sm-2" for="cidade_id">Filtrar por cidade:</label>
                        <select id="cidade" name="cidade_id" class="form-control">
                            <option selected value="todas">Todas</option>
                            @foreach($cidades as $cidade)
                                <option {{(isset($cidade_id) && $cidade_id == $cidade->id) ? 'selected' : ''}} value="{{$cidade->id}}">{{$cidade->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <hr>
                <h2 class="">{{isset($termos) ? 'Resultados da pesquisa por: '.$termos : "Anúncios"}} {{isset($nomeCategoria) ? ' | Categoria: '.$nomeCategoria : ''}}</h2>
                <hr class="divisor">
            </div>
        	@if(count($anuncios) == 0)
        		<div class="col-md-12 text-center">
        			@if(isset($termos) || isset($cidade_id))
        				<span style="font-size: 1.7em">Sua pesquisa não retornou resultados.<br><i class="far fa-frown"></i></span>
        			@elseif(isset($nomeCategoria))
        				<span style="font-size:1.7em">Nenhum anúncio cadastrado na categoria <i><span style="color:red">{{$nomeCategoria}}</span></i>.<br><i class="far fa-frown"></i></span>
        			@endif
        		</div>
        	@endif
        	@foreach($anuncios as $key => $anuncio)
        		<div class="anuncio-grande px-4">
        			<div class="row">
        				<div class="col-sm-4">
                			<img src={{asset("/storage/app/anuncio_".$anuncio->id."/DonateImage_0.png") }}/>
                		</div>
                		<div class="col-sm-8 mt-4">
                            <h2>{{$anuncio->titulo}}</h2>
                            <div class="descricao">
                            	<p class="descricao text-justify">{{$anuncio->descricao}}</p>
                            </div>
                            <div class="dados">
	                            <span><i class="fa fa-map-marker-alt"></i></span> {{$anuncio->bairro->nome}}, 
	                            {{$anuncio->bairro->cidade->nome}}</span><br>
	                            <span><i class="fa fa-clock"></i> {{$anuncio->created_at}}</span>
	                        </div>
                            <br>
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
	    <div class="row">
	        <div class="col-md-12 link-paginacao">
	        	@if(count($anuncios) != 0)
	        		{{$anuncios->appends(request()->except('page'))->links()}}
	        	@endif
	    	</div>
		</div>
	</div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('change', '#cidade', function(){
                $("#filtro_cidade").submit();
            });
        })
    </script>
@endsection