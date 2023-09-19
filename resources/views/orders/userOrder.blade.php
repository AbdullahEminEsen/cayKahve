<section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-10">
                <div class="card card-border">
                    <div class="card-header px-4 py-5">
                        <div class="mb-2 d-flex justify-between">
                            <h5 class="text-muted mb-0">Siparişiniz için teşekkürler, <span class="text-danger">{{auth()->user()->name}}</span>!</h5>
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
                                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small text-uppercase">{{ $order->user->name }}</p>
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small">{{ $order->product->name }}</p>
                                        </div>
                                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small">{{ $order->quantity }}</p>
                                        </div>
                                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small">{{ $order->description }}</p>
                                        </div>
                                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small">{{ date('H.i', strtotime($order->created_at))}}</p>
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center flex space-x-2">
                                        @if(auth()->user()->role_id == '1' || auth()->user()->role_id == '3' && $order->status == 1)
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                               class="px-4 py-4 bg-blue-500 hover:bg-blue-700 text-white rounded-md"><i class="gg-pen"></i></a>
                                                <form
                                                    class="btn px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md"
                                                    method="POST"
                                                    action="{{ route('orders.destroy', $order->id) }}"
                                                    id="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="mt-2" onclick="archiveFunction(event)"><i class="gg-trash"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-2">
                                            <p class="text-muted mb-0 small">Sipariş Durumu</p>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="progress progress_size">
                                                @if($order->status == 1)
                                                    <div class="progress-bar progress_bar_halt" style="background-color: #f51515;" role="progressbar"> <i class="fa-solid fa-person icon_font_size"></i></div>
                                                @elseif($order->status == 2)
                                                    <div class="progress-bar progress_bar_on_way" style="background-color: #ecc42e;" role="progressbar"><i class="pr-4 fa-solid fa-person-walking text-end icon_font_size"></i></div>
                                                @else
                                                    <div class="progress-bar progress_bar_finished" style="background-color: #54d70a;" role="progressbar"><i class="pr-4 fa-solid fa-circle-check text-end icon_font_size"></i></div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer border-0 px-4 py-3 card_bottom_border"
                         style="background-color: #a8729a;">
                        <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Toplam Sipariş : <span class="h2 mb-0 ms-2">{{ $countedOrders }}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
