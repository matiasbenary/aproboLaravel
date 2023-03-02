<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Project
 *
 * @method static \Database\Factories\ProjectFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @property int $id
 * @property string $name
 * @property int $entity_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entity $entity
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @property int $payment_order
 * @property int $execution_process
 * @property int $purchase_order
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereExecutionProcess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project wherePaymentOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project wherePurchaseOrder($value)
 * @mixin \Eloquent
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'entity_id',
        'payment_order',
        'execution_process',
        'purchase_order',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
}
