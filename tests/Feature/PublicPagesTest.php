<?php

use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('public pages return 200', function ($route) {
    $response = $this->get($route);

    $response->assertStatus(200);
})->with([
    '/',
    '/waitlist',
    '/request-demo',
    '/careers',
    '/about-us',
    '/contact',
    '/terms',
    '/privacy',
    '/pricing',
    '/blog',
]);

