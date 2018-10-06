var data = new Date();
$("#ano").html(data.getYear() + 1900);

//menu lateral
function openNav() {
    $("#mySidenav").css({'width':'30%', 'padding':'1.5 3%'});
    $("#wrapper").css('margin-right','30%');
    $("#mainNav").css('padding-right', '30%');

}

function closeNav() {
    //$(".closebtn").hide();
    $("#mySidenav").css({'width':'0', 'padding':'0'});
    $("#wrapper").css('margin-right','0');
    $("#mainNav").css('padding-right', '0');
}

//quando um link da sidenav é clicado
$("#mySidenav a").click(function(){
    closeNav();
})

//quando a janela tem tamanho maior que 950px
$(window).on('resize', function(){
    //fecha o menu lateral
      var win = $(this);
      if(win.width() > 950){
         closeNav();
      }
});

// $(window).scroll(function() {

//     //Realiza as operações abaixo quando a rolagem passa do slider
//     if($(this).scrollTop() > 200){

//        $('#subirTopo').fadeIn("fast");

//     }else{

//        $('#subirTopo').fadeOut("fast");

//     }
// });

// // Basice Code keep it 
//     $(document).ready(function () {
//     //     $(document).on("scroll", onScroll);

//        // smoothscroll
//         $('nav ul li a[href^="#"], #subirTopo, #logo-link').on('click', function (e) {
//             e.preventDefault();
//             $(document).off("scroll");

//             $('nav a').each(function () {
//                 $(this).removeClass('active-custom');
//             })
//             if(this.hash != "#page-top"){
//                 $(this).addClass('active-custom');
//             }

//             var target = this.hash,
//             menu = target;
//             $target = $(target);
//             $('html, body').stop().animate({
//                 'scrollTop': $target.offset().top
//             }, 500, 'swing', function () {
//                 window.location.hash = target;
//                 //$(document).on("scroll", onScroll);
//             });
//         });
//     });

// Use Your Class or ID For Selection 

    // function onScroll(event){
    //     var scrollPos = $(document).scrollTop();
    //     $('.nav-link').each(function () {
    //         var currLink = $(this);
    //         var refElement = $(currLink.attr("href"));
    //         if (refElement.position().top-100 <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
    //             $('.nav-link').removeClass("active-custom");

    //             if(refElement[0].id != "page-top"){
    //                 currLink.addClass("active-custom");
    //             }
    //         }
    //         else{
    //             currLink.removeClass("active-custom");
    //         }
    //     });
    // }


$(document).ready(function(){

	//Fecha o menu quando um link é clicado no responsivo
	 $('.js-scroll-trigger').click(function() {
	    $('.navbar-collapse').collapse('hide');
	  });


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