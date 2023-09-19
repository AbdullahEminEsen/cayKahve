<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreOrderRequest;
use App\Http\Requests\Update\UpdateOrderRequest;
use App\Models\Office;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Order $order): View
    {
        $status = [
            '1' => 'Onaylanmadı',
            '2' => 'Onaylandı',
            '3' => 'Tamamlandı',
        ];

        $statusNames = [
            '1' => 'Verilen Sipariş',
            '2' => 'Onaylanan Sipariş',
            '3' => 'Tamamlanan Sipariş',
        ];

        $countedOrders = 0;
        $orders = collect(); // Initialize an empty collection

        if (Auth::user()->role_id == 1) {
            // For role_id == 1 (Admin), show all orders
            $orders = Order::orderBy('id', 'desc')->paginate(10);
        } elseif (Auth::user()->role_id == 2) {
            // For role_id == 2 (User), filter orders based on the user's office floor
            $userFloor = Auth::user()->office->kat;

            // Get the office IDs with the same floor
            $officesWithSameFloor = Office::where('kat', $userFloor)->pluck('id');

            // Filter orders where the office_id is in the officesWithSameFloor array
            $users = User::whereIn('office_id', $officesWithSameFloor)->pluck('id');

            $orders = Order::whereIn('user_id', $users)->orderBy('id', 'desc')->paginate(10);
        } elseif (Auth::user()->role_id == 3) {
            // For role_id == 3 (User), show their own orders created in the last 24 hours
            $userId = Auth::id();
            $twentyFourHoursAgo = now()->subDay();

            $orders = Order::where('user_id', $userId)
                ->where('created_at', '>=', $twentyFourHoursAgo)
                ->orderBy('id', 'desc')
                ->get();
        }

        $countedOrders = $orders->count();

        return view('orders.index', [
            'status' => $status,
            'statusNames' => $statusNames,
            'orders' => $orders,
            'countedOrders' => $countedOrders,
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

        if (Gate::denies('edit-order', $order)) {
            abort(403); // Or handle unauthorized access as needed
        }

        if (Auth::user()->role_id == 2) {
            abort(403); // Users with role_id 2 are not allowed to access the edit page
        }

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

    public function getNewOrders(): JsonResponse
    {
        // Logic to check for new orders
        $newOrders = $this->checkForNewOrdersLogic(); // Implement your own logic here

        return response()->json(['newOrders' => $newOrders]);
    }
    public function fetchNewOrders()
    {
        // Query to fetch new orders (you'll need to define the logic here)
        $newOrders = Order::where('created_at', '>', Carbon::now()->subSeconds(30))->get();

        return response()->json(['newOrders' => $newOrders]);
    }

}
