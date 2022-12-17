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
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory, HasStates;

    protected $fillable = [
        'user_id',
        'contract_id',
        'media_id',
        'project_id',
        'type',
        'amount',
        'state',
        'signatures',
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
}
