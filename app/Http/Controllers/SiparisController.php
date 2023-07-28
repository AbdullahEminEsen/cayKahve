<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siparis;
use Illuminate\Http\Request;

class SiparisController extends Controller
{
    public function index()
    {
        $siparises = Siparis::orderBy('id','asc')->paginate(5);
        return view('siparises.index', compact('siparises'));
    }
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']] );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siparises.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'office_name' => 'required',
            'urun' => 'required',
            'durum' => 'required',
            'description' => 'required',
        ]);


        return redirect()->route('siparises.index')->with('success','Siparis has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Siparis  $siparis
     * @return \Illuminate\Http\Response
     */
    public function show(Siparis $siparis)
    {
        return view('siparises.show',compact('siparis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Siparis  $siparis
     * @return \Illuminate\Http\Response
     */
    public function edit(Siparis $siparis)
    {
        return view('siparises.edit',compact('siparis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Siparis  $siparis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siparis  $siparis)
    {
        $request->validate([
            'office_name' => 'required',
            'urun' => 'required',
            'description' => 'required',
        ]);

        $siparis->fill($request->post())->save();

        return redirect()->route('siparises.index')->with('success','Siparis Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Siparis  $siparis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siparis  $siparis)
    {
        $siparis->delete();
        return redirect()->route('siparises.index')->with('success','Siparis has been deleted successfully');
    }
}
