<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Enums\UserStatusEnum;
use App\Http\Requests\Admin\UserRequest;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view_user')->only('index', 'show');
    //     $this->middleware('permission:create_user')->only('create', 'store');
    //     // $this->middleware('permission:update_user')->only('edit', 'update');
    //     $this->middleware('permission:delete_user')->only('destroy');
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userstatuses = UserStatusEnum::labels();
        $roles = Role::all();
        return view('admin.users.create', compact('userstatuses', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole($request->role);
        return to_route('admin.users.index')->with('success', 'user added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userstatuses = UserStatusEnum::labels();
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'userstatuses', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user = User::findOrFail($id);
        $user->syncRoles($data['role']);
        $user->update($data);
        return to_route('admin.users.index')->with('success', 'User updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
            ]);
    }
}
