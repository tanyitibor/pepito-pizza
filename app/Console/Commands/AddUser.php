<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user {userName?} {email?} {password?} {phoneNumber?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new user.';

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
        //
        $userName = $this->argument('userName') ?: $this->ask('Username');
        $email = $this->argument('email') ?: $this->ask('Email');
        $password = $this->argument('password') ?: $this->secret('Password');
        $phoneNumber = $this->argument('phoneNumber');
        if(!$phoneNumber) {
            $phoneNumber = $this->ask('Phone number("Enter 1 to set a base value")');
            $phoneNumber = $phoneNumber == 1 ? '06123456789' : $phoneNumber;
        }

        \App\User::insert([
            'user_name'     => $userName,
            'email'         => $email,
            'password'      => bcrypt($password),
            'phone_number'  => $phoneNumber,
        ]);

        $this->info("User $userName has been created!");
    }
}
