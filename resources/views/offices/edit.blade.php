@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
            <form action="{{ route('offices.update',$data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <section class="gradient-custom">
                <div class="container py-5 ">
                    <div class="row d-flex justify-content-center align-items-center ">
                        <span class="mt-2 bg-gray-500 text-center w-75 mx-auto rounded">
                    @foreach($errors->all() as $error)
                                <div>
                            {!! $error !!}
                        </div>
                            @endforeach
                        </span>
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card card_border">
                                <a href="{{ route('offices.index') }}" class="btn btn-sm px-4 mx-lg-2 mt-2 w-25">Geri Dön</a>
                                <div class="card-body p-5 text-center">

                                    <div class="mb-md-5 mt-md-4">

                                        <h2 class="fw-bold mb-2 text-uppercase">Ofis Güncelleme</h2>
                                        <p class=" mb-5">Lütfen Ofis güncel bilgilerini giriniz.</p>

                                        <div class="form-outline mb-4">
                                            <input type="text" id="name" name="name" value="{{$data->name}}" class="border border-gray text-center rounded-pill form-control form-control-lg" />
                                            <label class="form-label" for="typeEmailX">Ofis Adı</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <select name="kat" id="kat" class="js-example-basic-single">
                                                @foreach($katlar as $kat)
                                                    <option @if($data->kat == $kat) selected @endif value="{{$kat}}">{{$kat}}</option>
                                                @endforeach
                                            </select>
                                            <label class="form-label" for="typePasswordX">Bulunduğu Kat</label>
                                        </div>

                                        <button class="btn btn-outline-dark btn-lg px-5" type="submit" id="kt_sign_in_submit">Ofis Güncelle</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
