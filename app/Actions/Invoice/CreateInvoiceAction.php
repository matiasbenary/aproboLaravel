<?php

namespace App\Actions\Invoice;

use App\Data\Invoice\CreateInvoiceData;
use App\Models\Invoice;

class CreateInvoiceAction
{
    public function __construct(public CreateInvoiceData $invoiceData)
    {
    }

    public function execute()
    {
        return Invoice::create($this->invoiceData->toArray());
    }
}
