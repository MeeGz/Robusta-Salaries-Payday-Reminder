<?php

namespace App\Reminder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Payment;

class BonusReminder extends Reminder
{
    public function handle(): void
    {
        $now = Carbon::now();
        $day = $this->getBonusDay($now);
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
        if($payment)
        {
            $this->month = $now->format('F');
            $this->bonus_payment_day = $day;
            $this->emails = $this->getAdminsEmails();
            $this->bonus_total = $payment->bonus_total;
        }
    }
}
