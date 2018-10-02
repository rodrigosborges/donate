@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Categoria</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Categoria    </div>

    <div class="panel-body">
                

        <form action="{{ url('/categorias') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div class="col-sm-6">
                <input type="text" name="id" id="id" class="form-control" value="{{@$model['id']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="nome" class="col-sm-3 control-label">Nome</label>
            <div class="col-sm-6">
                <input type="text" name="nome" id="nome" class="form-control" value="{{@$model['nome']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="icon" class="col-sm-3 control-label">Icon</label>
            <div class="col-sm-6">
                <input type="text" name="icon" id="icon" class="form-control" value="{{@$model['icon']}}" readonly="readonly">
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/categorias') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection