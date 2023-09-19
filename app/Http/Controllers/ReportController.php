<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index()
    {
        // Retrieve the list of offices from your database
        $offices = Office::orderBy('id', 'asc')->get();

        // Pass the $offices variable to the view
        return view('reports.index', ['offices' => $offices]);
    }

    public function generateReport(Request $request): View
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

        // Retrieve input values from the form
//        $officeIds = User::distinct()->pluck('office_id')->filter()->toArray();

        // Retrieve the list of offices
        $offices = Office::orderBy('name', 'asc')->get();
        $products = Product::orderBy('name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();



        $selectedOfficeId = $request->input('office_id');
        $selectedUserId = $request->input('user_id');
        $selectedProductId = $request->input('product_id');
        $selectedStatus = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Build the query to filter orders based on input
        $query = Order::query();

        // Filter by office
        if ($selectedOfficeId) {
            $query->whereHas('user', function ($query) use ($selectedOfficeId) {
                $query->where('office_id', $selectedOfficeId);
            });
        }

        // Filter by user
        if ($selectedUserId) {
            $query->where('user_id', $selectedUserId);
        }

        // Filter by product
        if ($selectedProductId) {
            $query->where('product_id', $selectedProductId);
        }

        // Filter by status
        if ($selectedStatus !== null) {
            $query->where('status', $selectedStatus);
        }

        // Filter by date range
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Retrieve a count of all orders without filtering

        // Retrieve the filtered orders
        $filteredOrders = $query->orderBy('id', 'asc')->get();

        $filteredOrdersCount = count($filteredOrders);
        $filteredOrders = $query->orderBy('id', 'asc')->paginate(10);


        return view('reports.index', [
            'filteredOrders' => $filteredOrders,
            'filteredOrdersCount' => $filteredOrdersCount,
            'offices' => $offices,
            'users' => $users,
            'products' => $products,
            'status' => $status,
            'statusNames' => $statusNames,
            'selectedOfficeId' => $selectedOfficeId,
            'selectedUserId' => $selectedUserId,
            'selectedProductId' => $selectedProductId,
            'selectedStatus' => $selectedStatus,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
