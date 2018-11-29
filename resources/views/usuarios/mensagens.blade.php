@extends('layouts.app')
@section('style')
@endsection
@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
	<div class="row justify-content-center">
		<div class="col-md-3 espacamento-bloco">
			<div class="card">
	            <div id="conversas" class="card-header">Conversas</div>
                <div class="card-body">
                    <div id="lista-usuarios">
                    @foreach($usuarios as $usuario)
                        <p class="usuario-conversa" id="{{$usuario->outra_pessoa}}"><strong>{{$usuario->nome}}</strong></span>
                        <hr>
                    @endforeach
                    </div>
                </div>    
            </div>
        </div>
        <div class="col-md-9 espacamento-bloco">
            <div class="card">
                <div id="card-header-mensagens" class="card-header">Mensagens</div>
                <div class="card-body">
                    <div id="mensagens">
                        
                    </div>
                </div>    
            </div>
            <br>
            <form method="POST" action="{{url('/usuarios/mensagens/enviar')}}">
                @csrf
                <div class="form-group">
                    <input id="destinatario-selecionado" type="hidden" name="destinatario_id">
                    <input class="form-control form-lg" type="text" name="texto" placeholder="Escreva aqui a sua mensagem..." required>
                </div>
                    <input class="btn btn-danger class="form-control" type="submit" value="Enviar">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
<script>
$(document).ready(function(){

    $(".usuario-conversa").click(function(){
        var nomeDestinatario = $(this).text();
        var id = this.id;
        $("#destinatario-selecionado").val(id);
        
        var request = $.ajax({
          method: "GET",
          url: '/usuarios/mensagens/buscarMensagens',
          data: {destinatario_id : id},
          dataType: "json"
          });

        request.done(function(data) {
            console.log(data)
            $("#mensagens").html("");
            $("#card-header-mensagens").html("Mensagens para: "+nomeDestinatario)
            $.each(data, function(i, dado){
                var alinhamento = "";
                if(dado['remetente_id'] == <?php echo Auth::id() ?>){
                    alinhamento = "margin-left:62%";
                }else{
                    alinhamento = "";
                }
                $("#mensagens").append("<div class='msg-box' style='"+alinhamento+"'><p><strong>"+dado['remetente']+"</strong></p><p>"+dado['texto']+"</p><p style='font-size:0.8em'>"+dado['created_at']+"</p></div><br>");
                $('#mensagens').scrollTop($('#mensagens')[0].scrollHeight);
            });
        });

    });

});
</script>
@endsection