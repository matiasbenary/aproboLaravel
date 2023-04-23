<?php

namespace App\Data\Project;

use Spatie\LaravelData\Data;

class CreateProjectData extends Data
{
    public function __construct(
        public string $name,
        public int $payment_order,
        public int $execution_process,
        public int $purchase_order,
        public int $entity_id
    ) {
    }

    public static function fromArray(
        array $data
    ): self {
        return new self($data['name'], $data['payment_order'], $data['execution_process'], $data['purchase_order'], $data['entity_id']);
    }
}
