@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if(auth()->user()->role_id == '3')

        <section class="h-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-10 col-xl-8">
                        <div class="card" style="border-radius: 10px;">
                            <div class="card-header px-4 py-5">
                                <h5 class="text-muted mb-0">Siparişiniz için teşekkürler, <span style="color: #a8729a;">{{auth()->user()->name}}</span>!</h5>
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




    @else
    <div class="d-flex justify-center mt-3 mb-5">
        <button class="btn filter-btn mx-5 btn-light" data-status="all">Tüm Siparişler</button>
        <button class="btn filter-btn mx-5 btn-warning" data-status="1">Verilen Siparişler</button>
        <button class="btn filter-btn mx-5 btn-success" data-status="2">Onaylanan Siparişler</button>
        <button class="btn filter-btn mx-5 btn-primary" data-status="3">Tamamlanan Siparişler</button>
    </div>

    @if (session('toastr'))
        <script>
            var toastrData = @json(session('toastr'));
            toastr[toastrData.type](toastrData.message);
        </script>
    @endif

    <div class="py-9">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 mb-5">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                @auth
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right mb-2">
                                <a class="btn btn-success" href="{{ route('orders.create') }}">Sipariş Oluştur</a>
                            </div>
                        </div>
                    </div>
                @endauth
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Müşteri Ofisi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Müşteri İsmi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ürün İsmi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ürün Adet
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Sipariş Durumu
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Oluşturma <br> Tarihi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Onaylanma <br> Tarihi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Açıklama
                                        </th>
                                        <th scope="col"
                                            class="statusHide px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                            İşlemler
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($orders as $order)
                                        <tr class="order-row" data-status="{{ $order->status }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ $order->user->office->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ $order->user->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ $order->product->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ $order->quantity }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap status-cell">
                                                <div class="flex items-center">
                                                    {{ $status[$order->status]}}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap status-cell">
                                                <div class="flex items-center">
                                                    {{ $order->created_at}}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap status-cell">
                                                <div class="flex items-center">
                                                    {{ $order->updated_at}}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ Str::limit($order->description, 30) }}
                                                </div>
                                            </td>
                                            @if(auth()->user())
                                                <td>
                                                <div class="flex justify-center">
                                                    <div class="flex space-x-2">
                                                        @if(auth()->user()->role_id == '1' || auth()->user()->role_id == '3' && $order->status == 1)
                                                        <a href="{{ route('orders.edit', $order->id) }}"
                                                           class="px-4 py-4 bg-blue-500 hover:bg-blue-700 text-white rounded-md"><i class="gg-pen"></i></a>
                                                        @endif
                                                            @if(auth()->user()->role_id != '3')

                                                            @if($order->status < 3)
                                                            <a class="btn px-4 py-4 bg-green-500 hover:bg-green-700 text-white rounded-md update-status-form"
                                                               data-id="{{$order->id}}"><i class="gg-arrow-long-right"></i></a>
                                                            @endif
                                                        <form
                                                            class="btn px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md"
                                                            method="POST"
                                                            action="{{ route('orders.destroy', $order->id) }}"
                                                            onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="mt-2"><i class="gg-trash"></i></button>
                                                        </form>
                                                            @endif

                                                    </div>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script>
        $(document).ready(function () {
            // Check if active tab is stored in local storage
            var activeTab = localStorage.getItem("activeTab");
            if (activeTab) {
                $(".filter-btn").removeClass("active");
                $(".order-row").hide();
                if (activeTab !== "all") {
                    $(".order-row[data-status='" + activeTab + "']").show();
                } else {
                    $(".order-row").show();
                }
            }

            function updateButtonLabels() {
                $(".filter-btn").each(function () {
                    var targetStatus = $(this).data("status");
                    var orderCount;

                    if (targetStatus === "all") {
                        orderCount = $(".order-row").length;
                    } else {
                        orderCount = $(".order-row[data-status='" + targetStatus + "']").length;
                    }

                    var buttonText = $(this).text().split(" ")[0];
                    $(this).text(buttonText + " (" + orderCount + ")");
                });
            }

            // Initial update of button labels
            updateButtonLabels();

            // Click event for filter buttons
            $(".filter-btn").click(function () {
                var targetStatus = $(this).data("status");

                $(".filter-btn").removeClass("active");
                $(this).addClass("active");

                $(".order-row").hide();
                if (targetStatus !== "all") {
                    $(".order-row[data-status='" + targetStatus + "']").show();
                } else {
                    $(".order-row").show();
                }
                @if(auth()->user()->role_id == 3)
                    if (targetStatus === 2 || targetStatus === 3){
                        $('.statusHide').addClass('d-none');
                    } else{
                        $('.statusHide').removeClass('d-none');
                    }
                @endif


                // Store active tab in local storage
                localStorage.setItem("activeTab", targetStatus);

                // Update button labels after filtering
                updateButtonLabels();
            });

            // Show initially selected tab's data
            if (activeTab) {
                if (activeTab !== "all") {
                    $(".order-row[data-status='" + activeTab + "']").show();
                } else {
                    $(".order-row").show();
                }
            }

            // Check if the page is reloading
            var isReloading = localStorage.getItem("reloading");
            if (isReloading === "true") {
                var activeTab = localStorage.getItem("activeTab");
                if (activeTab) {
                    $(".filter-btn").removeClass("active");
                    if (activeTab !== "all") {
                        $(".order-row").hide();
                        $(".order-row[data-status='" + activeTab + "']").show();
                    } else {
                        $(".order-row").show();
                    }
                }
                localStorage.removeItem("reloading");
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".update-status-form").on("click", function (event) {
                event.preventDefault(); // Prevent the default form submission
                const testing = $(this).data("id");
                var url = "{{ route('orders.update-status') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        "id": testing,
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        // Assuming the server responds with a JSON object containing the updated status
                        if (response) {
                            toastr.success('Sipariş durumu başarıyla güncellendi')
                            setTimeout(function () {
                                window.location.reload()
                            }, 1500);
                        }
                    },
                    error: function (error) {
                        console.log("An error occurred: " + error);
                    }
                });
            });
        });
    </script>
    <script>
        function refreshPage() {
            var activeTab = localStorage.getItem("activeTab");
            localStorage.setItem("reloading", "true");
            if (activeTab) {
                localStorage.setItem("activeTab", activeTab);
            }
            location.reload();
        }

        $(document).ready(function () {
            // Check if the page is reloading
            var isReloading = localStorage.getItem("reloading");
            if (isReloading === "true") {
                var activeTab = localStorage.getItem("activeTab");
                if (activeTab) {
                    $(".filter-btn").removeClass("active");
                    $(".order-row").hide();
                    $(".order-row[data-status='" + activeTab + "']").show();
                }
                localStorage.removeItem("reloading");
            }

            // Call the refreshPage function every 30 seconds
            setInterval(refreshPage, 30000); // 30000 milliseconds = 30 seconds
        });
    </script>
    <script>
        // Function to check for new orders and play the alarm sound
        function checkForNewOrders() {
            if ({{ auth()->user()->role_id }} === 2) {
                // Make an AJAX request to fetch the latest orders or use another method to check for new orders
                $.ajax({
                    type: "GET",
                    url: "{{ route('orders.fetch-new') }}", // Replace with the actual route to fetch new orders
                    success: function (response) {
                        if (response.newOrders && response.newOrders.length > 0) {
                            // Play the alarm sound
                            var alarmSound = new Audio("{{ asset('AlarmSound.mp3') }}");
                            alarmSound.play();

                            toastr.info('New order(s) received.');
                        }
                    },
                    error: function (error) {
                        console.log("An error occurred while checking for new orders: " + error);
                    }
                });
            }
        }

        // Call the checkForNewOrders function every minute (adjust the interval as needed)
        setInterval(checkForNewOrders, 10000); // 60000 milliseconds = 1 minute
    </script>
@endsection
