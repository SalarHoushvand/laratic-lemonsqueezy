<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('admin pages redirect to login when not authenticated', function ($route) {
    $response = $this->get($route);

    $response->assertRedirect(route('login'));
})->with([
    '/admin',
    '/admin/users',
    '/admin/orders',
    '/admin/subscription-invoices',
    '/admin/ai-usage',
    '/admin/files/upload',
    '/admin/posts',
]);

test('admin pages redirect when authenticated but not admin', function ($route) {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'two_factor_enabled' => false,
    ]);
    $user->assignRole('user');

    $response = $this->actingAs($user)->get($route);

    $response->assertForbidden();
})->with([
    '/admin',
    '/admin/users',
    '/admin/orders',
    '/admin/subscription-invoices',
    '/admin/ai-usage',
    '/admin/files/upload',
    '/admin/posts',
]);

test('admin pages are accessible when authenticated as admin', function ($route) {
    $admin = User::factory()->create([
        'email_verified_at' => now(),
        'two_factor_enabled' => false,
    ]);
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get($route);

    $response->assertStatus(200);
})->with([
    '/admin',
    '/admin/users',
    '/admin/orders',
    '/admin/subscription-invoices',
    '/admin/ai-usage',
    '/admin/files/upload',
    '/admin/posts',
]);

