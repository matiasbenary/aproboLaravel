<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Supplier
 *
 * @property-read \App\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @mixin \Eloquent
 *
 * @property int $id
 * @property int $user_id
 * @property string $business_name
 * @property int $ciut_cuil
 * @property int $cbu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\SupplierFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCbu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCiutCuil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUserId($value)
 */
class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'ciut_cuil',
        'cbu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
