<?php

namespace App\Payment;

class PaymentObject
{
    public $month;
    public $salaries_payment_day;
    public $bonus_payment_day;
    public $salaries_total;
    public $bonus_total;
    public $payments_total;

    public function __construct(string $month, int $salaries_payment_day, float $salaries_total, int $bonus_payment_day = null,  float $bonus_total)
    {
        $this->month = $month;
        $this->salaries_payment_day = $salaries_payment_day;
        $this->salaries_total = $salaries_total;
        $this->bonus_payment_day = $bonus_payment_day;
        $this->bonus_total = $bonus_total;
        $this->payments_total = $salaries_total + $bonus_total;
    }
}
