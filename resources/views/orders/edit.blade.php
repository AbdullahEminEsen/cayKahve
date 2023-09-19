@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('orders.update',$data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                        <div class="col-12 col-md-8 col-lg-6 col-xl-10">
                            <div class="card card_border">
                                <a href="{{ route('orders.index') }}" class="btn btn-sm px-4 mx-lg-2 mt-2 w-25">Geri Dön</a>
                                <div class="card-body px-5 text-center">
                                    <div class="mb-md-5 mt-md-2">
                                        <h2 class="fw-bold mb-2 text-uppercase">Sipariş Güncelle</h2>
                                        <p class="mb-5">Lütfen Sipariş bilgilerini güncelleyiniz.</p>
                                        <div class="form-outline mb-4 d-flex justify-between">
                                            <div class="w-100">
                                                <select id="user_id" name="user_id" class="js-example-basic-single rounded-pill w-75 text-center" data-mdb-visible-options="3">
                                                    @if(auth()->user()->role_id == '1')
                                                        @foreach($users as $user)
                                                            <option @if($user->id == $data->user_id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    @else
                                                            <option @if($data->user_id) selected @endif value="{{$data->user_id}}">{{auth()->user()->name}}</option>
                                                    @endif
                                                </select>
                                                <div></div>
                                                <label class="form-label" for="typeEmailX">Müşteri Adı</label>
                                            </div>
                                            <div class="w-100">
                                                <select id="product_id" name="product_id" class="js-example-basic-single rounded-pill w-75 text-center" data-mdb-visible-options="3">
                                                    @foreach($products as $product)
                                                        <option @if($product->id == $data->product_id) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div></div>
                                                <label class="form-label" for="typeEmailX">Ürün Adı</label>
                                            </div>
                                            <div class="form-outline">
                                                <input type="number" name="quantity" value="{{$data->quantity}}" class="form-control border border-dark text-center rounded">
                                                <label for="typeNumber">Ürün Adet</label>
                                            </div>
                                        </div>
                                        <div class="form-outline mb-4 ">
                                        </div>
                                        @if(auth()->user()->role_id != 3)
                                            <div class="form-outline mb-4">
                                                <select id="status" name="status" class="js-example-basic-single rounded-pill w-50 text-center">
                                                    @foreach($status as $key => $statusName)
                                                        <option @if($data->status == $key) selected @endif value="{{ $key }}">{{ $statusName }}</option>
                                                    @endforeach
                                                </select>
                                                <div></div>
                                                <label for="typeEmailX">Sipariş Durumu</label>
                                            </div>
                                        @endif

                                        <div class="form-outline mb-4">
                                            <input type="text" name="description" value="{{$data->description}}" id="textAreaExample" rows="4" class="form-control border border-dark rounded"></input>
                                            <label for="typeEmailX">Açıklama</label>
                                        </div>
                                        <button class="btn btn-outline-dark btn-lg px-5" type="submit" id="kt_sign_in_submit">Sipariş Güncelle</button>
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
