@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Anúncio</div>

                <div class="card-body">
                    <form method="POST" action="{{isset($anuncio) ? url('/doacoes/update/') : url('/doacoes/insert')}}" enctype="multipart/form-data">
                        @csrf

                        <input type="text" name="usuario_id" value="{{isset($anuncio) ? $anuncio->id : '' }}" hidden>

                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>
                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}" name="titulo" value="{{isset($anuncio) ? $anuncio->titulo : old('titulo') }}" required autofocus >

                                @if ($errors->has('titulo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('titulo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descricao" class="col-md-4 col-form-label text-md-right">{{ __('Descrição') }}</label>

                            <div class="col-md-6">
                                <textarea id="descricao" rows="8" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}" name="descricao" required>{{isset($anuncio) ? $anuncio->descricao : old('descricao') }}
                                </textarea> 

                                @if ($errors->has('descricao'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>

                            <div class="col-md-6">
                                <select id="categoria" rows="8" class="form-control{{ $errors->has('categoria') ? ' is-invalid' : '' }}" name="categoria_id" value="{{ old('categoria') }}" required>
                                    @foreach($categorias as $categoria)
                                        <option {{(isset($anuncio) && $anuncio->categoria->id == $categoria->id) ? 'selected' : ''}} value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('categoria'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('categoria') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bairro" class="col-md-4 col-form-label text-md-right">{{ __('Bairro') }}</label>

                            <div class="col-md-6">
                                <select id="bairro" rows="8" class="form-control{{ $errors->has('bairro') ? ' is-invalid' : '' }}" name="bairro_id" value="{{ old('bairro') }}" required>
                                    @foreach($bairros as $bairro)
                                        <option {{(isset($anuncio) && $anuncio->bairro->id == $bairro->id) ? 'selected' : ''}} value="{{$bairro->id}}">{{$bairro->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('bairro'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bairro') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imagem" class="col-md-4 col-form-label text-md-right">{{ __('Imagem') }}</label>

                            <div class="col-md-6">
                                <input id="imagem" type="file" class="form-control{{ $errors->has('imagem') ? ' is-invalid' : '' }}" name="imagem[]" required multiple>

                                @if ($errors->has('imagem'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('imagem') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
