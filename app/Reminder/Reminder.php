<?php

namespace App\Reminder;

abstract class Reminder implements ReminderInterface
{
    protected $month;
    protected $salaries_payment_day;
    protected $salaries_total;
    protected $bonus_payment_day;
    protected $bonus_total;
    protected $payments_total;

    abstract protected function buildEmail(): ReminderInterface;

    protected function handle(): void
    {
        if($this->willSend())
        {
            $emails = $this->getAdminsEmails();
            if(count($emails) > 0)
            {
                $reminder = $this->buildEmail();
                $this->sendEmails($emails, $reminder);
                // $reminder = (object)[
                //     "month" => "July",
                //     "salaries_payment_day" =>  30,
                //     "bonus_payment_day" =>  15,
                //     "salaries_total" =>  "$20000",
                //     "bonus_total" =>  "$2000",
                //     "payments_total" =>  "$22000"
                // ];
            }
        }
    }

    protected function willSend(): bool
    {
        $date = Carbon::now();
        $month = $date->format('F');
        // return  $date->dayOfWeek; // 0 (for Sunday) through 6 (for Saturday)
        // return $date->daysInMonth; // number of days in the given month
        // return $date->isFriday();
        // return $date->isThursday();

        return false;
    }
    protected function getAdminsEmails(): array
    {
        return User::where('is_admin', 1)->select('email')->get();
    }

    protected function sendEmails(array $emails, ReminderInterface $reminder): void
    {
        Mail::to($emails)->send(new SalaryRemider($reminder));
    }
}
