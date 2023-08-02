@include('layouts.app')

@yield('content')
<div class="container mt-2">
    @auth
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('offices.create') }}"> Create office</a>
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
            <th>office Name</th>
            @auth
                <th width="280px">Action</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach ($offices as $office)
            <tr>
                <td>{{ $office->id }}</td>
                <td>{{ $office->name }}</td>

                @auth
                    <td>
                        <form action="{{ route('offices.destroy',$office->id) }}" method="Post">
                            <a class="btn btn-primary" href="{{ route('offices.edit',$office->id) }}">Edit</a>
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
</div>
