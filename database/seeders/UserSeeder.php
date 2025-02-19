<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminUser = User::factory()->create([
            'name' => 'friendhub',
            'email' => 'friendhub@gmail.com',
            'password' => bcrypt('12345678'),
            'profile_photo' => './profile_images/friendhub.png',
        ]);
        $adminUser->assignRole('admin');

        $normalUser = User::factory(10)->create();
        $normalUser->assignRole('user');
    }
}
