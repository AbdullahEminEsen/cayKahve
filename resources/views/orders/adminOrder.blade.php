<div class="d-flex justify-center mt-3 mb-3">
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

<div>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 mb-3">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
            @if(auth()->user()->role_id == 1)
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right mb-2">
                            <a class="btn btn-success" href="{{ route('orders.create') }}">Sipariş Oluştur</a>
                        </div>
                    </div>
                </div>
            @endif
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
                                                            @if(auth()->user()->role_id == '1')
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
<div class="d-flex justify-center mb-3">
    {{ $orders->links() }}
</div>
