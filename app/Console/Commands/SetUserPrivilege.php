<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SetUserPrivilege extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:privilage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting power of privilege for user account';

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
        $this->info('Setting privilege for user account');
        $email = $this->ask('Enter account email');
        $power = $this->ask('Enter privilage power');

        if ($this->confirm('Do you wish to continue?')) {
            $u = User::where('email', $email)->firstOrFail();
            $u->privilege = $power;
            $u->save();
            return $this->info('Successfully set privilege ('.$power.') for '.$email);
        }
        return $this->error('Something went wrong!');
    }
}
