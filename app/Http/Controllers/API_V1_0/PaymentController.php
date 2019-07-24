<?php

namespace App\Http\Controllers\API_V1_0;

use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();
        return $payment = Payment::where('year', $now->year)->select("month", "salaries_total", "salaries_payment_day", "bonus_total", "bonus_payment_day")->get();
    }

}
