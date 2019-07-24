<?php

namespace App\Reminder;

use Carbon\Carbon;
use App\Payment;

class BonusReminder extends Reminder
{
    public function handle(): void
    {
        $prev_month = Carbon::now()->subMonth();
        $day = $this->getBonusDay($prev_month);
        if($this->willSend($day))
        {
            $this->setReminder($day);
            if(count($this->emails) > 0)
                $this->sendEmails($this->emails, $this);
        }
    }

    public function setReminder($day): void
    {
        $now = Carbon::now();
        $payment = Payment::where('month', $now->subMonth()->month)->where('year', $now->year)->first();
        $this->month = $now->format('F');
        $this->bonus_payment_day = $day;
        $this->emails = $this->getAdminsEmails();
        if($payment)
            $this->bonus_total = $payment->bonus_total;
        else 
            $this->bonus_total = $this->calculateBonus();
    }
}
