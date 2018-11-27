@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('warning'))
        <div class="alert alert-success" role="alert">
            {{ session('warning') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="px-4 py-4">
                <h2 class="">Alterar Senha</h2>
                <hr class="divisor">
            </div>
            <form method="POST" action="{{url('/usuarios/updateSenha/')}}">
                @csrf

                <input hidden type="text" name="usuario_id" value="{{$usuario->id}}">

                <div class="form-group row">
                    <label for="senha-atual" class="col-md-4 col-form-label text-md-right">{{ __('Senha Atual') }}</label>

                    <div class="col-md-6">
                        <input id="senha_atual" type="password" class="form-control{{ $errors->has('senha_atual') ? ' is-invalid' : '' }}" name="senha_atual" required>

                        @if ($errors->has('senha_atual'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('senha_atual') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nova_senha" class="col-md-4 col-form-label text-md-right">{{ __('Nova Senha') }}</label>

                    <div class="col-md-6">
                        <input id="nova_senha" type="password" class="form-control{{ $errors->has('nova_senha') ? ' is-invalid' : '' }}" name="nova_senha" required>

                        @if ($errors->has('nova_senha'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nova_senha') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="confirmar_nova_senha" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Nova Senha') }}</label>

                    <div class="col-md-6">
                        <input id="confirmar_nova_senha" type="password" class="form-control" name="confirmar_nova_senha" required>
                    </div>
                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-danger">
                            Alterar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
