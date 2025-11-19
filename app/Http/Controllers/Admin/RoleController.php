<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_role')->only('index', 'show');
        $this->middleware('permission:create_role')->only('create', 'store');
        $this->middleware('permission:update_role')->only('edit', 'update');
        $this->middleware('permission:delete_role')->only('destroy');
    }
    public function index()
    {
        $roles = Role::withCount('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.roles.create', compact('permissions'));
    }
    public function store(RoleRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);
        DB::commit();
        return to_route('admin.roles.index')->with('success', 'Role created successfully');
    }
    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('group_name');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    public function update(RoleRequest $request, Role $role)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);
        DB::commit();
        return to_route('admin.roles.index')->with('success', 'Role updated successfully');
    }
    public function destroy(Role $role)
    {
        if ($role->users()->count()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role is assigned to users and cannot be deleted.',
            ]);
        }

        $role->syncPermissions([]);
        $role->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return response()->json([
            'status' => 'success',
            'message' => 'Role deleted successfully',
        ]);
    }
}
