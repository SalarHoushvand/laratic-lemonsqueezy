<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('auth pages redirect to login when not authenticated', function ($route) {
    $response = $this->get($route);

    $response->assertRedirect(route('login'));
})->with([
    '/dashboard',
    '/settings',
    '/settings/profile',
    '/plans/start',
    '/subscription/status',
    '/products',
    '/orders',
    '/transactions',
    '/ai-chat',
    '/ai-simple',
]);

test('auth pages are accessible when authenticated', function ($route) {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'two_factor_enabled' => false,
    ]);
    $user->assignRole('user');

    $response = $this->actingAs($user)->get($route);

    $response->assertStatus(200);
})->with([
    '/dashboard',
    '/settings',
    '/settings/profile',
    '/subscription/status',
    '/products',
    '/orders',
    '/transactions',
    '/ai-chat',
    '/ai-simple',
]);

