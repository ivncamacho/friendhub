<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
public function run()
{
    User::factory()->create([
        'name' => 'friendhub',
        'email' => 'friendhub@gmail.com',
        'password' => bcrypt('12345678'),
        'role' => 'admin',
        'profile_photo' => './profile_images/friendhub.png',
    ]);
    User::factory(10)->create();
}
}
