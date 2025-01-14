<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('asdfasdf'),
            'avatar' => 'avatars/cat_shades.jpg',
            'role' => 'admin',
        ]);
        User::factory(50)->create();

        $this->call([
            VenueSeeder::class,
            SpeakerSeeder::class,
            DepartmentSeeder::class,
            EventSeeder::class,
            RegistrationSeeder::class,
            FeedbackSeeder::class,
        ]);
    }
}
