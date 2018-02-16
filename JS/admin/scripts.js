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

    $('#datepicker').datepicker({
        weekStart : 1,
        language: 'cs',
        todayHighlight: 1
    })

    var tableRows = $(".datepicker-days .table-condensed tbody tr"),
        locationModel = {
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
    locationModel.month_year = actualMonth;
    getAndRenderPositions();

    $("#datepicker .datepicker-switch").on('click', function (e) {
        e.stopPropagation();
    });

    //arrows
    $('#datepicker table thead th.prev').html(function() {
        return "<i class='glyphicon glyphicon-arrow-left'></i>";
    });
    $('#datepicker table thead th.next').html(function() {
        return "<i class='glyphicon glyphicon-arrow-right'></i>";
    });

    $("#datepicker").datepicker().on('changeMonth', function(e){ 
        var currMonth = String(new Date(e.date).getMonth() + 1),
            currYear = String(e.date).split(" ")[3];
            
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
            locationModel.month_year = newMonth;
            getAndRenderPositions();
        }
    });

    $("#save").click(function () {
        // post locationModel on server
        $(".loaderWrapper").show();
        post("api.php/position", locationModel, function(data) {
            $(".loaderWrapper").hide();
        }, function (error) {
            console.log(error);
            $(".loaderWrapper").hide();
        });
    });

    function getAndRenderPositions() {
        $(".loaderWrapper").show();
        get("api.php/position", locationModel, function(data) {
            locationModel.rows = JSON.parse(data);
            renderCombos();
            $(".loaderWrapper").hide();
        }, function (error) {
            console.log(error);
            $(".loaderWrapper").hide();
        });
    }

    function renderCombos() {
        var position = 1;

        $("select").remove();
        $(".datepicker-days .table-condensed tbody tr").each(function() {
            $("body").append( createCombo(position) );
            position++;
        });
        bindComboEvents();
    }

    function createCombo(pos) {
        var select = $("<select id='" + pos + "'>"),
            place = "1",
            option,
            i;

        for (i = 0; i < locationModel.rows.length; i++) {
            if (pos === Number(locationModel.rows[i].position)) {
                place = locationModel.rows[i].place.toString();
            }
        }

        option = $("<option>").attr('value', 1).text("Brno");
        option.attr("selected", place === "1" ? "selected" : false)
        select.append(option);
        option = $("<option>").attr('value', 2).text("Olomouc");
        option.attr("selected", place === "2" ? "selected" : false)
        select.append(option);
        option = $("<option>").attr('value', 3).text("Ostrava");
        option.attr("selected", place === "3" ? "selected" : false)
        select.append(option);

        return select;
    }

    function bindComboEvents() {
        $("select").change(function () {
            var row = $(this).attr('id');

            for (i = 0; i < locationModel.rows.length; i++) {
                if (row == locationModel.rows[i].position) {
                    locationModel.rows[i].place = parseInt($(this).val());
                }
            }
        });
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


