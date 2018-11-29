@extends('layouts.app')
@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<div class="row justify-content-center mb-4">
    <div class="col-md-12">
        <div class="py-4">
            <h2>{{isset($anuncio) ? 'Editar Anúncio' : 'Novo Anúncio'}}</h2>
            <hr class="divisor">
        </div>
            <form method="POST" action="{{isset($anuncio) ? url('/doacoes/update/') : url('/doacoes/insert')}}" enctype="multipart/form-data">
                @csrf

            <input type="text" name="id" value="{{isset($anuncio) ? $anuncio->id : '' }}" hidden>

            <input id="cont_imagens" type="text" name="cont_imagens" hidden>

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
                    <select id="categoria" rows="8" class="form-control{{ $errors->has('categoria_id') ? ' is-invalid' : '' }}" name="categoria_id" value="{{ old('categoria_id') }}" required>
                        <option hidden >Selecione</option>
                        @foreach($categorias as $categoria)
                            <option {{(isset($anuncio) && $anuncio->categoria->id == $categoria->id) ? 'selected' : (old('categoria_id') !== null && old('categoria_id') == $categoria->id ? 'selected' : '')}} value="{{$categoria->id}}">{{$categoria->nome}}</option>
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
                <label for="bairro" class="col-md-4 col-form-label text-md-right">{{ __('Cidade') }}</label>

                <div class="col-md-6">
                    <select id="cidade" rows="8" class="form-control{{ $errors->has('cidade_id') ? ' is-invalid' : '' }}" name="cidade_id" value="{{ old('cidade_id') }}" required>
                        <option hidden >Selecione</option>
                        @foreach($cidades as $cidade)
                            <option {{(isset($anuncio) && $anuncio->bairro->cidade->id == $cidade->id) ? 'selected' : (old('cidade_id') !== null && old('cidade_id') == $cidade->id ? 'selected' : '')}} value="{{$cidade->id}}">{{$cidade->nome}}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('cidade'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('cidade') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="bairro" class="col-md-4 col-form-label text-md-right">{{ __('Bairro') }}</label>

                <div class="col-md-6">
                    <select id="bairro" rows="8" class="form-control{{ $errors->has('bairro_id') ? ' is-invalid' : '' }}" name="bairro_id" value="{{ old('bairro_id') }}" required>
                        <option hidden >Selecione</option>
                        @if(isset($anuncio))
                            @foreach($bairros as $bairro)
                                <option {{$bairro->id == $anuncio->bairro->id ? 'selected' : (old('bairro_id') !== null && old('bairro_id') == $bairro->id ? 'selected' : '')}} value="{{$bairro->id}}">{{$bairro->nome}}</option>
                            @endforeach
                        @endif
                    </select>

                    @if ($errors->has('bairro'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bairro') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @if(isset($anuncio))
            <div class="form-group row text-center">
                <div class="col-md-6 offset-md-4">
                @foreach($anuncio->getImagens() as $key => $imagem)
                    <div class="imagem-edicao">
                        <i name="{{explode('donate/', $imagem)[1]}}" class="btn-del-image fas fa-times-circle"></i>
                        <img src={{asset(explode('donate/', $imagem)[1])}}/>
                    </div>
                @endforeach
                </div>
            </div>

            <div id="imagens-deletadas"></div>
            @endif

            <div class="form-group row">
                <label for="imagem" class="col-md-4 col-form-label text-md-right">{{ __('Imagem') }}</label>

                <div class="col-md-6">
                    <input id="imagem" type="file" class="form-control{{ $errors->has('imagem') ? ' is-invalid' : '' }}" name="imagem[]" multiple>

                    @if ($errors->has('imagem'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('imagem') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <output id="result" class="form-inline"/>
                </div>
            </div>


            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-danger">
                        {{isset($anuncio) ? __('Atualizar') : __('Registrar')}}
                    </button>
                    @if(isset($anuncio))
                        <a class="ml-4" data-toggle="modal" data-target="#excluirAnuncio" href="#excluirAnuncio">Excluir Anúncio</a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="excluirAnuncio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Anúncio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Tem certeza de que deseja excluir este anúncio?</p>
                <p>OBS: Não é possível desfazer esta ação.</p>
              </div>
              <div class="modal-footer">
                <form method="POST" action="{{url('doacoes/delete')}}">
                    @csrf
                    <input hidden type="text" value="{{isset($anuncio) ? $anuncio->id : ''}}" name="anuncio_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
              </div>
            </div>
          </div>
        </div>

    </div>
</div>
@endsection

@section('js')

@if(old('bairro_id') !== null)
    <script type="text/javascript">
        var cidade = $("#cidade").val();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        var request = $.ajax({
          url: "{{url('doacoes/buscarBairros')}}",
          method: "POST",
          data: {cidade_id : cidade},
          dataType: "json"
        });

        request.done(function(msg) {
          $("#bairro").html("");
          $.each(msg, function(i, bairro){
            $("#bairro").append("<option value='"+bairro['id']+"'>"+bairro['nome']+"</option>");
            if(bairro['id'] == <?php echo old('bairro_id'); ?>){
                $("#bairro option").last().attr('selected', 'true');    
            }
          })  
        });
    </script>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-del-image").on( "click", function() {
        $("#imagens-deletadas").append("<input hidden name='imagens_deletadas[]' value="+$(this).attr("name")+">")
        $(this).parent().remove();
        });

    });


    $("#cidade").change(function(){

        var cidade = $(this).val();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        var request = $.ajax({
          url: "{{url('doacoes/buscarBairros')}}",
          method: "POST",
          data: {cidade_id : cidade},
          dataType: "json"
        });

        request.done(function(msg) {
          $("#bairro").html("");
          $.each(msg, function(i, bairro){
            $("#bairro").append("<option value='"+bairro['id']+"'>"+bairro['nome']+"</option>");
          })  
        });

    })

window.onload = function(){
    //Check File API support
    if(window.File && window.FileList && window.FileReader){
        var filesInput = document.getElementById("imagem");
        filesInput.addEventListener("change", function(event){
            var files = event.target.files; //FileList object
            arquivos = files;
            var output = document.getElementById("result");
            $("#result").empty()
            $("#result").show()
            for(var i = 0; i< files.length; i++){
                var file = files[i];
                //Only pics
                if(!file.type.match('image'))
                    continue;
                var picReader = new FileReader();
                picReader.addEventListener("load",function(event){
                    var picFile = event.target;
                    var div = document.createElement("div");
                    div.innerHTML = "<img style='padding:4% 4%' class='thumbnail' height=120px width=120px src='" + picFile.result + "'" +
                    "title='" + picFile.name + "'/>";
                    output.insertBefore(div,null);
                });
                //Read the image
                picReader.readAsDataURL(file);
            }

        });
    }else
        console.log("Seu navegador não possui suporte ao File API");
    
}

</script>
@stop
