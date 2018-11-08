$(document).ready(function(){
	$(".anuncio").each(function(){
		if($(this).find(".situacao").text() != 1){
			$(this).addClass('bloqueado');
		}
	})
})