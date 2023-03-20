<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Entity;
use App\Models\Invoice;
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

        // $consummer = Entity::factory()->create();

        // Project::factory()->count(3)->for($consummer)->create();
        // // info($entity->toArray());
        // $admin = User::factory()
        //     ->hasAttached($consummer, [
        //         'is_owner' => true,
        //     ])->create([
        //         'is_root' => false,
        //     ]);

        // $users = User::factory(10)
        //     ->hasAttached($consummer, [
        //         'is_owner' => false,
        //     ])->create([
        //         'is_root' => false,
        //     ]);

        // $supplier = Entity::factory()->create();

        // $admin = User::factory()
        //     ->hasAttached($supplier, [
        //         'is_owner' => true,
        //     ])->create([
        //         'is_root' => false,
        //     ]);

        $this->call(PermissionSeeder::class);
        // create a invoice
        // 'consumer_id',
        // 'supplier_id',
        // 'user_id',
        // 'contract_id',
        // 'media_id',
        // 'project_id',
        // 'type',
        // 'amount',
        // 'state',
        // 'signatures',
        // 'responsible_email',
        // 'message',
        // Invoice::create([
        //     "consumer_id" => 1,
        //     "supplier_id" => 2,
        //     "user_id" => 1,
        //     "project_id" => 1,
        //     "type" => "C",
        //     "amount" => 12345678,
        //     "currency" => "ARS",
        //     "responsible_email" => "test@test.com",
        //     "message" => "hola, soy un texto de ejemplo",
        // ]);
        // Invoice::create([
        //     "consumer_id" => 2,
        //     "supplier_id" => 1,
        //     "user_id" => 1,
        //     "project_id" => 1,
        //     "type" => "C",
        //     "amount" => 12345678,
        //     "currency" => "ARS",
        //     "responsible_email" => "testasd@test.com",
        //     "message" => "hola, soy un texto de ejemplo",
        // ]);
    }
}
