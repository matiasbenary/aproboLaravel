<?php

namespace App\Actions;

use App\Data\InvoiceCreateData;
use App\Models\Invoice;

class InvoiceCreateAction implements Actions
{
    public function __construct(public InvoiceCreateData $invoiceData)
    {
    }

    public function execute()
    {
        return Invoice::create($this->invoiceData->toArray());
    }
}
