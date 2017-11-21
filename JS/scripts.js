$( document ).ready(function() {
    $("#service-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".content-services").offset().top
        }, 1000);
    });
    
    $("#cars-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".content-cars").offset().top
        }, 1000);
    });
    
    $("#home-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".content-home").offset().top
        }, 1000);
    });
});


