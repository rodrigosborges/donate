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
                <div class="card-header">Anúncio</div>
                <div class="card-body">
                    <img src={{asset("/storage/app/anuncio_".$anuncio->id."/DonateImage_0.png") }}/><br>
                       
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/anuncios/anuncios.js')}}"></script>
@endsection
