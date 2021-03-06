$( document ).ready(function() {
    var TWELVE_HOURS_PRICE = 4990,
        ONE_DAY_PRICE = 5990,
        TWO_DAY_PRICE = 10990,
        THREE_DAY_PRICE = 15990,
        FOUR_DAY_PRICE = 20990,
        FIVE_DAY_PRICE = 25990,
        WEEKEND_PRICE = 14990,
        HALF_HOUR_PRICE = 3499,
        HOUR_PRICE = 5999,
        SEND_VOUCHER = 99,
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
    var reservationNow = false;

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

    $(".slevomat-button").click(function () {
        var win = window.open("https://www.hyperslevy.cz/brno/181726-zazitkova-jizda-ve-ford-mustangu-gt-50-v-brne-olomouci-nebo-ostrave/", '_blank');
        win.focus();
    })

    $('#order-reservation-now').change(function() {
        if($(this).is(":checked")) {
            reservationNow = true;
            return;
        }
        reservationNow = false;
    });

    $("#payOrder").click(function () {
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
            $("#delivery-method").val("1");
            $("#order-customer-pay-method option:nth-child(2)").attr("disabled", true);
            orderObject.payMethod = Number($("#order-customer-pay-method").val());
            orderObject.deliveryMethod = Number($("#delivery-method").val());
            orderObject.delivery = Number($("#order-delivery").val());

            switch(radioMethod) {
                case "enjoy":
                    orderMethod = "enjoy";
                    orderObject.duration = 8;
                    $("#order-enjoy").val("8");
                    $(".enjoyElement").show();
                    $(".normalElement").hide();
                    $(".form-item.street").hide();
                    $(".form-item.city").hide();
                    $(".form-item.psc").hide();
                    $("#order-Carousel .item .item-content .includingFluel").show();
                    currentPrice = HALF_HOUR_PRICE;
                    break;
                case "normal":
                    orderMethod = "normal";
                    orderObject.duration = 1;
                    $("#order-time").val("1");
                    $(".enjoyElement").hide();
                    $(".normalElement").show();
                    $(".form-item.street").show();
                    $(".form-item.city").show();
                    $(".form-item.psc").show();
                    $("#order-Carousel .item .item-content .includingFluel").hide();
                    currentPrice = TWELVE_HOURS_PRICE;
                    break;
            }
            $("#total-price").text(currentPrice);
        }
    });

    //change order-enjoy
    $("#order-enjoy").change(function() {
        var orderEnjoy = $("#order-enjoy"),
            deliveryMethod  = $("#delivery-method"),
            deliveryMethodPrice = 0;

        switch(deliveryMethod.val()) {
            case "1":
            deliveryMethodPrice = 0;
                break;
            case "2":
            deliveryMethodPrice = SEND_VOUCHER;
                break;
        }

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
        currentPrice += deliveryMethodPrice;
        $("#total-price").text(currentPrice);
    });
    //change delivery method
    $("#delivery-method").change(function() {
        var orderTime = $("#delivery-method"),
            payMethod  = $("#order-customer-pay-method");

        switch(orderTime.val()) {
            case "1":
                orderObject.deliveryMethod = 1;
                orderObject.payMethod = 1;
                currentPrice -= SEND_VOUCHER;
                payMethod.val("1");
                $(payMethod).find("option:nth-child(2)").attr("disabled", true);
                break;
            case "2":
                orderObject.deliveryMethod = 2;
                orderObject.payMethod = 1;
                currentPrice += SEND_VOUCHER;
                payMethod.val("1");
                $(payMethod).find("option").attr("disabled", false);
                break;
        }

        $("#total-price").text(currentPrice);
    });


    //change order time
    $("#order-time").change(function() {
        var orderTime = $("#order-time"),
            deliveryMethod  = $("#delivery-method"),
            deliveryMethodPrice = 0;

        switch(deliveryMethod.val()) {
            case "1":
                deliveryMethodPrice = 0;
                break;
            case "2":
                deliveryMethodPrice = SEND_VOUCHER;
                break;
        }

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
        currentPrice += deliveryMethodPrice;
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
        var response = JSON.parse(data);
        $(".loaderWrapper").hide();
        clearOrderDataAndInputs();
        if (reservationNow) {
            showModal("Objednávka", 
            "<p>Objednávka byla odeslána ke zpracování.</p><p>Vás vygenerováný kód pro rezervace je: </p><span class='reservation_code'></span>");
            $(".reservation_code").text(response.code);
            $(document).trigger("order_response", response);
        } else {
            showModal("Objednávka", 
            "<p>Objednávka byla odeslána ke zpracování.</p>");
        }
        
    }

    function errorPostOrder(error) {
        console.log(error);
        $(".loaderWrapper").hide();
        showModal("Objednávka", "<p>Objednávka nebyla přijata, zkontrolujte zadané údaje.</p>");
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

    function showModal(title, message) {
        var modal = $("#modal");

        $(".modal-title", modal).text(title);
        $(".modal-body", modal).html(message);        
        
        modal.modal();
    }
});


