<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entity::factory()->hasAttached(
            User::factory(10)->create([
                'is_supplier' => false,
                'is_root' => false,
            ]),
            [
                'is_owner' => true,
                'is_supplier' => false,
                'is_admin' => false,
            ]
        )->create();
    }
}
