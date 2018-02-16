$( document ).ready(function() {
    $( document ).on("order_response", function(event, data) {
        setCalender(data);
    });
    var URL = "localhost";

    var isActive = false,
        dayData,
        durationInFileds = 0,
        delivery,
        duration;

    var reservationObject = {
        code: "",
        date: "",
        time: "",
        delivery: 0
    }

    $("#reservation-time ul li").click(function() {
        $("#reservation-time ul li").removeClass("selected");
        if (!$(this).hasClass("reservation")) {
            $(this).addClass("selected");
        }

        reservationObject.time = getTimeText(Number($(this).attr("id")));  
        $("#time_reservation").text(getTimeText(Number($(this).attr("id"))));
    })

    $("#datepicker").datepicker().on('changeMonth', function() { 
        var listElement = $("#reservation-time ul");

        listElement.find("li").removeClass("reservation");
    });

    $("#datepicker").datepicker().on('changeDate', function(e) {
        var listElement = $("#reservation-time ul"),
            id,
            i;
 
        listElement.find("li").removeClass("reservation");
        /*for(i = 0; i < dayData.length; i++) {
            
            switch(dayData[i]) {
                case "8:00 - 8:30":
                    id="1";
                    break;
                case "8:30 - 9:00": 
                    id="2";
                    break;
                case "9:00 - 9:30": 
                    id="3";
                    break;
                case "9:30 - 10:00": 
                    id="4";
                    break;
                case "10:00 - 10:30": 
                    id="5";
                    break;
                case "10:30 - 11:00": 
                    id="6";
                    break;
                case "11:00 - 11:30":
                    id="7";
                    break;
                case "11:30 - 12:00": 
                    id="8";
                    break;
                case "12:00 - 12:30": 
                    id="9";
                    break;
                case "12:30 - 13:00": 
                    id="10";
                    break;
                case "13:00 - 13:30": 
                    id="11";
                    break;
                case "13:30 - 14:00": 
                    id="12";
                    break;
                case "14:00 - 14:30": 
                    id="13";
                    break;
                case "14:30 - 15:00": 
                    id="14";
                    break;
                case "15:00 - 15:30": 
                    id="15";
                    break;
                case "15:30 - 16:00": 
                    id="16";
                    break;
                case "16:00 - 16:30": 
                    id="17";
                    break;
                case "16:30 - 17:00": 
                    id="18";
                    break;
                case "17:00 - 17:30": 
                    id="19";
                    break;
                case "17:30 - 18:00": 
                    id="20";
                    break;
                case "18:00 - 18:30": 
                    id="21";
                    break;
                case "18:30 - 19:00": 
                    id="22";
                    break;
                case "19:00 - 19:30": 
                    id="23";
                    break;
                case "19:30 - 20:00": 
                    id="24";
                    break;
            }
            listElement.find("#"+id).addClass("reservation");
            listElement.find("#"+id).removeClass("selected");
        }; */
        //reservationObject.time = listElement.find(".selected").attr("id");
        $("#date_reservation").text($("#datepicker").datepicker("getFormattedDate"));
    });

    $("#checkButton").click(function () {
        var reservationCode = $("#reservationCode"),
            checkCodeModel = {
                code: reservationCode.val()
            },
            response;

        $(".loaderWrapper").show();

        get("api.php/checkCode", checkCodeModel, function(data) {
            response = JSON.parse(data);
            response.code = checkCodeModel.code;
            setCalender(response);
            $(".loaderWrapper").hide();
        }, function (error) {
            console.log(error);
            $(".loaderWrapper").hide();
            showModal("Kód", "<p>Váš kód již vypršel nebo neexistuje.</p>");
        });
    })  

    $("#reservationSubmit").click(function () {
        var date = $("#datepicker").datepicker("getFormattedDate"),
            reservationCode = $("#reservationCode"),
            delivery_reservation = $("#delivery_reservation"),
            reservation_time = $("#reservation-time"),
            datepicker = $("#datepicker"),
            customerName = $("#customerName"),
            canReserved = true;
        
        reservationCode.removeClass("error");
        customerName.removeClass("error");
        delivery_reservation.removeClass("error");
        reservation_time.removeClass("error");
        datepicker.removeClass("error");

        if (!reservationCode.val()) {
            reservationCode.addClass("error");
            canReserved = false;
        }

        if (!reservationCode.val()) {
            reservationCode.addClass("error");
            canReserved = false;
        }
        reservationObject.code = reservationCode.val();

        if (!reservationObject.delivery) {
            delivery_reservation.addClass("error");
            canReserved = false;
        }
        if (!date) {
            datepicker.addClass("error");
            canReserved = false;
        }
        reservationObject.date = date;

        if (!reservationObject.time && (durationInFileds != 1 || durationInFileds != 2)) {
            reservation_time.addClass("error");
            canReserved = false;
        }
   
        if (canReserved) { 
            console.log(reservationObject);   
            post("api.php/reservation", reservationObject, function(data) {
                console.log(data);
            }, function(error) {
                console.log(error);
            })
        }
    });

    function setCalender(data) {
        delivery = data.delivery;
        duration = data.duration;
        //fill data
        $("#reservationCode").val(data.code);
        $("#rideMethod").text(data.rideMethod);
        $("#duration").text(getDuration(Number(data.duration)));
        $("#customerName").text(data.customerName);
        $("#delivery_reservation").text(getDelivery(Number(data.delivery)));

        reservationObject.delivery = Number(data.delivery);
        reservationObject.code = data.code;
    }

    function getDuration(duration) {
        durationInFileds = 0;
        switch (duration) {
            case 8: durationInFileds = 1;
                return "30 minut";
            case 9: durationInFileds = 2;
                return "1 hodina";
            case 1: return "12 hodin";
            case 2: return "1 den";
            case 3: return "2 dny";
            case 4: return "3 dny";
            case 5: return "4 dny";
            case 6: return "5 dní";
            case 7: return "výkend";
        }
    }

    function getDelivery(delivery) {
        switch (delivery) {
            case 1: return "BRNO";
            case 2: return "OLOMOUC";
            case 3: return "OSTRAVA";
            default: return "";
        }
    }

    function getTimeText(time) {
        switch(time) {
            case 1: return "8:00 - 8:30";
            case 2: return "8:30 - 9:00";
            case 3: return "9:00 - 9:30"; 
            case 4: return "9:30 - 10:00"; 
            case 5: return "10:00 - 10:30"; 
            case 6: return "10:30 - 11:00"; 
            case 7: return "11:00 - 11:30";
            case 8: return "11:30 - 12:00"; 
            case 9: return "12:00 - 12:30"; 
            case 10: return "12:30 - 13:00"; 
            case 11: return"13:00 - 13:30";
            case 12: return"13:30 - 14:00"; 
            case 13: return"14:00 - 14:30"; 
            case 14: return"14:30 - 15:00"; 
            case 15: return"15:00 - 15:30"; 
            case 16: return"15:30 - 16:00"; 
            case 17: return "16:00 - 16:30"; 
            case 18: return "16:30 - 17:00"; 
            case 19: return "17:00 - 17:30"; 
            case 20: return "17:30 - 18:00"; 
            case 21: return "18:00 - 18:30"; 
            case 22: return "18:30 - 19:00"; 
            case 23: return "19:00 - 19:30"; 
            case 24: return "19:30 - 20:00"; 
        }
    }

    function showModal(title, message) {
        var modal = $("#modal");

        $(".modal-title", modal).text(title);
        $(".modal-body", modal).html(message);        
        
        modal.modal();
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


