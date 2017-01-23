<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:permissions {userName} {permissions*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permissions to a user.';

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
        $userName = $this->argument('userName');

        $user = \App\User::where('user_name', $userName)
            ->first();

        if(!$user) {
            $this->error("There is no user by name $userName");
        }

        $update = array_reduce($this->argument('permissions'),
            function($result, $permission) {
                $result[$permission] = 1;
                return $result;
            }
        );

        if($user->isEmployee()) {
			$user->permission()
				->first()
				->update($update);
		} else {
			$user->permission()
				->save(
					new \App\Permission($update)	
				);
		}

        $this->info('User permissions has been updated.');
    }
}
