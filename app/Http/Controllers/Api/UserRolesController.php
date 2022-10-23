<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserRolesController extends Controller
{
    public function show(User $user)
    {
        $roles = Role::all();

        return response()->json([
            'message' => 'Usuario y sus roles',
            'user' => $user->load('roles'),
            'roles' => $roles
        ]);
    }

    public function sync(Request $request, User $user)
    {
        $roles = Role::all();
        $rolesIdsArray = $roles->pluck('id');

        Validator::make($request->all(), [
            'roles' => ['required', 'array', Rule::in($rolesIdsArray)],
            'roles.*' => 'sometimes|integer|distinct'
        ])->validate();

        $user->roles()->sync($request->roles);

        return response()->json([
            'message' => 'Usuario y sus roles',
            'user' => $user->load('roles')
        ]);
    }
}
