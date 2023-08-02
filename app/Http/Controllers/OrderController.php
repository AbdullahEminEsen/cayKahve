<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $siparises = Order::orderBy('id','asc')->paginate(5);
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
            'user_id',
            'product_id',
            'status',
            'description',
            'card_id'
        ]);


        return redirect()->route('siparises.index')->with('success','Order has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Siparis  $siparis
     * @return \Illuminate\Http\Response
     */
    public function show(Order $siparis)
    {
        return view('siparises.show',compact('siparis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Siparis  $siparis
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $siparis)
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
    public function update(Request $request, Order $siparis)
    {
        $request->validate([
            'office_id',
            'product_id',
            'description',
            'card_id'
        ]);

        $siparis->fill($request->post())->save();

        return redirect()->route('siparises.index')->with('success','Order Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Siparis  $siparis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $siparis)
    {
        $siparis->delete();
        return redirect()->route('siparises.index')->with('success','Order has been deleted successfully');
    }
}
