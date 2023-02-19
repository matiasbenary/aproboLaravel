<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class HasPermissionMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($request->is_owner) {
            return $next($request);
        }

        $permissionId = Permission::where("name", $role)->first()->id;

        $checkPermission = DB::table("entity_permission_user")
            ->select("id")
            ->where("permission_id", $permissionId)
            ->where("entity_id", $request->header("entity-id"))
            ->where("user_id", auth()->payload()->get('sub'))
            ->first();
        if (!$checkPermission) {
            return response()->json(['status' => 'you do not have permissions'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
