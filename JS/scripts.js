var lastSelectedLocation = 0;
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

    //send question
    $("#sendQuestion").click(function () {
        var name = $("#contactName"),
            email = $("#contactEmail"),
            question = $("#contactQuestion"),
            isValid = true,
            contactObject = {};

        name.removeClass("error");
        email.removeClass("error");
        question.removeClass("error");

        if (!name.val()) {
            isValid = false;
            name.addClass("error");
        }
        contactObject.name = name.val();

        if (!email.val() || !validateEmail(email.val())) {
            isValid = false;
            email.addClass("error");
        }
        contactObject.email = email.val();

        if (!question.val()) {
            isValid = false;
            question.addClass("error");
        }
        contactObject.question = question.val();
        if (isValid) {
            $(".loaderWrapper").show();
            post("api.php/contact", contactObject, function(data) {
                console.log(data);
                $(".loaderWrapper").hide();
                showModal("Kontakt", "<p>Váš email jsme přijali, budeme vás kontaktovat co nejdříve.</p>");
                name.val("");
                email.val("");
                question.val("");
            }, function (error) {
                console.log(error);
                $(".loaderWrapper").hide();
                showModal("Kontakt", "<p>Váš email jsme přijali, budeme vás kontaktovat co nejdříve.</p>");
                name.val("");
                email.val("");
                question.val("");
            });
        }
    });

    function fillCellContent() {
        $('#datepicker table tbody tr td').each(function (item) {
            var value = $(this).html();
    
            $(this).html(function() {
                return "<div class='cell-content'>"+ value + "</div>";
            });
        })
    }

    function post(url, data, success, error) {
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: success,
            error: error
        });
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function showModal(title, message) {
        var modal = $("#modal");

        $(".modal-title", modal).text(title);
        $(".modal-body", modal).html(message);        
        
        modal.modal();
    }

    //for locations

    var locationModel = {
            month_year: "error",
            rows: [
               /* {
                    position: 1,
                    place: 1
                },
                {
                    position: 2,
                    place: 1
                }*/
            ]
        };
    var actualMonth;
    //start datepicker
    var dt = new Date();
    actualMonth = (dt.getMonth() + 1) + "/" + dt.getFullYear();
    locationModel.month_year = actualMonth
    var placeArray = [];
    getAndRenderPositions();

    $("#datepicker").datepicker().on('changeMonth', function(e){ 
        var currMonth = String(new Date(e.date).getMonth() + 1),
            currYear = String(e.date).split(" ")[3]
           
        actualMonth = currMonth + "/" + currYear;    
        locationModel.month_year = actualMonth;
        getAndRenderPositions();
    });

    $("#datepicker").datepicker().on('changeDate', function(e){ 
        var currMonth = String(new Date(e.date).getMonth() + 1),
            currYear = String(e.date).split(" ")[3],
            newMonth =  currMonth + "/" + currYear;

        if (actualMonth !== newMonth) {
            actualMonth = newMonth;
            locationModel.month_year = actualMonth;
            getAndRenderPositions();
        } else {
            setClickOnRowCalendar();
        }
    });

    function setClickOnRowCalendar() {
        $(".datepicker-days .table-condensed tbody tr").each(function(index) {
            $(this).click(function() {
                lastSelectedLocation = Number(placeArray[index]);
                console.log(placeArray[index]);   
            });
        });
    }

    function getAndRenderPositions() {
        $(".loaderWrapper").show();
        get("api.php/position", locationModel, function(data) {
            locationModel.rows = JSON.parse(data);
            renderLocations();
            $(".loaderWrapper").hide();
        }, function (error) {
            console.log(error);
            $(".loaderWrapper").hide();
        });
    }

    function renderLocations() {
        var position = 1;

        $("#location").empty();
        placeArray = [];
        $(".datepicker-days .table-condensed tbody tr").each(function() {
            $("#location").append( createLocation(position) );
            position++;
        });
        setClickOnRowCalendar();
    }

    function createLocation(pos) {
        var locationElement = $("<div id='" + pos + "'>"),
            placeElement,
            place = "1",
            i;

        for (i = 0; i < locationModel.rows.length; i++) {
            if (pos === Number(locationModel.rows[i].position)) {
                place = locationModel.rows[i].place.toString();
            }
        }

        placeArray.push(place);

        switch (place) {
            case "0": placeElement = $("<span>").text("");
                break;
            case "1": placeElement = $("<span>").text("Brno");
                break;
            case "2": placeElement = $("<span>").text("Olomouc");
                break;
            case "3": placeElement = $("<span>").text("Ostrava");
                break;
            case "4": placeElement = $("<span>").text("Dovolená");
                break;
        }

        locationElement.append(placeElement);
        return locationElement;
    }

    function get(url, data, success, error) {
        $.ajax({
            type: 'GET',
            url: url,
            data: data,
            success: success,
            error: error
        });
    }
});


