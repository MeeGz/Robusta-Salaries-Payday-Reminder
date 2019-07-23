<?php

namespace App\Reminder;

use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;

abstract class Reminder implements ReminderInterface
{
    public $month;
    public $emails;

    abstract public function buildEmail(): ReminderInterface;
    abstract public function setDay(int $day): void;
    
    public function handle()
    {
        //remove not HEREEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
        if(!$this->willSend())
        {
            $this->emails = $this->getAdminsEmails();
            $this->month = Carbon::now()->format('F');
            if(count($this->emails) > 0)
            {
                $this->buildEmail();
                // return $this;
                $this->sendEmails($this->emails, $this);
            }
        }
    }

    public function willSend(): bool
    {
        $date = Carbon::now();
        $day = Carbon::now();
        $day->endOfMonth();
        $day = $this->checkPayDay($date, $day);
        if($day)
        {
            $this->setDay($day);
            return true;
        }
        $day = Carbon::parse('15th ' . date('M'));
        $day = $this->checkPayDay($date, $day);
        if($day)
        {
            $this->setDay($day);
            return true;
        }
        return false;
    }

    public function checkPayDay(Carbon $date, Carbon $pay): int
    {
        if($pay->isFriday())
            $payday = $pay->day - 1;
        else if($pay->isSaturday())
            $payday = $pay->day - 2;
        else
            $payday = $pay->day;

        $day = $date->day;
        if($day == $payday)
            return $day;
        return 0;
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
