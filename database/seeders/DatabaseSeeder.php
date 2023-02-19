<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Entity;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(UserSeeder::class);
        // $this->call(SupplierSeeder::class);
        // $this->call(EntitySeeder::class);

        $entity = Entity::factory()->create();

        Project::factory()->count(3)->for($entity)->create();
        // info($entity->toArray());
        $admin = User::factory()
            ->hasAttached($entity, [
                'is_owner' => true,
            ])->create([
                'is_root' => false,
            ]);

        $users = User::factory(10)
            ->hasAttached($entity, [
                'is_owner' => false,
            ])->create([
                'is_root' => false,
            ]);

        $this->call(PermissionSeeder::class);
    }
}
