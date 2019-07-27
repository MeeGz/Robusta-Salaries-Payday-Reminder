<?php

namespace App\Reminder;

interface ReminderInterface
{
    public function handle(): void;
}
