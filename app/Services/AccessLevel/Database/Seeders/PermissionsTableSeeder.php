<?php

namespace App\Services\AccessLevel\Database\Seeders;

use App\Services\AccessLevel\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        Permission::insert([
            ['title' => 'admin-panel-viewer', 'description' => 'can just view admin panel!! BUT WE DONT HAVE ADMIN PANEL HERE :D'],
            ['title' => 'creates-task', 'description' => 'can create task!'],
            ['title' => 'updates-task', 'description' => 'can update task!'],
            ['title' => 'deletes-task', 'description' => 'can delete task!'],
            ['title' => 'changes-task-status', 'description' => 'can change task status!'],
        ]);
    }
}
