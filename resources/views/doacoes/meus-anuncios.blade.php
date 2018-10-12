@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Meus Anúncios</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($anuncios as $anuncio)
                        <div class="anuncio">
                            <h4>{{$anuncio->titulo}}</h4>
                            <img src="{{asset($anuncio->getImagens(13)[0])}}"/>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection
