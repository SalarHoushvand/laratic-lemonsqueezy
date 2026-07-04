<?php

use App\Livewire\Admin\FileUpload;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RoleSeeder::class);

    Storage::fake('s3');
});

test('file upload component stores files on s3 and returns a public url', function () {
    $admin = User::factory()->create([
        'email_verified_at' => now(),
        'two_factor_enabled' => false,
    ]);
    $admin->assignRole('admin');

    $file = UploadedFile::fake()->image('cover.jpg');

    Livewire::actingAs($admin)
        ->test(FileUpload::class)
        ->upload('uploadedFile', [$file])
        ->assertSet('fileUrl', fn (string $url) => str_contains($url, 'uploads/'))
        ->assertHasNoErrors();

    expect(Storage::disk('s3')->allFiles('uploads'))->not->toBeEmpty();
});

test('livewire temporary uploads use the local disk even when the default disk is s3', function () {
    Config::set('filesystems.default', 's3');

    expect(config('livewire.temporary_file_upload.disk'))->toBe('local');
});
