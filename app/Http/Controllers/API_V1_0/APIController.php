<?php

namespace App\Http\Controllers\API_V1_0;

use App\Http\Controllers\Controller;
use App\Reminder\SalaryReminder;
use App\Reminder\BonusReminder;
use Carbon\Carbon;

class APIController extends Controller
{
    public function emails()
    {
        $reminder = new SalaryReminder;
        $reminder = new BonusReminder;
        return response()->json($reminder->handle());
    }
}
