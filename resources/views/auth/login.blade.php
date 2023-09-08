@extends('layouts.app')

@section('content')
    @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('login') }}">
        @csrf
    <section class="">
        <div class="container py-5 ">
            <div class="row d-flex justify-content-center align-items-center ">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-radius: 1rem;">
                        @foreach($errors->all() as $error)
                            <span class="mt-2 bg-gray-500 text-center w-75 mx-auto rounded">{!! $error !!}</span>
                        @endforeach
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4">

                                <h2 class="fw-bold mb-2 text-uppercase">hoş geldiniz</h2>
                                <p class=" mb-5">Lütfen kullanıcı bilgilerinizi giriniz.</p>

                                <div class="form-outline mb-4">
                                    <input type="email" id="email" name="email" class="border border-gray text-center form-control form-control-lg rounded-pill" />
                                    <label class="form-label" for="typeEmailX">Email</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password" class="border border-gray text-center form-control form-control-lg rounded-pill" />
                                    <label class="form-label" for="typePasswordX">Şifre</label>
                                </div>

                                <button class="btn btn-outline-dark btn-lg px-5" type="submit" id="kt_sign_in_submit">Giriş Yap</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
@endsection
