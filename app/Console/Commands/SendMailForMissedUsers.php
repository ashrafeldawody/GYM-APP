<?php

namespace App\Console\Commands;

use App\Mail\WeMissYou;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class SendMailForMissedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users-not-logged-in-for-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send an email notification to users who didn’t log in from the
    past month';

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
     * @return int
     */
    public function handle()
    {
        $missedUsers = User::where('last_login','<',\Carbon\Carbon::today()->subDays(30))->get();
        // Notification::send($missedUsers,new WeMissYou($missedUsers));
        // $test = User::find(107);

        foreach ($missedUsers as $missedUser){
            Mail::to($missedUser)->send(new WeMissYou($missedUser));
        }

        // return 0;
    }
}
