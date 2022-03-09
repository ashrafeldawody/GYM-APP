<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Purchase;

class removeUnwantedPurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:unwanted-purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'will delete purchases that have "is_paid=0" from the database';

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
        Purchase::where('is_paid',0)->delete();
    }
}
