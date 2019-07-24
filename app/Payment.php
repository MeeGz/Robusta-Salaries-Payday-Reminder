<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetDays;
use App\Traits\GetTotals;
use Carbon\Carbon;

class Payment extends Model
{
    use GetDays, GetTotals;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month', 'year', 'salaries_total', 'salaries_payment_day', 'bonus_total', 'bonus_payment_day',
    ];

    // disable timestamps
    public $timestamps = false;

    protected $appends = [
        'payments_total'
    ];

    public function getPaymentsTotalAttribute()
    {
        return $this->salaries_total + $this->bonus_total;
    }

    public function getRemainderMonths($payments, $now, $all = false)
    {
        if($all)
            $i = 0;
        else
            $i = $now->month;
        if(count($payments) > 0)
        {
            $last_month = $payments[count($payments)-1]->month;
            $i = Carbon::parse($last_month)->month + 1;
        }
        $total_salaries = $this->calculateSalaries();
        $total_bonus = $this->calculateBonus();
        for (; $i <= 12; $i++) {
            $date = Carbon::createFromDate($now->year, $i);
            $payments[] = (object)[
                "month" => $date->format('F'),
                "salaries_total" => $total_salaries,
                "salaries_payment_day" => $this->getBonusDay($date),
                "bonus_total" => $total_bonus,
                "bonus_payment_day" => $this->getSalaryDay($date),
                "payments_total" => $total_salaries + $total_bonus
            ];
        }
        return $payments;
    }

}
