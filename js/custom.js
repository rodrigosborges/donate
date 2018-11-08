var data = new Date();
$("#ano").html(data.getYear() + 1900);

//menu lateral
function openNav() {
    if($(window).width() > 800){
        $("#sidenav-content").fadeIn(1000);
        $("#mySidenav").css({'width':'30%', 'padding':'1.5 3%'});
        $("#wrapper").css('margin-right','30%');
        $("#mainNav").css('padding-right', '30%');
    }else{
        $("#sidenav-content").fadeIn(1000);
        $("#mySidenav").css({'width':'56%', 'padding':'1.5 3%'});
        $("#wrapper").css('margin-right','56%');
        $("#mainNav").css('padding-right', '56%');
    }

}

function closeNav() {
    if($(window).width() < 800){
        //$("#botao-menu-mobile").fadeIn("fast");
    }
    $("#sidenav-content").fadeOut(100);
    $("#mySidenav").css({'width':'0', 'padding':'0'});
    $("#wrapper").css('margin-right','0');
    $("#mainNav").css('padding-right', '0');
    //$("#wrapper").css('filter', 'brightness(100%)');
}

//quando a janela tem tamanho maior que 950px
$(window).on('resize', function(){
    //fecha o menu lateral
      var win = $(this);
      if(win.width() > 950){
         closeNav();
      }
});


$(document).ready(function(){

	 //galeria de imagens

    // delegate calls to data-toggle="lightbox"
    $(document).on('click', '[data-toggle="lightbox"]:not([data-gallery="navigateTo"]):not([data-gallery="example-gallery-11"])', function(event) {
        event.preventDefault();
        return $(this).ekkoLightbox();
    });

    // disable wrapping
    $(document).on('click', '[data-toggle="lightbox"][data-gallery="example-gallery-11"]', function(event) {
        event.preventDefault();
        return $(this).ekkoLightbox({
            wrapping: false
        });
    });

});