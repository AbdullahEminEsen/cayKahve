@include('layouts.app')

@yield('content')
<div class="container mt-2">
    @auth
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('users.create') }}"> Create user</a>
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
            <th>user Name</th>
            <th>user email</th>
            <th>user office</th>
            <th>user order</th>
            <th>user role</th>
            @auth
                <th width="280px">Action</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->office->name }}</td>
                <td>{{ $user->order_id }}</td>
                <td>{{ $user->role->name }}</td>

                @auth
                    <td>
                        <form action="{{ route('users.destroy',$user->id) }}" method="Post">
                            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
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
