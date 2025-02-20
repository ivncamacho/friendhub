<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
});

it('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

it('new users can register', function () {

    $response = $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = User::where('email', 'test@example.com')->first();
    $this->actingAs($user);
    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

it('returns the register view when creating a new user', function () {
    $response = $this->get(route('register'));
    $response->assertStatus(200);
    $response->assertViewIs('my-auth.register');
});
