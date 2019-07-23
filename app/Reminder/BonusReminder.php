<?php

namespace App\Reminder;

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
        return (float) Employee::sum('salary');
    }
}
