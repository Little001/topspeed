<?php
require_once('PHP/enums.php');

class EnumsController {

    //ride method
    public static function getRideMethodText($rideMethod) {
        switch ($rideMethod) {
            case RideMethod::Hire:
                return RideMethodText::Hire;
            case RideMethod::Enjoy:
                return RideMethodText::Enjoy;
        }
    }

    //pay method
    public static function getPayMethod($object, $payMethod) {
        switch ($payMethod) {
            case PayMethod::BankAccount:
                $object->payMethod = PayMethod::BankAccount;
                return true;
            case PayMethod::CashOnDelivery:
                $object->payMethod = PayMethod::CashOnDelivery;
                return true;
            default: 
                return false;
        }
    }

    public static function getPayMethodText($payMethod) {
        switch ($payMethod) {
            case PayMethod::BankAccount:
                return PayMethodText::BankAccount;
            case PayMethod::CashOnDelivery:
                return PayMethodText::CashOnDelivery;
        }
    }
    //duration
    public static function getDuration($object, $duration) {
        switch ($duration) {
            case Duration::TWELVE_HOURS_PRICE:
                $object->duration = Duration::TWELVE_HOURS_PRICE;
                return true;
            case Duration::ONE_DAY_PRICE:
                $object->duration = Duration::ONE_DAY_PRICE;
                return true;
            case Duration::TWO_DAY_PRICE:
                $object->duration = Duration::TWO_DAY_PRICE;
                return true;
            case Duration::THREE_DAY_PRICE:
                $object->duration = Duration::THREE_DAY_PRICE;
                return true;
            case Duration::FOUR_DAY_PRICE:
                $object->duration = Duration::FOUR_DAY_PRICE;
                return true;
            case Duration::FIVE_DAY_PRICE:
                $object->duration = Duration::FIVE_DAY_PRICE;
                return true;
            case Duration::WEEKEND_PRICE:
                $object->duration = Duration::WEEKEND_PRICE;
                return true;
            case Duration::HALF_HOUR_PRICE:
                $object->duration = Duration::HALF_HOUR_PRICE;
                return true;
            case Duration::HOUR_PRICE:
                $object->duration = Duration::HOUR_PRICE;
                return true;
            default: 
                return false;
        }
    }

    public static function getDurationText($duration) {
        switch ($duration) {
            case Duration::TWELVE_HOURS_PRICE:
                return DurationText::TWELVE_HOURS_PRICE;
            case Duration::ONE_DAY_PRICE:
                return DurationText::ONE_DAY_PRICE;
            case Duration::TWO_DAY_PRICE:
                return DurationText::TWO_DAY_PRICE;
            case Duration::THREE_DAY_PRICE:
                return DurationText::THREE_DAY_PRICE;
            case Duration::FOUR_DAY_PRICE:
                return DurationText::FOUR_DAY_PRICE;
            case Duration::FIVE_DAY_PRICE:
                return DurationText::FIVE_DAY_PRICE;
            case Duration::WEEKEND_PRICE:
                return DurationText::WEEKEND_PRICE;
            case Duration::HALF_HOUR_PRICE:
                return DurationText::HALF_HOUR_PRICE;
            case Duration::HOUR_PRICE:
                return DurationText::HOUR_PRICE;
        }
    }

    public static function getDurationPrice($duration) {
        switch ($duration) {
            case Duration::TWELVE_HOURS_PRICE:
                return DurationPrice::TWELVE_HOURS_PRICE;
            case Duration::ONE_DAY_PRICE:
                return DurationPrice::ONE_DAY_PRICE;
            case Duration::TWO_DAY_PRICE:
                return DurationPrice::TWO_DAY_PRICE;
            case Duration::THREE_DAY_PRICE:
                return DurationPrice::THREE_DAY_PRICE;
            case Duration::FOUR_DAY_PRICE:
                return DurationPrice::FOUR_DAY_PRICE;
            case Duration::FIVE_DAY_PRICE:
                return DurationPrice::FIVE_DAY_PRICE;
            case Duration::WEEKEND_PRICE:
                return DurationPrice::WEEKEND_PRICE;
            case Duration::HALF_HOUR_PRICE:
                return DurationPrice::HALF_HOUR_PRICE;
            case Duration::HOUR_PRICE:
                return DurationPrice::HOUR_PRICE;
        }
    }

    //delivery
    public static function getDelivery($object, $delivery) {
        switch ($delivery) {
            case Delivery::BRNO:
                $object->delivery = Delivery::BRNO;
                return true;
            case Delivery::OLOMOUC:
                $object->delivery = Delivery::OLOMOUC;
                return true;
            case Delivery::OSTRAVA:
                $object->delivery = Delivery::OSTRAVA;
                return true;
            default: 
                return false;
        }
    }
    public static function getDeliveryText($delivery) {
        switch ($delivery) {
            case Delivery::BRNO:
                return DeliveryText::BRNO;
            case Delivery::OLOMOUC:
                return DeliveryText::OLOMOUC;
            case Delivery::OSTRAVA:
                return DeliveryText::OSTRAVA;
        }
    }

    //delivery method
    public static function getDeliveryMethod($object, $deliveryMethod) {
        switch ($deliveryMethod) {
            case DeliveryMethod::EMAIL:
                $object->deliveryMethod = DeliveryMethod::EMAIL;
                return true;
            case DeliveryMethod::VOUCHER:
                $object->deliveryMethod = DeliveryMethod::VOUCHER;
                return true;
            default: 
                return false;
        }
    }

    public static function getDeliveryMethodText($deliveryMethod) {
        switch ($deliveryMethod) {
            case DeliveryMethod::EMAIL:
                return DeliveryMethodText::EMAIL;
            case DeliveryMethod::VOUCHER:
                return DeliveryMethodText::VOUCHER;
        }
    }

    public static function getDeliveryMethodPrice($deliveryMethod) {
        switch ($deliveryMethod) {
            case DeliveryMethod::EMAIL:
                return DeliveryMethodPrice::EMAIL;
            case DeliveryMethod::VOUCHER:
                return DeliveryMethodPrice::VOUCHER;
        }
    }
}

?>