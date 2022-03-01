<?php

namespace App\Console\Commands;

use App\Models\TrainingPackage;
use App\Models\Manager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {email} {password}';
    public $input = ['email','password'];
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to create admin account';

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
        $this->info('Creating Admin Account...');

        if(Manager::where('email',$this->argument('email'))->exists()){
            $this->error('Email already exists...');
            return 0;
        }

        $user = Manager::create([
            'name' => 'System Administrator',
            'password' => Hash::make($this->argument('password')),
            'email' => $this->argument('email'),
        ]);
        $user->assignRole('admin');
        $this->info('Admin Account Created Successfully...');
    }
}
