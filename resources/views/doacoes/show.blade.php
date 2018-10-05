@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Doacao</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Doacao    </div>

    <div class="panel-body">
                

        <form action="{{ url('/doacoes') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div class="col-sm-6">
                <input type="text" name="id" id="id" class="form-control" value="{{@$model['id']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="titulo" class="col-sm-3 control-label">Titulo</label>
            <div class="col-sm-6">
                <input type="text" name="titulo" id="titulo" class="form-control" value="{{@$model['titulo']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="usuario_id" class="col-sm-3 control-label">Usuario Id</label>
            <div class="col-sm-6">
                <input type="text" name="usuario_id" id="usuario_id" class="form-control" value="{{@$model['usuario_id']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="descricao" class="col-sm-3 control-label">Descricao</label>
            <div class="col-sm-6">
                <input type="text" name="descricao" id="descricao" class="form-control" value="{{@$model['descricao']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="bairro_id" class="col-sm-3 control-label">Bairro Id</label>
            <div class="col-sm-6">
                <input type="text" name="bairro_id" id="bairro_id" class="form-control" value="{{@$model['bairro_id']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="categoria_id" class="col-sm-3 control-label">Categoria Id</label>
            <div class="col-sm-6">
                <input type="text" name="categoria_id" id="categoria_id" class="form-control" value="{{@$model['categoria_id']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="aprovado" class="col-sm-3 control-label">Aprovado</label>
            <div class="col-sm-6">
                <input type="text" name="aprovado" id="aprovado" class="form-control" value="{{@$model['aprovado']}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="doado" class="col-sm-3 control-label">Doado</label>
            <div class="col-sm-6">
                <input type="text" name="doado" id="doado" class="form-control" value="{{@$model['doado']}}" readonly="readonly">
            </div>
        </div>       
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/doacoes') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>
        </form>
    </div>
</div>







@endsection