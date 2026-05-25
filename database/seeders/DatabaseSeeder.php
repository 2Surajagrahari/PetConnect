<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Create Shelter
        $shelter = User::create([
            'name' => 'Happy Paws Shelter',
            'email' => 'shelter@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'shelter'
        ]);

        // Create Regular User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);

        // Create Pets
        $pet1 = Pet::create([
            'name' => 'Bella',
            'age' => 2,
            'breed' => 'Golden Retriever',
            'gender' => 'Female',
            'vaccination_status' => 'Up to date',
            'health_condition' => 'Healthy',
            'size' => 'Large',
            'color' => 'Golden',
            'description' => 'Bella is a very friendly and energetic dog. She loves playing fetch and gets along great with children.',
            'status' => 'available',
            'location' => 'Downtown Shelter',
            'user_id' => $shelter->id
        ]);

        $pet2 = Pet::create([
            'name' => 'Luna',
            'age' => 1,
            'breed' => 'Siamese Cat',
            'gender' => 'Female',
            'vaccination_status' => 'Up to date',
            'health_condition' => 'Healthy',
            'size' => 'Small',
            'color' => 'White and Black',
            'description' => 'Luna is a quiet and affectionate cat. She enjoys lounging by the window in the sun.',
            'status' => 'available',
            'location' => 'Downtown Shelter',
            'user_id' => $shelter->id
        ]);
        
        $pet3 = Pet::create([
            'name' => 'Max',
            'age' => 4,
            'breed' => 'Beagle',
            'gender' => 'Male',
            'vaccination_status' => 'Requires booster',
            'health_condition' => 'Minor allergies',
            'size' => 'Medium',
            'color' => 'Tricolor',
            'description' => 'Max loves sniffing around and going for long walks. He needs an active family.',
            'status' => 'available',
            'location' => 'Downtown Shelter',
            'user_id' => $shelter->id
        ]);
    }
}
