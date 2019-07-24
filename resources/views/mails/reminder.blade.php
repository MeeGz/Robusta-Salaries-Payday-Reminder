<p>Hello All,</p>
<p>This is a reminder for Payday of <span style="font-weight: bold">{{$reminder->month}}</span> for @if($reminder instanceof App\Reminder\SalaryReminder) Salaries @else Bonus @endif </p>
@if($reminder instanceof App\Reminder\SalaryReminder)
    @if(isset($reminder->salaries_payment_day))
        <p>Salaries_payment_day: <span style="font-weight: bold">{{$reminder->salaries_payment_day}}</span></p>
    @endif
    @if(isset($reminder->salaries_total))
        <p>Salaries_total: <span style="font-weight: bold">{{$reminder->salaries_total}}</span></p>
    @endif
@else
    @if(isset($reminder->bonus_payment_day))
        <p>Bonus_payment_day: <span style="font-weight: bold">{{$reminder->bonus_payment_day}}</span></p>
    @endif

    @if(isset($reminder->bonus_total))
        <p>Bonus_total: <span style="font-weight: bold">{{$reminder->bonus_total}}</span></p>
    @endif
@endif
<p>Thanks,<br>Mohamed Magdy</p>