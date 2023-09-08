<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreUserRequest;
use App\Http\Requests\Update\UpdateUserRequest;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']] );
    }

    public function index()
    {
        $users = User::orderBy('id','asc')->with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.role', compact('user', 'roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offices = Office::orderBy('id','asc')->get();
        $roles = Role::orderBy('id','asc')->get();
        $modulConf = [
            'title' => 'Kullanıcı Ekle',
        ];
        return view('users.create', ['modulConf' => $modulConf], compact('offices', 'roles'));
    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $user->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');
    }

    public function givePermission(Request $request, User $user)
    {
        if ($user->hasPermissionTo($request->permission)) {
            return back()->with('message', 'Permission exists.');
        }
        $user->givePermissionTo($request->permission);
        return back()->with('message', 'Permission added.');
    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return back()->with('message', 'Permission revoked.');
        }
        return back()->with('message', 'Permission does not exists.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {

        User::create($request->validated());

        return to_route('admin.users.index')
            ->with('toastr', [
                'success',
                'Yeni kullanıcı başarılı bir şekilde eklendi.',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User  $user): View
    {
        $offices = Office::orderBy('id','asc')->get();
        $roles = Role::orderBy('id','asc')->get();

        $modulConf = [
            'title' => 'Kullanıcı Düzenle',
        ];

        return view('users.edit', [
            'modulConf' => $modulConf,
            'data' => $user,
        ], compact('offices', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest  $request, User  $user): RedirectResponse
    {
        $user->update($request->validated());

        return to_route('admin.users.edit', $user->id)
            ->with('toastr', [
                'success',
                'Kullanıcı başarılı bir şekilde güncellendi.',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('message', 'you are admin.');
        }
        $user->delete();

        return back()->with('message', 'User deleted.');
    }
}
