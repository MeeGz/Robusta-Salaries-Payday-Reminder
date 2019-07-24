<?php

namespace App\Reminder;

use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\Traits\GetDays;
use App\Traits\GetTotals;

abstract class Reminder implements ReminderInterface
{
    use GetDays, GetTotals;

    public $month;
    public $year;
    public $emails = [];
    public $bonus_total;
    public $bonus_payment_day;

    abstract public function handle(): void;
    abstract public function setReminder(int $day): void;
    public function willSend($day): bool
    {
        // return true; // to test
        $today = Carbon::now()->day;
        if($day == $today)
            return true;
        return false;
    }

    public function getAdminsEmails(): array
    {
        return User::whereHas('admin')->select('email')->pluck('email')->toArray();
    }

    
    public function sendEmails(array $emails, ReminderInterface $reminder): void
    {
        Mail::to($emails)->send(new ReminderMail($reminder));
    }

    
}
