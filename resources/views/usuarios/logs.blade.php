@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset('owl-carousel/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('owl-carousel/owl.theme.default.min.css')}}">
@endsection
@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
	<div class="row justify-content-center">
		<div class="col-md-12 espacamento-bloco">
            <div class="py-4">
                <h2 class="">Logs</h2>
                <hr class="divisor">
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mensagem</th>
                        <th>Usuario</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{$log->id}}</td>
                        <td>{{$log->mensagem}}</td>
                        <td><a href="{{url('/usuarios/perfil/'.$log->usuario->id)}}">{{$log->usuario->nome}}</a></td>
                        <td>{{$log->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 link-paginacao">
            @if(count($logs) != 0)
                {{$logs->appends(request()->except('page'))->links()}}
            @endif
        </div>
    </div>

@endsection