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

    public function getRemainderMonths($payments, $now)
    {
        $i = 0;
        if(count($payments) > 0)
        {
            $last_month = $payments[count($payments)-1]->month;
            $i = Carbon::parse($last_month)->month;
        }
        $total_salaries = $this->calculateSalaries();
        $total_bonus = $this->calculateBonus();
        for ($i++; $i <= 12; $i++) {
            $payments[] = (object)[
                "month" => Carbon::createFromDate($now->year, $i)->format('F'),
                "salaries_total" => $total_salaries,
                "salaries_payment_day" => 31,
                "bonus_total" => $total_bonus,
                "bonus_payment_day" => 15,
                "payments_total" => $total_salaries + $total_bonus
            ];
        }
        return $payments;
    }

}
