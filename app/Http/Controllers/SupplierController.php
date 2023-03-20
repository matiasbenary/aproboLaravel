<?php

namespace App\Http\Controllers;

use App\Actions\EntityCreateAction;
use App\Data\EntityCreateData;
use App\Models\Entity;
use App\Models\Supplier;
use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.verify', 'entity.header', 'hasPermission:supplier']);
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
        $entityAction = new EntityCreateAction(EntityCreateData::from($request->all()));
        $supplier = $entityAction->execute();

        Suppliers::firstOrCreate(['consumer_id' => $consumerId, 'supplier_id' => $supplier->id]);
        info('check');
        info(Suppliers::all()->toArray());
        info($supplier->id);
        info($consumerId);
        info('created');

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
}
