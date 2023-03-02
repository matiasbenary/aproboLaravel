<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Suppliers
 *
 * @property int $consumer_id
 * @property int $supplier_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers query()
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereConsumerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suppliers whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Suppliers extends Model
{
    protected $fillable = [
        'consumer_id',
        'supplier_id'
    ];
}
