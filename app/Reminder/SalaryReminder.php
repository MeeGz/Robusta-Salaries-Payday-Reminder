<?php

namespace App\Reminder;

class SalaryReminder extends Reminder
{
    public function buildEmail(): ReminderInterface
    {
        return $this;
    }
}
