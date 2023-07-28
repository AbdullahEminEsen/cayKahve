@include('auth.layouts.header')
@yield('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Anime</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('animes.index') }}" enctype="multipart/form-data">
                    Back</a>
            </div>
        </div>
    </div>
    @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('animes.update',$anime->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Anime Name:</strong>
                    <input type="text" name="name" value="{{ $anime->name }}" class="form-control"
                           placeholder="Anime Name">
                    @error('name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Anime Description:</strong>
                    <input type="text" name="description" class="form-control" value="{{ $anime->description }}"
                           placeholder="Anime Description">
                    @error('description')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Anime Episode:</strong>
                    <input type="number" name="episode" class="form-control" value="{{ $anime->episode }}"
                           placeholder="Anime Episode">
                    @error('episode')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Anime Rate:</strong>
                    <input type="number" name="rate" class="form-control" value="{{ $anime->rate }}"
                           placeholder="Anime Rate">
                    @error('rate')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-3">Submit</button>
        </div>
    </form>
</div>
