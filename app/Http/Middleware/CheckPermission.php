<?php
// app/Http/Middleware/CheckPermission.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, $module, $permission)
    {
        $admin = Auth::guard('admin')->user();

        // Super admin has all permissions
        if ($admin->role === 'SuperAdmin') {
            return $next($request);
        }

        $allowedModules = explode('|', $admin->accountAccessModule);
        $allowedPermissions = explode('|', $admin->accountAccessPrivilege);

        // Check if admin has access to this module and permission
        if (in_array($module, $allowedModules) && in_array($permission, $allowedPermissions)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
