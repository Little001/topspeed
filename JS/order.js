$( document ).ready(function() {
    var ORDER_PRICE = 3990,
        SIX_HOURS_PRICE = 500,
        TWELVE_HOURS_PRICE = 1000,
        TWENTY_FOUR_HOURS_PRICE = 1500,
        DELIVERY_BRNO_PRICE = 390;
        DELIVERY_OLOMOUC_PRICE = 290,
        DELIVERY_PRAGUE_PRICE = 600,
        currentHoursPrice = SIX_HOURS_PRICE;
        currentDeliveryPrice = DELIVERY_BRNO_PRICE;
        totalPrice = ORDER_PRICE + currentHoursPrice + currentDeliveryPrice; //default

    var orderObject = {
        street: null,
        city: null,
        psc: null,
        customerName: null,
        customerStreet: null,
        customerCity: null,
        customerPsc: null,
        customerEmail: null,
        customerPhone: null,
        payMethod: "",
        hours: 1,
        delivery: 1
    };

    $("#order-price").text(ORDER_PRICE + SIX_HOURS_PRICE);
    $("#order-delivery-price").text(DELIVERY_BRNO_PRICE);
    $("#total-price").text(totalPrice);
    
    $("#borow-button").click(function () {
        if(!firstStepIsValid()) {
            return;
        }
        
        $("#borow-button").closest('.carousel').carousel('next');
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
        $("#overview-pay-method").text(orderObject.payMethod);
    });;

    //change order time
    $("#order-time").change(function() {
        var orderPrice = $("#order-price"),
            orderTime = $("#order-time");

        switch(orderTime.val()) {
            case "1":
                currentHoursPrice = SIX_HOURS_PRICE;
                orderPrice.text(ORDER_PRICE + currentHoursPrice);
                orderObject.hours = 1;
                break;
            case "2":
                currentHoursPrice = TWELVE_HOURS_PRICE;
                orderPrice.text(ORDER_PRICE + currentHoursPrice);
                orderObject.hours = 2;
                break;
            case "3":
                currentHoursPrice = TWENTY_FOUR_HOURS_PRICE;
                orderPrice.text(ORDER_PRICE + currentHoursPrice);
                orderObject.hours = 3;
                break;
        }
        totalPrice = ORDER_PRICE + currentHoursPrice + currentDeliveryPrice;
        $("#total-price").text(totalPrice);
    });

    //change delivery car
    $("#order-delivery").change(function() {
        var orderDelivery = $("#order-delivery");

        switch(orderDelivery.val()) {
            case "1":
                currentDeliveryPrice = DELIVERY_BRNO_PRICE;
                orderObject.delivery = 1;
                break;
            case "2":
                currentDeliveryPrice = DELIVERY_OLOMOUC_PRICE;
                orderObject.delivery = 2;
                break;
            case "3":
                currentDeliveryPrice = DELIVERY_PRAGUE_PRICE;
                orderObject.delivery = 3;
                break;
        }
        $("#order-delivery-price").text(currentDeliveryPrice);
        totalPrice = ORDER_PRICE + currentHoursPrice + currentDeliveryPrice;
        $("#total-price").text(totalPrice);
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
        orderObject.payMethod = $("#order-customer-pay-method").val();

        return isValid;
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
});


