<?php

namespace App\Reminder;

use App\Employee;

class SalaryReminder extends Reminder
{
    public $salaries_payment_day;
    public $salaries_total;

    public function buildEmail(): ReminderInterface
    {
        $this->salaries_total = $this->calculateSalaries();
        return $this;
    }

    public function setDay(int $day): void
    {
        $this->salaries_payment_day = $day;
    }

    public function calculateSalaries(): float
    {
        return (float) Employee::sum('salary');
    }
}
