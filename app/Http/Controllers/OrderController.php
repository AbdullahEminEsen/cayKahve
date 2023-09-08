<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreOrderRequest;
use App\Http\Requests\Update\UpdateOrderRequest;
use App\Models\Office;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']] );
    }

    public function index(Order $order):View
    {
        $status = [
          '0' => 'Onaylanmadı',
          '1' => 'Onaylandı',
          '2' => 'Tamamlandı',
        ];
        $statusNames = [
            '0' => 'Verilen Sipariş',
            '1' => 'Onaylanan Sipariş',
            '2' => 'Tamamlanan Sipariş'
        ];
        $allOrders = Order::orderBy('id','asc')->get();

        $orders = null;
        if (Auth::user()->role_id == 1) {
            // For role_id == 3 (User), show all orders
            $orders = $allOrders;
        } elseif (Auth::user()->role_id == 2) {
            $userFloor = Auth::user()->office->kat;

            // Get the office IDs with the same floor
            $officesWithSameFloor = Office::where('kat', $userFloor)->pluck('id');

            // Filter orders where the office_id is in the officesWithSameFloor array
            $users = User::whereIn('office_id', $officesWithSameFloor)->pluck('id');

            $test = $allOrders->whereIn('user_id', $users);

            $orders = $test;
        } elseif (Auth::user()->role_id == 3) {
            $authOrder = $allOrders->whereIn('user_id', Auth::id());
            $orders = $authOrder;
        }

// Now you have the filtered $orders based on user's role and office floor
// You can proceed to use the $orders data as needed



        return view('orders.index',[
            'status' => $status,
            'statusNames' => $statusNames,
            'orders' => $orders,
        ]);
    }

    public function getOrdersByStatus($status)
    {
        $orders = Order::where('status', $status)->get();
        return view('orders.tab_content', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::orderBy('id','asc')->get();
        $products = Product::orderBy('id','asc')->get();
        $modulConf = [
            'title' => 'Sipariş Ekle',
        ];
        $selectedProduct = null;
        $quantity = null;

        if ($request->has('product_id')) {
            $selectedProductId = $request->input('product_id');
            $selectedProduct = Product::find($selectedProductId);
            $quantity = $request->input('quantity');
        }

        return view('orders.create', [
            'modulConf' => $modulConf,
            'users' => $users,
            'products' => $products,
            'selectedProduct' => $selectedProduct,
            'quantity' => $quantity,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOrderRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        Order::create($request->validated());
        return to_route('orders.index')
            ->with('toastr', [
                'success',
                'Yeni sipariş başarılı bir şekilde eklendi.',
            ]);
    }


    public function show(Order $order)
    {
        $users = User::all();
        $products = Product::all();
        return view('orders.show',compact('order','users','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order):View
    {
        $status = [
            '0' => 'Onaylanmadı',
            '1' => 'Onaylandı',
            '2' => 'Tamamlandı',
        ];
        $users = User::orderBy('id','asc')->get();
        $products = Product::orderBy('id','asc')->get();
        $statusNames = [
            '0' => 'Verilen Sipariş',
            '1' => 'Onaylanan Sipariş',
            '2' => 'Tamamlanan Sipariş'
        ];

        $modulConf = [
            'title' => 'Sipariş Düzenle',
        ];

        return view('orders.edit', [
            'modulConf' => $modulConf,
            'data' => $order,
            'statusNames' => $statusNames,
            'status' => $status,
        ], compact('users', 'products'));    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOrderRequest $request
     * @param  Order  $order
     * @return RedirectResponse
     */
    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->validated());

        return redirect()->route('orders.edit', $order->id)
            ->with('toastr', [
                'success',
                'Sipariş başarılı bir şekilde güncellendi.',
            ]);
    }

    public function updateStatus(Request $request)
    {
        $order = Order::firstWhere("id", $request->id);
        $order->update([
           'status' => $order->status + 1
        ]);
        return response()->json(1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success','Order has been deleted successfully');
    }
}
