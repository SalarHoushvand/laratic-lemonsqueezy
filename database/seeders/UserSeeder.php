<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $userCount = 100, bool $createAdmin = true): void
    {
        $password = Hash::make('password');

        // Create admin user
        if ($createAdmin) {
            $admin = User::create([
                'name' => 'Admin Boss',
                'email' => 'admin@email.com',
                'password' => $password,
                'email_verified_at' => now(),
                'avatar' => '/images/avatars/avatar-admin.webp',
                'phone' => '1234567890',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'street' => '123 Admin Street',
                'zip' => '10001',
                'timezone' => 'America/New_York',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $admin->assignRole('admin');
        }

        $avatars = collect([
            '/images/avatars/avatar-1.webp',
            '/images/avatars/avatar-2.webp',
            '/images/avatars/avatar-3.webp',
            '/images/avatars/avatar-4.webp',
            '/images/avatars/avatar-5.webp',
            '/images/avatars/avatar-6.webp',
            '/images/avatars/avatar-7.webp',
            '/images/avatars/avatar-8.webp',
            '/images/avatars/avatar-9.webp',
            '/images/avatars/avatar-10.webp',
            '/images/avatars/avatar-11.webp',
            '/images/avatars/avatar-12.webp',
        ]);

        $chunkSize = 500;
        $chunks = ceil($userCount / $chunkSize);
        $userRoleId = Role::where('name', 'user')->value('id');

        for ($chunk = 0; $chunk < $chunks; $chunk++) {
            $usersToCreate = min($chunkSize, $userCount - ($chunk * $chunkSize));
            $users = [];
            $roleAssignments = [];

            for ($i = 0; $i < $usersToCreate; $i++) {
                $createdAt = now()->subDays(rand(0, 480));
                $emailVerifiedAt = rand(0, 100) < 80 ? $createdAt->copy()->addDays(rand(0, 7)) : null;

                $users[] = [
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'password' => $password,
                    'email_verified_at' => $emailVerifiedAt,
                    'avatar' => rand(0, 100) < 60 ? $avatars->random() : null,
                    'phone' => rand(0, 100) < 70 ? fake()->numerify('##########') : null,
                    'country' => rand(0, 100) < 80 ? fake()->country() : null,
                    'city' => rand(0, 100) < 80 ? fake()->city() : null,
                    'state' => rand(0, 100) < 70 ? fake()->stateAbbr() : null,
                    'street' => rand(0, 100) < 70 ? fake()->streetAddress() : null,
                    'zip' => rand(0, 100) < 70 ? fake()->postcode() : null,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }

            // Bulk insert users for this chunk
            DB::table('users')->insert($users);

            // Get the IDs of users we just inserted
            $insertedUserIds = User::latest('id')->take($usersToCreate)->pluck('id');

            // Bulk assign roles
            if ($userRoleId && $insertedUserIds->isNotEmpty()) {
                foreach ($insertedUserIds as $userId) {
                    $roleAssignments[] = [
                        'role_id' => $userRoleId,
                        'model_type' => User::class,
                        'model_id' => $userId,
                    ];
                }

                DB::table('model_has_roles')->insert($roleAssignments);
            }

            if ($chunk < $chunks - 1) {
                $this->command->info('Created '.(($chunk + 1) * $chunkSize).' users...');
            }
        }

        $this->command->info('Total users created: '.$userCount.($createAdmin ? ' + 1 admin' : ''));
    }
}
