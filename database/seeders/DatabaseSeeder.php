<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Service;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'example@email.com'
        ]);

        $role = Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'user']);

        $user->assignRole($role);
    }
}
