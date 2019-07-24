<?php

namespace App\Http\Controllers\API_V1_0;

use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource for this year.
     *
     * @return \Illuminate\Http\Response
     */
    public function yearPayments()
    {
        $payments = $this->handleYearPayments(true);
        return response()->json($payments, 200);
    }

    /**
     * Display a listing of the resource for stored and remainder for this year.
     *
     * @return \Illuminate\Http\Response
     */
    public function yearRemainder()
    {
        $payments = $this->handleYearPayments();
        return response()->json($payments, 200);
    }

    public function handleYearPayments($all = false)
    {
        $now = Carbon::now();
        $model = new Payment;
        if($all)
            $payments = Payment::where('year', $now->year)->select("month", "salaries_total", "salaries_payment_day", "bonus_total", "bonus_payment_day")->get();
        else
            $payments = [];
        return $payments = $model->getRemainderMonths($payments, $now, $all);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::select("month", "salaries_total", "salaries_payment_day", "bonus_total", "bonus_payment_day")->get();
        return response()->json($payments, 200);
    }
}
