<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

uses(RefreshDatabase::class);

it('renders the login view', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertViewIs('my-auth.login');
});


it('users can authenticate using the login screen', function () {
    $user = User::factory()->create([
        'password' => '12345678',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => '12345678',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('dashboard'));
});

it('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

it('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $this->assertGuest();
    $response->assertRedirect('/');
});


it('session is regenerated on login', function () {
    Session::start();

    $user = User::factory()->create([
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]);

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
    $this->assertNotEmpty(session()->getId());
    $response->assertRedirect(route('dashboard'));
});
