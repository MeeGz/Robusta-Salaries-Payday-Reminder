Hello All,<br>
This is a reminder for Payday of <span style="font-weight: bold">{{$reminder->month}}</span> for @if($reminder instanceof App\Reminder\SalaryReminder) Salaries @else Bonus @endif <br>
@if(isset($reminder->salaries_payment_day))
    Salaries_payment_day: <span style="font-weight: bold">{{$reminder->salaries_payment_day}}</span><br>
@endif

@if(isset($reminder->bonus_payment_day))
    Bonus_payment_day: <span style="font-weight: bold">{{$reminder->bonus_payment_day}}</span><br>
@endif

@if(isset($reminder->salaries_total))
    Salaries_total: <span style="font-weight: bold">{{$reminder->salaries_total}}</span><br>
@endif

@if(isset($reminder->bonus_total))
    Bonus_total: <span style="font-weight: bold">{{$reminder->bonus_total}}</span><br>
@endif

@if(isset($reminder->payments_total))
    Payments_total: <span style="font-weight: bold">{{$reminder->payments_total}}</span><br><br>
@endif
Thanks,<br>
Mohamed Magdy