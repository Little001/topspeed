$( document ).ready(function() {
    var URL = "localhost";

    var isActive = false,
        dayData;

    var reservationObject = {
        code: "",
        date: "",
        time: 0
    }

    //get data
    getDayData();

    $("#reservation-time ul li").click(function() {
        $("#reservation-time ul li").removeClass("selected");
        if (!$(this).hasClass("reservation")) {
            $(this).addClass("selected");
            reservationObject.time = $(this).attr("id");
        }
    })

    $("#datepicker").datepicker().on('changeMonth', function() { 
        var listElement = $("#reservation-time ul");

        listElement.find("li").removeClass("reservation");
        getDayData();
    });

    $("#datepicker").datepicker().on('changeDate', function() {
        var listElement = $("#reservation-time ul"),
            id,
            i;
 
        listElement.find("li").removeClass("reservation");
        for(i = 0; i < dayData.length; i++) {
            
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
        };
        reservationObject.time = listElement.find(".selected").attr("id");
    });

    $("#reservationSubmit").click(function () {
        var date = new Date($("#datepicker").datepicker("getDate")),
            day = date.getDate(),
            month = date.getMonth() + 1,
            year = date.getFullYear(),
            reservationCode = $("#reservationCode");

        reservationCode.removeClass("error");

        if (!reservationCode.val()) {
            reservationCode.addClass("error");
        }
        reservationObject.code = reservationCode;
        if (day && month && year && reservationObject.time != 0) {
            reservationObject.date = day + "/" + month + "/" + year;
            console.log("reservation OK");    
            console.log(reservationObject);   
            post("api.php/reservation", reservationObject, function(data) {
                console.log(data);
            }, function(error) {
                console.log(error);
            }) 
        } else {
            console.log("reservation FAIL");
            console.log(reservationObject);    
        }
        
    });

    function getDayData() {
        dayData = ["8:00 - 8:30", "8:30 - 9:00", "9:00 - 9:30"];
        return;
        get("daysData", function(data) {
            dayData = data;
        }, function () {
            console.log("error");
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

    function get(url, data, success, error) {
        $.ajax({
            type: 'GET',
            url: url,
            data: data,
            success: success,
            error: error
        });
    }

    function succesPostOrder(data) {
        console.log(data);
        $(".loaderWrapper").hide();
        $(".reservation_code").text(data);
        clearOrderDataAndInputs();
        $("#successModal").modal();
    }

    function errorPostOrder(error) {
        console.log(error);
        $(".loaderWrapper").hide();
        $("#failModal").modal();
    }
});


