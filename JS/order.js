$( document ).ready(function() {
    var TWELVE_HOURS_PRICE = 7999,
        ONE_DAY_PRICE = 9999,
        TWO_DAY_PRICE = 13999,
        THREE_DAY_PRICE = 17999,
        FOUR_DAY_PRICE = 21999,
        FIVE_DAY_PRICE = 25999,
        WEEKEND_PRICE = 14999,
        HALF_HOUR_PRICE = 3499,
        HOUR_PRICE = 5999,
        currentPrice = TWELVE_HOURS_PRICE; //default

    var orderObject = {
        street: "",
        city: "",
        psc: 0,
        customerName: "",
        customerStreet: "",
        customerCity: "",
        customerPsc: "",
        customerEmail: "",
        customerPhone: "",
        payMethod: 1,
        duration: 1,
        delivery: 1,
        deliveryMethod: 1
    };

    var orderMethod = "normal";

    function getPayMethod(payMethod) {
        switch(payMethod) {
            case 1:
                return "Bankovním převodem";
            case 2: 
                return "Dobírka";
        }
    }

    $("#total-price").text(currentPrice);
    
    $("#borow-button").click(function () {
        if (orderMethod !== "normal") {
        } else {
            if(!firstStepIsValid()) {
                return;
            }
        }
        $("#borow-button").closest('.carousel').carousel('next');
    });

    $("#payOrder").click(function () {
        console.log(orderObject);
        $(".loaderWrapper").show();
        if (orderMethod == "normal") {
            post("api.php/hire", orderObject, succesPostOrder, errorPostOrder);
        } else if (orderMethod == "enjoy") {
            post("api.php/enjoy", orderObject, succesPostOrder, errorPostOrder);
        }
    });

    //on click to recapitulaiton
    $("#order-continue").click(function () {
        if (!secondStepIsValid()) {
            if ($("#order-reservation-now").is(':checked')) {
                //todo   
            }
            return;
        }
        $("#order-continue").closest('.carousel').carousel('next');
        $("#overview-name").text(orderObject.customerName);
        $("#overview-street").text(orderObject.customerStreet);
        $("#overview-city").text(orderObject.customerCity);
        $("#overview-psc").text(orderObject.customerPsc);
        $("#overview-email").text(orderObject.customerEmail);
        $("#overview-phone").text(orderObject.customerPhone);
        $("#overview-pay-method").text(getPayMethod(orderObject.payMethod));
    });

    /*RADIO BUTTON METHOD*/
    $(".drive-method").change(function () {
        if($("input[type='radio'].drive-method").is(':checked')) {
            var radioMethod = $("input[type='radio'].drive-method:checked").val();
            orderObject.payMethod = Number($("#order-customer-pay-method").val());
            orderObject.deliveryMethod = Number($("#delivery-method").val());
            orderObject.delivery = Number($("#order-delivery").val());

            switch(radioMethod) {
                case "enjoy":
                    orderMethod = "enjoy";
                    orderObject.duration = Number($("#order-enjoy").val());
                    $(".enjoyElement").show();
                    $(".normalElement").hide();
                    $(".form-item.street").hide();
                    $(".form-item.city").hide();
                    $(".form-item.psc").hide();
                    $("#order-Carousel .item .item-content .includingFluel").show();
                    $("#total-price").text(HALF_HOUR_PRICE);
                    break;
                case "normal":
                    orderMethod = "normal";
                    orderObject.duration = Number($("#order-time").val());
                    $(".enjoyElement").hide();
                    $(".normalElement").show();
                    $(".form-item.street").show();
                    $(".form-item.city").show();
                    $(".form-item.psc").show();
                    $("#order-Carousel .item .item-content .includingFluel").hide();
                    $("#total-price").text(TWELVE_HOURS_PRICE);
                    break;
            }
        }
    });

    //change order-enjoy
    $("#order-enjoy").change(function() {
        var orderEnjoy = $("#order-enjoy");

        switch(orderEnjoy.val()) {
            case "8":
                currentPrice = HALF_HOUR_PRICE;
                orderObject.duration = 8;
                break;
            case "9":
                currentPrice = HOUR_PRICE;
                orderObject.duration = 9;
                break;
        }
        $("#total-price").text(currentPrice);
    });
    //change delivery method
    $("#delivery-method").change(function() {
        var orderTime = $("#delivery-method");

        switch(orderTime.val()) {
            case "1":
                orderObject.deliveryMethod = 1;
                break;
            case "2":
                orderObject.deliveryMethod = 2;
                break;
        }
    });


    //change order time
    $("#order-time").change(function() {
        var orderTime = $("#order-time");

        switch(orderTime.val()) {
            case "1":
                currentPrice = TWELVE_HOURS_PRICE;
                orderObject.duration = 1;
                break;
            case "2":
                currentPrice = ONE_DAY_PRICE;
                orderObject.duration = 2;
                break;
            case "3":
                currentPrice = TWO_DAY_PRICE;
                orderObject.duration = 3;
                break;
            case "4":
                currentPrice = THREE_DAY_PRICE;
                orderObject.duration = 4;
                break;
            case "5":
                currentPrice = FOUR_DAY_PRICE;
                orderObject.duration = 5;
                break;
            case "6":
                currentPrice = FIVE_DAY_PRICE;
                orderObject.duration = 6;
                break;
            case "7":
                currentPrice = WEEKEND_PRICE;
                orderObject.duration = 7;
                break;
        }
        $("#total-price").text(currentPrice);
    });

    //change delivery car
    $("#order-delivery").change(function() {
        var orderDelivery = $("#order-delivery");

        switch(orderDelivery.val()) {
            case "1":
                orderObject.delivery = 1;
                break;
            case "2":
                orderObject.delivery = 2;
                break;
            case "3":
                orderObject.delivery = 3;
                break;
        }
    });

    function firstStepIsValid() {
        var street = $("#order-street"),
            city = $("#order-city"),
            psc = $("#order-psc"),
            isValid = true;

        street.removeClass("error");
        city.removeClass("error");
        psc.removeClass("error");

        if (!street.val()) {
            isValid = false;
            street.addClass("error");
        }
        orderObject.street = street.val();

        if (!city.val()) {
            isValid = false;
            city.addClass("error");
        }
        orderObject.city = city.val();

        if (!psc.val()) {
            isValid = false;
            psc.addClass("error");
        }
        orderObject.psc = psc.val();

        return isValid;
    }

    function secondStepIsValid() {
        var customerName = $("#order-customer-name"),
            customerStreet = $("#order-customer-street"),
            customerCity = $("#order-customer-city"),
            customerPsc = $("#order-customer-psc"),
            customerEmail = $("#order-customer-email"),
            customerPhone = $("#order-customer-phone"),
            agreeIsChecked = $('#order-agree')[0].checked,
            agreeInput = $(".content-order .checkboxInput"),
            isValid = true;

        customerName.removeClass("error");
        customerStreet.removeClass("error");
        customerCity.removeClass("error");
        customerPsc.removeClass("error");
        customerEmail.removeClass("error");
        customerPhone.removeClass("error");
        agreeInput.removeClass("error");

        if(!agreeIsChecked) {
            agreeInput.addClass("error");
            isValid = false;
        }

        if (!customerName.val()) {
            isValid = false;
            customerName.addClass("error");
        }
        orderObject.customerName = customerName.val();

        if (!customerStreet.val()) {
            isValid = false;
            customerStreet.addClass("error");
        }
        orderObject.customerStreet = customerStreet.val();

        if (!customerCity.val()) {
            isValid = false;
            customerCity.addClass("error");
        }
        orderObject.customerCity = customerCity.val();

        if (!customerPsc.val()) {
            isValid = false;
            customerPsc.addClass("error");
        }
        orderObject.customerPsc = customerPsc.val();

        if (!customerEmail.val() || !validateEmail(customerEmail.val())) {
            isValid = false;
            customerEmail.addClass("error");
        }
        orderObject.customerEmail = customerEmail.val();

        if (!customerPhone.val()) {
            isValid = false;
            customerPhone.addClass("error");
        }
        orderObject.customerPhone = customerPhone.val();
        orderObject.payMethod = Number($("#order-customer-pay-method").val());

        return isValid;
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

    function clearOrderDataAndInputs() {
        orderObject.street = "";
        orderObject.city = "";
        orderObject.psc = 0;
        orderObject.customerName = "";
        orderObject.customerStreet = "";
        orderObject.customerCity = "";
        orderObject.customerPsc = "";
        orderObject.customerEmail = "";
        orderObject.customerPhone = "";
        orderObject.payMethod = 1;
        orderObject.duration = 1;
        orderObject.delivery = 1;
        orderObject.deliveryMethod = 1;

        $("#order-street").val("");
        $("#order-city").val("");
        $("#order-psc").val("");

        $("#order-customer-name").val("");
        $("#order-customer-street").val("");
        $("#order-customer-city").val("");
        $("#order-customer-psc").val("");
        $("#order-customer-email").val("");
        $("#order-customer-phone").val("");

        $("#order-customer-pay-method").val("1");
        $("#delivery-method").val("1");
        $("#order-delivery").val("1");
        $("#order-enjoy").val("8");
        $("#order-time").val("1");

        $( "#order-reservation-now" ).prop( "checked", false );
        $( "#order-agree" ).prop( "checked", false );

        $("#order-Carousel .item.active").removeClass("active");
        $("#order-Carousel .item").first().addClass("active");
    }
    
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
});


