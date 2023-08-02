@include('layouts.app')

@yield('content')
<div class="container mt-2">
    @auth
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('roles.create') }}"> Create role</a>
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
            <th>role Name</th>
            <th>role Permission</th>
            @auth
                <th width="280px">Action</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->permission }}</td>

                @auth
                    <td>
                        <form action="{{ route('roles.destroy',$role->id) }}" method="Post">
                            <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
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
