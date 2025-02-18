<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserCommand extends Command
{
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'user:create {name} {email} {password?}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Command to create users';

    public function handle()
    {

        if (!$this->argument('name') || !$this->argument('email')) {
            $this->error('The name and email fields are required.');
            return 1;
        }


        if (User::where('email', $this->argument('email'))->exists()) {
            $this->error('The email is already taken.');
            return 1;
        }

        if ($this->argument('name') && $this->argument('email')) {
            User::create(
                [
                    'name' => $this->argument('name'),
                    'email' => $this->argument('email'),
                    'password' => $this->argument('password') ?? Str::random(8)
                ]
            );
            $this->info("User created succesfully!!");
        }
    }
}
