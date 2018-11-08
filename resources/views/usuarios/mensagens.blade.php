@extends('layouts.app')
@section('style')
@endsection
@section('content')
<div class="container">
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
	<div class="row justify-content-center">
		<div class="col-md-3 espacamento-bloco">
			<div class="card">
	            <div class="card-header">Conversas</div>
                <div class="card-body">
            		
                </div>    
            </div>
        </div>
        <div class="col-md-9 espacamento-bloco">
            <div class="card">
                <div class="card-header">Conversas</div>
                <div class="card-body">
                    
                </div>    
            </div>
        </div>
    </div>

</div>
@endsection