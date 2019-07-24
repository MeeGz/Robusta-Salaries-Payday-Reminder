<?php

namespace App\Reminder;

use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;
use Illuminate\Support\Facades\DB;
use App\Employee;

abstract class Reminder implements ReminderInterface
{
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

    public function getBonusDay()
    {
        $day = Carbon::parse('15th ' . date('M'));
        if($day->isFriday())
            $payday = $day->day - 1;
        else if($day->isSaturday())
            $payday = $day->day - 2;
        else
            $payday = $day->day;
        return $payday;
    }

    public function getSalaryDay()
    {
        $day = Carbon::now()->endOfMonth();
        if($day->isFriday())
            $payday = $day->day - 1;
        else if($day->isSaturday())
            $payday = $day->day - 2;
        else
            $payday = $day->day;
        return $payday;
    }

    public function getAdminsEmails(): array
    {
        return User::whereHas('admin')->select('email')->pluck('email')->toArray();
    }

    public function calculateSalaries(): float
    {
        return (float) Employee::sum('salary');
    }

    public function calculateBonus(): float
    {
        return (float)DB::table("employees")->select(DB::raw("SUM(salary*bonus_rate/100) AS bonus_total"))->first()->bonus_total;
    }

    public function sendEmails(array $emails, ReminderInterface $reminder): void
    {
        Mail::to($emails)->send(new ReminderMail($reminder));
    }

    
}
