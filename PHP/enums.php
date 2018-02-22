<?php

abstract class DeliveryMethod
{
    const EMAIL = 1;
    const VOUCHER = 2;
}

abstract class DeliveryMethodText
{
    const EMAIL = "Email";
    const VOUCHER = "Dárkový voucher poštou";
}

abstract class DeliveryMethodPrice
{
    const EMAIL = 0;
    const VOUCHER = 99;
}

abstract class Delivery
{
    const BRNO = 1;
    const OLOMOUC = 2;
    const OSTRAVA = 3;
}

abstract class DeliveryText
{
    const BRNO = "BRNO";
    const OLOMOUC = "OLOMOUC";
    const OSTRAVA = "OSTRAVA";
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
    const TWELVE_HOURS_PRICE = 4990;
    const ONE_DAY_PRICE = 5990;
    const TWO_DAY_PRICE = 10990;
    const THREE_DAY_PRICE = 15990;
    const FOUR_DAY_PRICE = 20990;
    const FIVE_DAY_PRICE = 25990;
    const WEEKEND_PRICE = 14990;
    const HALF_HOUR_PRICE = 3499;
    const HOUR_PRICE = 5999;
}

abstract class Location
{
    const NOT_SPECIFY = 0;
    const BRNO = 1;
    const OLOMOUC = 2;
    const OSTRAVA = 3;
    const VACATION = 4;
}

abstract class DurationText
{
    const TWELVE_HOURS_PRICE = "12 hodin";
    const ONE_DAY_PRICE = "1 den";
    const TWO_DAY_PRICE = "2 dny";
    const THREE_DAY_PRICE = "3 dny";
    const FOUR_DAY_PRICE = "4 dny";
    const FIVE_DAY_PRICE = "5 dny";
    const WEEKEND_PRICE = "Výkend";
    const HALF_HOUR_PRICE = "Půl hodiny";
    const HOUR_PRICE = "1 hodina";
}

abstract class PRICES
{
    const SEND_VOUCHER = 99;
}

abstract class PayMethod
{
    const BankAccount = 1;
    const CashOnDelivery = 2;
}

abstract class PayMethodText
{
    const BankAccount = "Bankovním převod";
    const CashOnDelivery = "Dobírka";
}

abstract class RideMethod
{
    const Hire = 1;
    const Enjoy = 2;
}

abstract class RideMethodText
{
    const Hire = "Pronájem vozu";
    const Enjoy = "Zážitková jízda";
}

?>