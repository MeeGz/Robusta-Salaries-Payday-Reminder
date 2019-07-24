<?php

namespace App\Traits;
use Carbon\Carbon;

trait GetDays
{
    public function getBonusDay(Carbon $date)
    {
        $day = Carbon::parse('15th ' . $date->format('M'));
        if($day->isFriday())
            $payday = $day->day - 1;
        else if($day->isSaturday())
            $payday = $day->day - 2;
        else
            $payday = $day->day;
        return $payday;
    }

    public function getSalaryDay(Carbon $date)
    {
        $day = $date->endOfMonth();
        if($day->isFriday())
            $payday = $day->day - 1;
        else if($day->isSaturday())
            $payday = $day->day - 2;
        else
            $payday = $day->day;
        return $payday;
    }
}