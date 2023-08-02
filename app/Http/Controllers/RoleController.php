<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRoleRequest;
use App\Http\Requests\Update\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']] );
    }

    public function index()
    {

        $roles = Role::orderBy('id','asc')->paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulConf = [
            'title' => 'Ürün Ekle',
        ];
        return view('roles.create', ['modulConf' => $modulConf]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRoleRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Role::create($request->validated());

        return to_route('roles.index')
            ->with('toastr', [
                'success',
                'Yeni kayıt başarılı bir şekilde eklendi.',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role  $role): View
    {
        $modulConf = [
            'title' => 'Ürün Düzenle',
        ];

        return view('roles.edit', [
            'modulConf' => $modulConf,
            'data' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRoleRequest  $request
     * @param  Role  $role
     * @return RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role  $role): RedirectResponse
    {
        $role->update($request->validated());

        return to_route('roles.edit', $role->id)
            ->with('toastr', [
                'success',
                'Kayıt başarılı bir şekilde güncellendi.',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role  $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success','Role has been deleted successfully');
    }
}
