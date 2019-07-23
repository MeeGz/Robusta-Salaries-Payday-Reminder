<?php

namespace App\Reminder;

class BonusReminder extends Reminder
{
    public function buildEmail(): ReminderInterface
    {
        return $this;
    }
}
