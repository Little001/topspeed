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
        position = 1,
        locationModel = {
            month: "08/18",
            rows: [
                {
                    position: 1,
                    place: 1
                },
                {
                    position: 2,
                    place: 2
                },
                {
                    position: 3,
                    place: 1
                },
                {
                    position: 4,
                    place: 2
                },
                {
                    position: 5,
                    place: 1
                },
                {
                    position: 6,
                    place: 3
                }
            ]
        };

    renderCombos();

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
        // get data from server
        // set  locationModel
        renderCombos();
    });

    $("#save").click(function () {
        // post locationModel on server
        $(".loaderWrapper").show();
    });

    function renderCombos() {
        tableRows.each(function() {
            $("body").append( createCombo(position) );
            position++;
        });
    }

    function createCombo(pos) {
        var select = $("<select id='" + pos + "'>"),
            place = 1,
            option,
            i;

        for (i = 0; i < locationModel.rows.length; i++) {
            if (pos === locationModel.rows[i].position) {
                place = locationModel.rows[i].place;
            }
        }

        option = $("<option>").attr('value', 1).text("Ostrava");
        option.attr("selected", place === 1 ? "selected" : false)
        select.append(option);
        option = $("<option>").attr('value', 2).text("Brno");
        option.attr("selected", place === 2 ? "selected" : false)
        select.append(option);
        option = $("<option>").attr('value', 3).text("Olomouc");
        option.attr("selected", place === 3 ? "selected" : false)
        select.append(option);

        return select;
    }

    $("select").change(function () {
        var row = $(this).attr('id');

        for (i = 0; i < locationModel.rows.length; i++) {
            if (row == locationModel.rows[i].position) {
                locationModel.rows[i].place = parseInt($(this).val());
            }
        }

        // console.log(locationModel);
    });
});


