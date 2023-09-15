<section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-8">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header px-4 py-5">
                        <div class="mb-2 d-flex justify-between">
                            <h5 class="text-muted mb-0">Siparişiniz için teşekkürler, <span style="color: #a8729a;">{{auth()->user()->name}}</span>!</h5>
                            <a class="btn btn-success" href="{{ route('orders.create') }}">Sipariş Oluştur</a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @foreach ($orders as $order)
                            <div class="card shadow-0 border mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            @if ($order->product->image)
                                                <img src="{{ asset($order->product->image) }}" class="fitImage" alt="Product Image">
                                            @else
                                                No Image Available
                                            @endif
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 text-uppercase">{{ $order->user->office->name }}</p>
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small text-uppercase">{{ $order->user->name }}</p>
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small">{{ $order->product->name }}</p>
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small">{{ $order->quantity }}</p>
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small">{{ date('d-m-Y', strtotime($order->created_at))}}</p>
                                        </div>
                                    </div>
                                    <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-2">
                                            <p class="text-muted mb-0 small">Sipariş Durumu</p>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="progress" style="height: 6px; border-radius: 16px;">
                                                @if($order->status == 1)
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: 5%; border-radius: 16px; background-color: #a8729a;" aria-valuenow="65"
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                @elseif($order->status == 2)
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: 30%; border-radius: 16px; background-color: #a8729a;" aria-valuenow="65"
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                @else
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: 100%; border-radius: 16px; background-color: #a8729a;" aria-valuenow="65"
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-around mb-1">
                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Onaylandı</p>
                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Tamamlandı</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer border-0 px-4 py-5"
                         style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Toplam Sipariş : <span class="h2 mb-0 ms-2">{{ $countedOrders }}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
