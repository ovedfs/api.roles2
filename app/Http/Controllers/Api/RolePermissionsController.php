<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RolePermissionsController extends Controller
{
    public function show(Role $role)
    {
        $permissions = Permission::all();

        return response()->json([
            'message' => 'Rol y sus permisos',
            'role' => $role->load('permissions'),
            'permissions' => $permissions
        ]);
    }

    public function sync(Request $request, Role $role)
    {
        $permissions = Permission::all();
        $permissionsIdsArray = $permissions->pluck('id');

        Validator::make($request->all(), [
            'permissions' => ['required', 'array', Rule::in($permissionsIdsArray)],
            'permissions.*' => 'sometimes|integer|distinct'
        ])->validate();

        $role->permissions()->sync($request->permissions);

        return response()->json([
            'message' => 'Rol y sus permisos',
            'role' => $role->load('permissions')
        ]);
    }
}
