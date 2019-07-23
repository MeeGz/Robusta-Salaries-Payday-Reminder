<?php

namespace App\Http\Controllers\API_V1_0;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;
use App\Reminder\Reminder;
use App\Reminder\SalaryReminder;
use App\Reminder\BonusReminder;

class APIController extends Controller
{
    static public function sendEmails()
    {
        // $response = [];
        // $response['will_send'] = Reminder::willSend();
        // $response['emails'] = User::whereHas('admin')->select('email')->get();

        $reminder = new BonusReminder;

        // if(Carbon::now()->day > 15)
        //     $reminder = new SalaryReminder;
        // else
        //     $reminder = new BonusReminder;

        return response()->json($reminder->handle());
    }}
