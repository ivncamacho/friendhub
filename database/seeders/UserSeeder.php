<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
public function run()
{
    User::factory()->create([
        'name' => 'Ivan',
        'email' => 'ivan@gmail.com',
        'password' => bcrypt('12345678'),
        'role' => 'admin',
    ]);
    User::factory(10)->create();
}
}
