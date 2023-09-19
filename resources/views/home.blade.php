@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-center row">
            @foreach ($products as $product)
                <div class="bg-gray-200 mx-5 px-5 mt-5 py-3 rounded-lg col-md-3">
                    <form action="{{ route('orders.create') }}" method="GET">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="d-flex flex-column align-items-center">
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" class="fitImageHome" alt="Product Image">
                            @else
                                No Image Available
                            @endif
                            <div class="flex items-center mx-auto mt-2 productFont">
                                {{ $product->name }}
                            </div>
                            <div class="mt-2">
                                <label for="quantity">Miktar:</label>
                                <input type="number" class="rounded w-100 text-center" name="quantity" id="quantity" value="1" min="1">
                            </div>
                            <button type="submit" class="btn bg-success btn-success mt-2">Sipariş Ver</button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
