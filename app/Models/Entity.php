<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('is_owner', 'is_supplier', 'is_admin');
    }
}
