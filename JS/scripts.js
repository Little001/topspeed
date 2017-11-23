$( document ).ready(function() {
    $("#home-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".content-home").offset().top
        }, 1000);
    });
    $("#service-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".content-services").offset().top
        }, 1000);
    });
    $("#mustang-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".content-mustang").offset().top
        }, 1000);
    });
    $("#order-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".content-mustang").offset().top
        }, 1000);
    });

    //slider
    checkitem();
    $('#service-Carousel').on('slid', '', checkitem);  // on caroussel move
    $('#service-Carousel').on('slid.bs.carousel', '', checkitem); // on carousel move
    
    function checkitem()
    {
        debugger;
        var $this = $('#service-Carousel');
        if($this.find('.carousel-inner .item:first').hasClass('active')) {
            $this.children('.slide-button.left').hide();
            $this.children('.slide-button.right').show();
            return;
        }
        if($this.find('.carousel-inner .item:last').hasClass('active')) {
            $this.children('.slide-button.left').show();
            $this.children('.slide-button.right').hide();
            return;
        }
        $this.children('.slide-button.left').show();
        $this.children('.slide-button.right').show();
    }
});


