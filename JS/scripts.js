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

    //slider
    checkitem();
    $('#myCarousel').on('slid', '', checkitem);  // on caroussel move
    $('#myCarousel').on('slid.bs.carousel', '', checkitem); // on carousel move
    
    function checkitem()
    {
        var $this = $('#myCarousel');
        if($('.carousel-inner .item:first').hasClass('active')) {
            $this.children('.slide-button.left').hide();
            $this.children('.slide-button.right').show();
            return;
        }
        if($('.carousel-inner .item:last').hasClass('active')) {
            $this.children('.slide-button.left').show();
            $this.children('.slide-button.right').hide();
            return;
        }
        $this.children('.slide-button.left').show();
        $this.children('.slide-button.right').show();
    }
});


