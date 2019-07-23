<?php

namespace App\Http\Controllers\API_V1_0;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;

class APIController extends Controller
{
    static public function sendEmails()
    {
        $emails = User::whereHas('admin')->select('email')->get();
        $date = Carbon::now();
        $month = $date->format('F');
        // return  $date->dayOfWeek; // 0 (for Sunday) through 6 (for Saturday)
        // return $date->daysInMonth; // number of days in the given month
        // return $date->isFriday();
        // return $date->isThursday();
        $reminder = (object)[
            "month" => $month,
            "salaries_payment_day" =>  30,
            "bonus_payment_day" =>  15,
            "salaries_total" =>  "$20000",
            "bonus_total" =>  "$2000",
            "payments_total" =>  "$22000"
        ];
        Mail::to($emails)->send(new ReminderMail($reminder));
        return response()->json(null, 200);
    }}
