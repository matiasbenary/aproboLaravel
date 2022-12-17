<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Entity;
use App\Models\Supplier;
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
        $admin = User::factory()
            ->hasAttached($entity, [
                'is_owner' => true,
                'is_supplier' => false,
                'is_admin' => true,
            ])->create([
                'is_supplier' => false,
                'is_root' => false,
            ]);

        $users = User::factory(10)
            ->hasAttached($entity, [
                'is_owner' => true,
                'is_supplier' => false,
                'is_admin' => false,
            ])->create([
                'is_supplier' => false,
                'is_root' => false,
            ]);

        Supplier::factory()->create([
            'user_id' => User::factory()
                ->hasAttached($entity, [
                    'is_owner' => false,
                    'is_supplier' => false,
                    'is_admin' => true,
                ])->create([
                    'name' => 'supplierExample',
                    'email' => 'supplier@example.com',
                    'is_supplier' => false,
                    'is_root' => true,
                ]),
        ]);
    }
}
