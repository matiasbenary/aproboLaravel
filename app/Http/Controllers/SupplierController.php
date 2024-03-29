<?php

namespace App\Http\Controllers;

use App\Actions\Entity\CreateEntityAction;
use App\Data\Entity\CreateEntityData;
use App\Data\Supplier\InviteEmailSupllierData;
use App\Mail\SendInvitationSupplier;
use App\Models\Entity;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mail;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.verify', 'entity.header', 'check.role:admin']);
    }

    public function index(Request $request)
    {
        $entityId = $request->header('entity-id');

        $supplier = Entity::whereHas('consumers', function (Builder $query) use ($entityId) {
            $query->where('consumer_id', $entityId);
        })->get();

        return response()->json(['data' => compact('supplier')]);
    }

    public function store(Request $request)
    {
        $consumerId = $request->header('entity-id');
        $entityAction = new CreateEntityAction(CreateEntityData::from($request->all()));
        $supplier = $entityAction->execute();

        Supplier::firstOrCreate(['consumer_id' => $consumerId, 'supplier_id' => $supplier->id]);

        return response()->json(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    public function sendInvitation(InviteEmailSupllierData $supplier)
    {
        $entity = getEntity();
        Mail::to($supplier->email)->send(new SendInvitationSupplier($entity));

        return response()->json(['message' => 'Invitation sent successfully']);
    }
}
