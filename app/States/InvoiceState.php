<?php

namespace App\States;

use App\States\InvoiceState\Cancelled;
use App\States\InvoiceState\Completed;
use App\States\InvoiceState\ExecutionProcess;
use App\States\InvoiceState\PaymentOrder;
use App\States\InvoiceState\PurchaseOrder;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

class InvoiceState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(PurchaseOrder::class)
            ->allowTransition(PurchaseOrder::class, ExecutionProcess::class)
            ->allowTransition(PurchaseOrder::class, Cancelled::class)
            ->allowTransition(ExecutionProcess::class, PaymentOrder::class)
            ->allowTransition(ExecutionProcess::class, Cancelled::class)
            ->allowTransition(PaymentOrder::class, Completed::class)
            ->allowTransition(PaymentOrder::class, Cancelled::class)
            ->registerState([
                PurchaseOrder::class,
                ExecutionProcess::class,
                PaymentOrder::class,
                Completed::class,
                Cancelled::class,
            ]);
    }
}
