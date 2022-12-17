<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::factory()->create([
            'user_id' => User::factory()->create([
                'name' => 'supplierExample',
                'email' => 'supplier@example.com',
                'is_root' => false,
                'is_supplier' => true,
            ]),
        ]);
    }
}
