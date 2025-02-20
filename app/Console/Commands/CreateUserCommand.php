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
        protected $signature = 'user:create';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Command to create users';

    public function handle()
    {
        $name = $this->ask('Escribe el nombre de usuario');
        $email = $this->ask('Escribe el correo electronico');
        $password = $this->secret('Escribe la contraseña');

        if (User::where('name', $name)->exists()){
            $this->error('The name is already taken.');
            return 1;
        }
        if (User::where('email', $email)->exists()) {
            $this->error('The email is registered.');
            return 1;
        }
            User::create(
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password
                ]
            );
            $this->info("User created succesfully!!");
    }
}
