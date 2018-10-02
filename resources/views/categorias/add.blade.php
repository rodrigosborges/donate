@extends('crudgenerator::layouts.master')

@section('content')


<h2 class="page-header">Categoria</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify Categoria    </div>

    <div class="panel-body">
                
        <form action="{{ url('/categorias'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
                <input type="hidden" name="_method" value="PATCH">
            @endif

            <div class="form-group" style="display:none">
                <label for="id" class="col-sm-3 control-label">Id</label>
                <div class="col-sm-6">
                    <input type="hidden" name="id" id="id" class="form-control" value="{{@$model['id']}}">
                </div>
            </div>
            <div class="form-group">
                <label for="nome" class="col-sm-3 control-label">Nome</label>
                <div class="col-sm-6">
                    <input type="text" name="nome" id="nome" class="form-control" value="{{@$model['nome']}}">
                </div>
            </div>
            <div class="form-group">
                <label for="icon" class="col-sm-3 control-label">Icon</label>
                <div class="col-sm-6">
                    <input type="text" name="icon" id="icon" class="form-control" value="{{@$model['icon']}}">
                </div>
            </div>
                                                            
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Save
                    </button> 
                    <a class="btn btn-default" href="{{ url('/categorias') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>
        </form>

    </div>
</div>






@endsection