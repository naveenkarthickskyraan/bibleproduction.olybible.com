<?php
// app/Helpers/PermissionHelper.php

use Illuminate\Support\Facades\Auth;

if (!function_exists('has_permission')) {
    /**
     * Check if the authenticated admin has a specific permission
     *
     * @param string $module The module to check
     * @param string $permission The permission to check (read, create, update, delete)
     * @return bool
     */
    function has_permission($module, $permission)
    {
        $admin = Auth::guard('admin')->user();

        // SuperAdmin has all permissions
        if ($admin->role === 'SuperAdmin') {
            return true;
        }

        // Get allowed modules and permissions
        $allowedModules = explode('|', $admin->accountAccessModule);
        $allowedPermissions = json_decode($admin->accountAccessPrivilege);
        // Check if the module exists in the allowed modules
        if (!in_array($module, $allowedModules)) {
            return false;
        }
        // Check if the permission exists in the allowed permissions for the module
        if (!isset($allowedPermissions->$module)) {
            return false;
        }

        // Check if module and permission exist
        return in_array($module, $allowedModules) &&
               in_array($permission, $allowedPermissions->$module);
    }
}

if (!function_exists('has_module_access')) {
    /**
     * Check if the authenticated admin has access to a module (any permission)
     *
     * @param string $module The module to check
     * @return bool
     */
    function has_module_access($module)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->role === 'SuperAdmin') {
            return true;
        }

        $allowedModules = explode('|', $admin->accountAccessModule);
        return in_array($module, $allowedModules);
    }
}

if (!function_exists('has_any_permission')) {
    /**
     * Check if the authenticated admin has any of the specified permissions
     *
     * @param string $module The module to check
     * @param array $permissions Array of permissions to check
     * @return bool
     */
    function has_any_permission($module, array $permissions)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->role === 'SuperAdmin') {
            return true;
        }

        $allowedModules = explode('|', $admin->accountAccessModule);
        $allowedPermissions = explode('|', $admin->accountAccessPrivilege);

        if (!in_array($module, $allowedModules)) {
            return false;
        }

        foreach ($permissions as $permission) {
            if (in_array($permission, $allowedPermissions)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('has_all_permissions')) {
    /**
     * Check if the authenticated admin has all specified permissions
     *
     * @param string $module The module to check
     * @param array $permissions Array of permissions to check
     * @return bool
     */
    function has_all_permissions($module, array $permissions)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->role === 'SuperAdmin') {
            return true;
        }

        $allowedModules = explode('|', $admin->accountAccessModule);
        $allowedPermissions = explode('|', $admin->accountAccessPrivilege);

        if (!in_array($module, $allowedModules)) {
            return false;
        }

        foreach ($permissions as $permission) {
            if (!in_array($permission, $allowedPermissions)) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('get_admin_permissions')) {
    /**
     * Get all permissions for the authenticated admin
     *
     * @return array Array of permissions grouped by module
     */
    function get_admin_permissions()
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->role === 'SuperAdmin') {
            // Return all permissions for SuperAdmin
            return [
                'all_modules' => true,
                'all_permissions' => true
            ];
        }

        $modules = explode('|', $admin->accountAccessModule);
        $permissions = explode('|', $admin->accountAccessPrivilege);

        $result = [];
        foreach ($modules as $module) {
            $result[$module] = $permissions;
        }

        return $result;
    }
}
