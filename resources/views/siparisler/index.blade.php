@include('auth.layouts.header')

@yield('content')
<div class="container mt-2">
    @auth
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('animes.create') }}"> Create Anime</a>
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
            <th>Anime Name</th>
            <th>Anime Description</th>
            <th>Anime Episode</th>
            <th>Anime Rate</th>
            <th>Anime Image</th>
            @auth
                <th width="280px">Action</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach ($animes as $anime)
            <tr>
                <td>{{ $anime->id }}</td>
                <td><a href="{{ route('animes.show', $anime->id) }}">{{ $anime->name }}</a></td>
                <td>{{ $anime->description }}</td>
                <td>{{ $anime->episode }}</td>
                <td>{{ $anime->rate }}</td>
                <td>
                    @if ($anime->image)
                        <img src="{{ asset('images/' . $anime->image) }}" alt="Anime Image" style="max-width: 100px">
                    @else
                        No Image Available
                    @endif
                </td>
                @auth
                    <td>
                        <form action="{{ route('animes.destroy',$anime->id) }}" method="Post">
                            <a class="btn btn-primary" href="{{ route('animes.edit',$anime->id) }}">Edit</a>
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
    {!! $animes->links() !!}
</div>
