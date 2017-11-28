$( document ).ready(function() {
    (function($){
        $.fn.datepicker.dates['cs'] = {
            days: ["Neděle", "Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota"],
            daysShort: ["Ned", "Pon", "Úte", "Stř", "Čtv", "Pát", "Sob"],
            daysMin: ["Ne", "Po", "Út", "St", "Čt", "Pá", "So"],
            months: ["Leden", "Únor", "Březen", "Duben", "Květen", "Červen", "Červenec", "Srpen", "Září", "Říjen", "Listopad", "Prosinec"],
            monthsShort: ["Led", "Úno", "Bře", "Dub", "Kvě", "Čer", "Čnc", "Srp", "Zář", "Říj", "Lis", "Pro"],
            today: "Dnes",
            clear: "Vymazat",
            monthsTitle: "Měsíc",
            weekStart: 1,
            format: "dd.mm.yyyy"
        };
    }(jQuery));
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
            scrollTop: $(".content-order").offset().top
        }, 1000);
    });
    $("#reservation-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".background-reservation").offset().top
        }, 1000);
    });
    $("#contact-link").click(function() {
        $('html, body').animate({
            scrollTop: $(".background-contact").offset().top
        }, 1000);
    });

    //slider
    checkitem();
    $('#service-Carousel').on('slid', '', checkitem);  // on caroussel move
    $('#service-Carousel').on('slid.bs.carousel', '', checkitem); // on carousel move
    
    function checkitem()
    {
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


    $('#datepicker').datepicker({
        weekStart : 1,
        language: 'cs',
        todayHighlight: 1
    })
    fillCellContent();

    $("#datepicker .datepicker-switch").on('click', function (e) {
        e.stopPropagation();
    });

    $("#datepicker").datepicker().on('changeMonth', function(e){ 
        setTimeout(fillCellContent, 10);
    });
    $("#datepicker").datepicker().on('changeDate', function() {   
        setTimeout(fillCellContent, 10);
    });
    //arrows
    $('#datepicker table thead th.prev').html(function() {
        return "<i class='glyphicon glyphicon-arrow-left'></i>";
    });
    $('#datepicker table thead th.next').html(function() {
        return "<i class='glyphicon glyphicon-arrow-right'></i>";
    });

    function fillCellContent() {
        $('#datepicker table tbody tr td').each(function (item) {
            var value = $(this).html();
    
            $(this).html(function() {
                return "<div class='cell-content'>"+ value + "</div>";
            });
        })
    }
});


