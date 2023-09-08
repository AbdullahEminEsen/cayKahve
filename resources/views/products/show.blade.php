@extends('layouts.app')

@section('content')
    <style>
    .vertical-shadow {
        box-shadow: 0 0 10px rgba(255, 0, 0, 0.8);
        position: absolute;
        top: 0;
        left: 30%;
        height: 100%;
        width: 2px;
    }
</style>
<div style="display: flex">
    <div class="test mx-20">
        <div>
            @if ($product->image)
                <img src="{{ asset('images/' . $product->image) }}" alt="Avatar" class="image_hoverless">
            @else
                No Image Available
            @endif
        </div>
    </div>
    <div class="vertical-shadow"></div>
    <div class="w-100 mx-20 bg-danger mt-8 p-8" style="border: 1px solid black; border-radius: 15px">
        <div class="text-center w-100 mt-4" style="font-weight: bold; font-size: 30px">{{$product->name}}</div>
    </div>
</div>
@endsection
