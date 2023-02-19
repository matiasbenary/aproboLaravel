<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(["name" => "project", "description" => "CRUD project"]);
        Permission::create(["name" => "supplier", "description" => "CRUD supplier"]);
        Permission::create(["name" => "invoice", "description" => "CRUD invoice"]);
    }
}
