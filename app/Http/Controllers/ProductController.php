<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreProductRequest;
use App\Http\Requests\Update\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']] );
    }

    public function index()
    {

        $products = Product::orderBy('id','asc')->paginate(5);
        return view('products.index', compact('products'));
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
        return view('products.create', ['modulConf' => $modulConf]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProductRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return to_route('products.index')
            ->with('toastr', [
                'success',
                'Yeni kayıt başarılı bir şekilde eklendi.',
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product  $product): View
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product  $product): View
    {
        $modulConf = [
            'title' => 'Ürün Düzenle',
        ];

        return view('products.edit', [
            'modulConf' => $modulConf,
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest  $request
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product  $product): RedirectResponse
    {
        $product->update($request->validated());

        return to_route('products.edit', $product->id)
            ->with('toastr', [
                'success',
                'Kayıt başarılı bir şekilde güncellendi.',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product  $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Product has been deleted successfully');
    }
}
