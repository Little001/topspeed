$( document ).ready(function() {
    var URL = "localhost";

    var isActive = false,
        dayData;

    $("#datepicker").datepicker().on('changeMonth', function(){ 
        var listElement = $(".content-reservation .right-content .time-table");

        listElement.find("li").removeClass("reservation");
        getDayData();
    });

    $("#datepicker").datepicker().on('changeDate', function() {
        var listElement = $(".content-reservation .right-content .time-table"),
            i;

        listElement.find("li").removeClass("reservation");
        for(i = 0; i < dayData.length; i++) {
            switch(dayData[i]) {
                case "8:00 - 8:30": listElement.find("#1").addClass("reservation")
                    break;
                case "8:30 - 9:00": listElement.find("#2").addClass("reservation")
                    break;
                case "9:00 - 9:30": listElement.find("#3").addClass("reservation")
                    break;
                case "9:30 - 10:00": listElement.find("#4").addClass("reservation")
                    break;
                case "10:00 - 10:30": listElement.find("#5").addClass("reservation")
                    break;
                case "10:30 - 11:00": listElement.find("#6").addClass("reservation")
                    break;
                case "11:00 - 11:30": listElement.find("#7").addClass("reservation")
                    break;
                case "11:30 - 12:00": listElement.find("#8").addClass("reservation")
                    break;
                case "12:00 - 12:30": listElement.find("#9").addClass("reservation")
                    break;
                case "12:30 - 13:00": listElement.find("#10").addClass("reservation")
                    break;
                case "13:00 - 13:30": listElement.find("#11").addClass("reservation")
                    break;
                case "13:30 - 14:00": listElement.find("#12").addClass("reservation")
                    break;
                case "14:00 - 14:30": listElement.find("#13").addClass("reservation")
                    break;
                case "14:30 - 15:00": listElement.find("#14").addClass("reservation")
                    break;
                case "15:00 - 15:30": listElement.find("#15").addClass("reservation")
                    break;
                case "15:30 - 16:00": listElement.find("#16").addClass("reservation")
                    break;
                case "16:00 - 16:30": listElement.find("#17").addClass("reservation")
                    break;
                case "16:30 - 17:00": listElement.find("#18").addClass("reservation")
                    break;
                case "17:00 - 17:30": listElement.find("#19").addClass("reservation")
                    break;
                case "17:30 - 18:00": listElement.find("#20").addClass("reservation")
                    break;
                case "18:00 - 18:30": listElement.find("#21").addClass("reservation")
                    break;
                case "18:30 - 19:00": listElement.find("#22").addClass("reservation")
                    break;
                case "19:00 - 19:30": listElement.find("#23").addClass("reservation")
                    break;
                case "19:30 - 20:00": listElement.find("#24").addClass("reservation")
                    break;
            }
        };
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


    //post request
    function post(route, data, success, error) {
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: success,
            error: error,
            contentType: "application/json",
            dataType: "json",
        });
    }

    //get request
    function get(route, success, error) {
        $.ajax({
            type: "GET",
            url: url,
            success: success,
            error: error,
            contentType: "application/json",
            dataType: "json",
        });
    }
});


