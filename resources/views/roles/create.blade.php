@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section >
                <div class="container py-5 ">
                    <div class="row d-flex justify-content-center align-items-center ">
                        <span class="mt-2 bg-danger text-center w-75 mx-auto rounded mb-3">
                        @foreach($errors->all() as $error)
                                <div>
                           {!! $error !!}
                            </div>
                            @endforeach
                             </span>
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card card_border">
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-sm px-4 mx-lg-2 mt-2 w-25">Geri Dön</a>
                                <div class="card-body p-5 text-center">

                                    <div class="mb-md-5 mt-md-4">

                                        <h2 class="fw-bold mb-2 text-uppercase">Rol Ekleme</h2>
                                        <p class=" mb-5">Lütfen Rol bilgilerini giriniz.</p>

                                        <div class="form-outline mb-4">
                                            <input type="text" id="name" name="name" class="border border-gray text-center rounded-pill form-control form-control-lg" />
                                            <label class="form-label" for="typeEmailX">Rol Adı</label>
                                        </div>

                                        <button class="btn btn-outline-dark btn-lg px-5" type="submit" id="kt_sign_in_submit">Rol Ekle</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
@endsection
