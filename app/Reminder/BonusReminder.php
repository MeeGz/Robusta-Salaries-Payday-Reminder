<?php

namespace App\Reminder;

use Illuminate\Support\Facades\DB;

class BonusReminder extends Reminder
{
    public $bonus_payment_day;
    public $bonus_total;

    public function buildEmail(): ReminderInterface
    {
        $this->bonus_total = $this->calculateSalaries();
        return $this;
    }

    public function setDay(int $day): void
    {
        $this->bonus_payment_day = $day;
    }

    public function calculateSalaries(): float
    {
        return (float)DB::table("employees")->select(DB::raw("SUM(salary*bonus_rate/100) AS bonus_total"))->first()->bonus_total;
    }
}
