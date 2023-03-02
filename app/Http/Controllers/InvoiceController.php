<?php

namespace App\Http\Controllers;

use App\Actions\InvoiceCreateAction;
use App\Actions\MediaUploadAction;
use App\Data\InvoiceCreateData;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.verify', 'entity.header', 'hasPermission:invoice']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function consumer(Request $request)
    {
        $consumerId = $request->header('entity-id');
        $invoices = QueryBuilder::for(Invoice::where('consumer_id', $consumerId))
            ->allowedFilters(['name', 'email'])
            ->jsonPaginate();
        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreInvoiceRequest $request)
    {
        if ($request->has("file")) {
            $file = $request->file('file');
            $uploadFile = new MediaUploadAction();
            $media = $uploadFile->execute($file, "invoices");
            $invoiceData = InvoiceCreateData::from(array_merge($request->toArray(), ["media_id" => $media->id]));
        } else {
            $invoiceData = InvoiceCreateData::from($request->toArray());
        }

        $invoiceCreateAction = new InvoiceCreateAction($invoiceData);
        $invoiceCreateAction->execute();

        return response()->json(["message" => "Created successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
