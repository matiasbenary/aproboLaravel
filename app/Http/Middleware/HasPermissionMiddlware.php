<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HasPermissionMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($request->is_owner) {
            return $next($request);
        }

        $permissionId = $this->getPermissionId($role);
        $checkPermission = $this->checkPermission($permissionId, $request);

        if (!$checkPermission) {
            return response()->json(['status' => 'you do not have permissions'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    private function getPermissionId($role)
    {
        return Permission::where('name', $role)->first()->id;
    }

    private function checkPermission($permissionId, $request)
    {
        return DB::table('entity_permission_user')
            ->select('id')
            ->where('permission_id', $permissionId)
            ->where('entity_id', $request->header('entity-id'))
            ->where('user_id', auth()->payload()->get('sub'))
            ->first();
    }
}
