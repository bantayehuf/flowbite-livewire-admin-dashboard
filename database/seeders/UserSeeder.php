<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Bantayehu Fikadu',
            'email' => 'bantayehuf@gmail.com',
            'password' => Hash::make('12345678'),
            'department' => 1,
            'created_by' => 1,
        ]);

        Department::create([
            'id' => 1,
            'name' => "Central Office",
            'created_by' => 1,
        ]);
    }
}
