<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreUserRequest;
use App\Http\Requests\Update\UpdateUserRequest;
use App\Models\Office;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']] );
    }

    public function index()
    {

        $users = User::orderBy('id','asc')->get();
        return view('users.index', compact('users'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {

        User::create($request->validated());

        return to_route('users.index')
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

        return to_route('users.edit', $user->id)
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
    public function destroy(User  $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','User has been deleted successfully');
    }
}
