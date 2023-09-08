<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreOfficeRequest;
use App\Http\Requests\Update\UpdateOfficeRequest;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']] );
    }

    public function index()
    {
        $offices = Office::orderBy('id','asc')->get();
        return view('offices.index', compact('offices'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $katlar = [3,2,1,-2,-3];
        $modulConf = [
            'title' => 'Ofis Ekle',
        ];
        return view('offices.create', ['modulConf' => $modulConf], compact('katlar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOfficeRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreOfficeRequest $request): RedirectResponse
    {
        Office::create($request->validated());

        return to_route('offices.index')
            ->with('toastr', [
                'success',
                'Yeni kayıt başarılı bir şekilde eklendi.',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office  $office): View
    {
        $katlar = [3,2,1,-2,-3];
        $modulConf = [
            'title' => 'Ofis Düzenle',
        ];

        return view('offices.edit', [
            'modulConf' => $modulConf,
            'data' => $office,
            'katlar' => $katlar,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOfficeRequest  $request
     * @param  Office  $office
     * @return RedirectResponse
     */
    public function update(UpdateOfficeRequest $request, Office  $office): RedirectResponse
    {
        $office->update($request->validated());

        return to_route('offices.edit', $office->id)
            ->with('toastr', [
                'success',
                'Kayıt başarılı bir şekilde güncellendi.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office  $office)
    {
        $office->delete();
        return redirect()->route('offices.index')->with('success','Office has been deleted successfully');
    }
}
