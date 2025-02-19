<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});

it('email can be verified', function () {
    $user = User::factory()->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

it('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

it('redirects verified users to the dashboard', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('verification.notice'));

    $response->assertRedirect(route('dashboard'));
});

it('shows the email verification view to unverified users', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->actingAs($user)->get(route('verification.notice'));

    $response->assertStatus(200);
    $response->assertViewIs('auth.verify-email');
});

it('does not send verification email if the user is already verified', function () {

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    Notification::fake();
    $response = $this->actingAs($user)->post(route('verification.send'));
    Notification::assertNotSentTo($user, VerifyEmail::class);

    $response->assertRedirect(route('dashboard'));
});

it('sends verification email if the user is not verified', function () {

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    Notification::fake();
    $response = $this->actingAs($user)->post(route('verification.send'));
    Notification::assertSentTo($user, VerifyEmail::class);

    $response->assertRedirect()->assertSessionHas('status', 'verification-link-sent');
});


it('redirects verified user to the dashboard with verified query param', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $verificationUrl = URL::signedRoute('verification.verify', [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $response = $this->actingAs($user)->get($verificationUrl);

    $response->assertRedirect(route('dashboard', absolute: false) . '?verified=1');
});




