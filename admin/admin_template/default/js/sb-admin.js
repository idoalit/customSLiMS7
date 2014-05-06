$(function() {
    $('#side-menu').metisMenu();
    $(".alert").alert();
    $('#page-wrapper, .sub_menu').click(function(){
        $('.nav-min .mainMenu').removeClass('active'),$('.nav-min .nav-second-level').removeClass('in');
    });
    var width = $window.width();
    992 > width ? $('#wrapper').addClass("nav-min") : void 0
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
