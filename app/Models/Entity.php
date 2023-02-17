<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Entity
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 *
 * @method static \Database\Factories\EntityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property string $business_name
 * @property string $fantasy_name
 * @property string $email
 * @property int|null $cuit
 * @property int|null $cbu
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereCbu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereFantasyName($value)
 */
class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'cbu',
        'cuit',
        'business_name',
        'fantasy_name',
        'email',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('is_owner');
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'suppliers', 'consumer_id', 'supplier_id');
    }

    public function consumers(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'suppliers', 'supplier_id', 'consumer_id');
    }
}
