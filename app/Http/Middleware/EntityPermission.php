<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntityPermission
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->hasHeader('entity-id')) {
            return response()->json(['status' => 'the Entity-Id is missing in the header'], Response::HTTP_UNAUTHORIZED);
        }

        $checkPermission = DB::table('entity_user')
            ->select('is_owner')
            ->where('entity_id', $request->header('entity-id'))
            ->where('user_id', auth()->payload()->get('sub'))
            ->first();

        if (! $checkPermission) {
            return response()->json(['status' => 'you do not have permissions'], Response::HTTP_UNAUTHORIZED);
        }

        $request->is_owner = $checkPermission->is_owner;

        return $next($request);
    }
}
