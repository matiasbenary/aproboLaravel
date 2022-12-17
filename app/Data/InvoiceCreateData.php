<?php

namespace App\Data;

use App\States\InvoiceState;
use Spatie\LaravelData\Data;

class InvoiceCreateData extends Data
{
    public function __construct(
        public int $user_id,
        public int $project_id,
        public ?int $contract_id,
        public ?int $media_id,
        public string $type,
        public string $currency,
        public int $amount,
        public ?InvoiceState $state
    ) {
    }
}

// $table->foreignId('user_id')->constrained();
// $table->foreignId('contract_id')->constrained()->nullable();
// $table->foreignId('media_id')->constrained()->nullable();
// $table->foreignId('project_id')->constrained();
// $table->enum('type', ["B", "C", "Nota de crédito"]);
// $table->enum('currency', ["ARS", "USD", "MX", "COP", "Otro"]);
// $table->unsignedBigInteger('amount');
