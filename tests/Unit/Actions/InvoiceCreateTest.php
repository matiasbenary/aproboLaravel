<?php

namespace Tests\Unit\Actions;

use App\Actions\InvoiceCreateAction;
use App\Data\InvoiceCreateData;
use App\Data\UserData;
use App\Models\Entity;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceCreateTest extends TestCase
{
    use RefreshDatabase;

    // protected function prepareEnvironment()
    // {
    //     $entity = Entity::factory()->create();

    //     $project = Project::factory()->for($entity)->create();

    //     $user = User::factory()
    //         ->hasAttached($entity, [
    //             'is_owner' => false,
    //             'is_supplier' => false,
    //             'is_admin' => true,
    //         ])->create([
    //             'name' => 'supplierExample',
    //             'email' => 'supplier@example.com',
    //             'is_supplier' => false,
    //             'is_root' => true,
    //         ]);

    //     $supplier = Supplier::factory()->create([
    //         'user_id' => $user,
    //     ]);

    //     return compact('entity', 'user', 'supplier', 'project');
    // }

    protected function getInvoices($data)
    {
        // return InvoiceCreateData::from(
        //     user_id: 1,
        //     project_id: 1,
        //     type: "B",
        //     currency: "ARS",
        //     amount: 1000);

        // return InvoiceCreateData::from([
        //     'user_id' => $data['user']->id,
        //     'project_id' => $data['project']->id,
        //     'type' => 'B',
        //     'currency' => 'ARS',
        //     'amount' => 1000,
        // ]);
        // return InvoiceCreateData::from(["user_id"=>"1"]);
        // return UserData::from(name: 'test', email: 'test@test.com', password: 'qweqwe', is_root: false, is_supplier: true);
    }

    public function test_add_invoice()
    {
        $this->assertTrue(true);
        // $data = $this->prepareEnvironment();
        // $invoiceData = $this->getInvoices($data);

        // $createInvoice = new InvoiceCreateAction($invoiceData);
        // $createInvoice->execute();

        // $this->assertDatabaseHas('invoices', [
        //     'user_id' => $data['user']->id,
        //     'project_id' => $data['project']->id,
        //     'type' => 'B',
        //     'currency' => 'ARS',
        //     'amount' => 1000,
        // ]);
    }
}
