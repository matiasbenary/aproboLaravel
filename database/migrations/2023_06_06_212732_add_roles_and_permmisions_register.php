<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $role = Role::create(['name' => 'super-admin']);
        // create permissions
        Permission::create(['name' => 'show client invoices']);
        Permission::create(['name' => 'edit client invoices']);
        Permission::create(['name' => 'create client invoices']);

        Permission::create(['name' => 'show supplier invoices']);
        Permission::create(['name' => 'edit supplier invoices']);
        Permission::create(['name' => 'create supplier invoices']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'admin']);
        $role->permissions()->syncWithoutDetaching(Permission::all());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
