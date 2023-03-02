<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Supplier;
use App\Models\Suppliers;
use Dotenv\Parser\Entry;
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

        $supplier = Entity::whereHas("consumers", function (Builder $query) use ($entityId) {
            $query->where('consumer_id', $entityId);
        })->get();
        return response()->json(["data" => compact("supplier")]);
    }

    public function store(Request $request)
    {
        $consumerId = $request->header('entity-id');
        $supplier = Entity::firstOrCreate(["cuit" => $request->cuit], $request->except("cuit"));

        Suppliers::firstOrCreate(["consumer_id" => $consumerId, "supplier_id" => $supplier->id]);
        return response()->json(["message" => "Created successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
