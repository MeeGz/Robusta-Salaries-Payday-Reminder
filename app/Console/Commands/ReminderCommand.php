<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\API_V1_0\APIController;
use Carbon\Carbon;
use App\Reminder\SalaryReminder;
use App\Reminder\BonusReminder;

class ReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending reminding emails to admins';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(Carbon::now()->day > 15)
            $reminder = new SalaryReminder;
        else
            $reminder = new BonusReminder;
        $reminder->handle();
    }
}
