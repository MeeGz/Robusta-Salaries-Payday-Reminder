<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;
use App\Employee;

trait GetTotals
{
    public function calculateSalaries(): float
    {
        return (float) Employee::sum('salary');
    }

    public function calculateBonus(): float
    {
        return (float)DB::table("employees")->select(DB::raw("SUM(salary*bonus_rate/100) AS bonus_total"))->first()->bonus_total;
    }

}