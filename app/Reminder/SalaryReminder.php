<?php

namespace App\Reminder;

use App\Payment;
use Carbon\Carbon;

class SalaryReminder extends Reminder
{
    public $salaries_payment_day;
    public $salaries_total;

    public function handle(): void
    {
        $now = Carbon::now();
        $day = $this->getSalaryDay($now);
        if($this->willSend($day))
        {
            $this->setReminder($day);
            $this->store();
            if(count($this->emails) > 0)
                $this->sendEmails($this->emails, $this);
        }
    }

    public function setReminder(int $day): void
    {
        $now = Carbon::now();
        $this->emails = $this->getAdminsEmails();
        $this->month = $now->format('F');
        $this->year = $now->year;
        $this->salaries_payment_day = $day;
        $this->salaries_total = $this->calculateSalaries();
        $this->bonus_total = $this->calculateBonus();
        $this->bonus_payment_day = $this->getBonusDay($now);
    }

    public function store(): void
    {
        Payment::create((array)$this);
    }
}
