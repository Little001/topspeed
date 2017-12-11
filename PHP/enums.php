<?php

abstract class DeliveryMethod
{
    const EMAIL = 1;
    const VOUCHER = 2;
}

abstract class Delivery
{
    const BRNO = 1;
    const OLOMOUC = 2;
    const OSTRAVA = 3;
}

abstract class Duration
{
    const TWELVE_HOURS_PRICE = 1;
    const ONE_DAY_PRICE = 2;
    const TWO_DAY_PRICE = 3;
    const THREE_DAY_PRICE = 4;
    const FOUR_DAY_PRICE = 5;
    const FIVE_DAY_PRICE = 6;
    const WEEKEND_PRICE = 7;
    const HALF_HOUR_PRICE = 8;
    const HOUR_PRICE = 9;
}

abstract class DurationPrice
{
    const TWELVE_HOURS_PRICE = 7999;
    const ONE_DAY_PRICE = 9999;
    const TWO_DAY_PRICE = 13999;
    const THREE_DAY_PRICE = 17999;
    const FOUR_DAY_PRICE = 21999;
    const FIVE_DAY_PRICE = 25999;
    const WEEKEND_PRICE = 14999;
    const HALF_HOUR_PRICE = 3499;
    const HOUR_PRICE = 5999;
}

abstract class PayMethod
{
    const BankAccount = 1;
    const CashOnDelivery = 2;
}

?>