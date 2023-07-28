@include('layouts.app')

@yield('content')
<div class="container mt-2">
    @auth
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('products.create') }}"> Create Product</a>
                </div>
            </div>
        </div>
    @endauth
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Product Image</th>
            @auth
                <th width="280px">Action</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" style="max-width: 100px">
                    @else
                        No Image Available
                    @endif
                </td>
                @auth
                    <td>
                        <form action="{{ route('products.destroy',$product->id) }}" method="Post">
                            <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                @endauth
            </tr>

        @endforeach
        </tbody>
    </table>
    {!! $products->links() !!}
</div>
