$(window).scroll(function(){
    if ($(window).scrollTop() >= 10) {
       $('.navbar-static-top').css('box-shadow','0px 2px 2px rgba(0,0,0,0.5)');
    }
    else {
       $('.navbar-static-top').css('box-shadow','none');
    }
});
$(function() {
    $('#side-menu').metisMenu();
    $(".alert").alert();
    $('#page-wrapper, .sub_menu').click(function(){
        $('.nav-min .mainMenu').removeClass('active'),$('.nav-min .nav-second-level').removeClass('in');
    });
    /*var w = $(document).width();
    w < 992 ? $('#wrapper').addClass("nav-min") : void 0;*/
    var $window = $(window),
        $html = $('#wrapper');

    $window.resize(function resize() {
        if ($window.width() < 992) {
            return $html.addClass('nav-min');
        }

        $html.removeClass('nav-min');
    }).trigger('resize');
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        console.log($(this).width())
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
});

function navMin(){
    var navside = $('#wrapper');
    navside.hasClass("nav-min") ? navside.removeClass("nav-min") : navside.addClass("nav-min");
    }
