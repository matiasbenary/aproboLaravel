<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ConsumerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.verify', 'entity.header', 'check.role:admin']);
    }

    public function index(Request $request)
    {
        $entityId = $request->header('entity-id');

        $consumer = Entity::whereHas('suppliers', function (Builder $query) use ($entityId) {
            $query->where('supplier_id', $entityId);
        })
            ->with('projects')
            ->get();
        // info($consumer->toArray());
        // info(Entity::with('projects', 'suppliers', 'consumers.projects')->get()->toArray());

        return response()->json(['data' => compact('consumer')]);
    }
}
