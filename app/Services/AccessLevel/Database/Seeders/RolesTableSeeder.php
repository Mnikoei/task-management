<?php

namespace App\Services\AccessLevel\Database\Seeders;

use App\Services\AccessLevel\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['title' => 'admin', 'description' => 'Has all permissions!'],
            ['title' => 'user', 'description' => 'Limited permissions for just working with tasks!'],
        ]);
    }
}
