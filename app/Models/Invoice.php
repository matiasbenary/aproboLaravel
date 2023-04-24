<?php

namespace App\Models;

use App\States\InvoiceState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

/**
 * App\Models\Invoice
 *
 * @method static \Database\Factories\InvoiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 *
 * @property int $id
 * @property int $user_id
 * @property int $contract_id
 * @property int $media_id
 * @property int $project_id
 * @property string $type
 * @property string $currency
 * @property int $amount
 * @property mixed $state
 * @property int $signatures
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contract[] $contracts
 * @property-read int|null $contracts_count
 * @property-read \App\Models\Media $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereSignatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUserId($value)
 *
 * @property int $consumer_id
 * @property int $supplier_id
 * @property string $responsible_email
 * @property string $message
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereConsumerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereResponsibleEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereSupplierId($value)
 *
 * @property-read \App\Models\Entity|null $consumer
 *
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory, HasStates;

    protected $fillable = [
        'consumer_id',
        'supplier_id',
        'user_id',
        'contract_id',
        'media_id',
        'project_id',
        'type',
        'amount',
        'state',
        'signatures',
        'responsible_email',
        'message',
        'currency',
    ];

    protected $casts = [
        'state' => InvoiceState::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function contracts()
    {
        return $this->belongsToMany(Contract::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Entity::class, 'id', 'consumer_id');
    }
}
