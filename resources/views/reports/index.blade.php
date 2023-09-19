@extends('layouts.app')

@section('content')
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 mt-3">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
    <form method="get" action="{{ route('generate.report') }}">


        <label for="office_id">Ofis Seçin:</label>
        <select name="office_id" id="office_id" class="btn border border-dark">
            <option value="">Tüm Ofisler</option>
            @foreach($offices as $office)
                <option value="{{ $office->id }}" {{ old('office_id', $selectedOfficeId) == $office->id ? 'selected' : '' }}>{{$office->name}}</option>
            @endforeach
        </select>

        <label for="user_id">Kullanıcı Seçin:</label>
        <select name="user_id" id="user_id" class="btn border border-dark">
            <option value="">Tüm Kullanıcılar</option>
        </select>

        <label for="product_id">Ürün Seçin:</label>
        <select name="product_id" id="product_id" class="btn border border-dark">
            <option value="">Tüm Ürünler</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id', $selectedProductId) == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        <label for="status">Sipariş Durumu:</label>
        <select name="status" id="status" class="btn border border-dark">
            <option value="">Tüm Durumlar</option>
            @foreach($status as $key => $value)
                <option value="{{ $key }}" {{ old('status', $selectedStatus) == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>

        <label for="start_date">Başlangıç Tarihi:</label>
        <input type="date" name="start_date" id="start_date" class="btn border border-dark" value="{{ old('start_date') ? date('Y-m-d', strtotime(old('start_date'))) : '' }}">

        <label for="end_date">Bitiş Tarihi:</label>
        <input type="date" name="end_date" id="end_date" class="btn border border-dark" value="{{ old('end_date') }}">
        <div class="d-flex justify-center">
            <button type="submit" class="my-3 py-2 px-2 btn btn-primary bg-primary d-flex">
                <span class="svg-icon svg-icon-2 ml-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
</svg></span>
                <span class="fs-6 mx-3">Ara</span>
            </button>
            <button id="clearFilters" class="my-3 ml-2 py-2 px-2 btn btn-success bg-success d-flex">
                <span class="svg-icon svg-icon-2 ml-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
<path opacity="0.3" d="M8.38 22H21C21.2652 22 21.5196 21.8947 21.7071 21.7072C21.8946 21.5196 22 21.2652 22 21C22 20.7348 21.8946 20.4804 21.7071 20.2928C21.5196 20.1053 21.2652 20 21 20H10L8.38 22Z" fill="currentColor"></path>
<path d="M15.622 15.6219L9.855 21.3879C9.66117 21.582 9.43101 21.7359 9.17766 21.8409C8.92431 21.946 8.65275 22 8.37849 22C8.10424 22 7.83268 21.946 7.57933 21.8409C7.32598 21.7359 7.09582 21.582 6.90199 21.3879L2.612 17.098C2.41797 16.9042 2.26404 16.674 2.15903 16.4207C2.05401 16.1673 1.99997 15.8957 1.99997 15.6215C1.99997 15.3472 2.05401 15.0757 2.15903 14.8224C2.26404 14.569 2.41797 14.3388 2.612 14.145L8.37801 8.37805L15.622 15.6219Z" fill="currentColor"></path>
<path opacity="0.3" d="M8.37801 8.37805L14.145 2.61206C14.3388 2.41803 14.569 2.26408 14.8223 2.15906C15.0757 2.05404 15.3473 2 15.6215 2C15.8958 2 16.1673 2.05404 16.4207 2.15906C16.674 2.26408 16.9042 2.41803 17.098 2.61206L21.388 6.90198C21.582 7.0958 21.736 7.326 21.841 7.57935C21.946 7.83269 22 8.10429 22 8.37854C22 8.65279 21.946 8.92426 21.841 9.17761C21.736 9.43096 21.582 9.66116 21.388 9.85498L15.622 15.6219L8.37801 8.37805Z" fill="currentColor"></path>
</svg></span>
                <span class="fs-6 mx-3">Temizle</span>
            </button>
        </div>
    </form>
        </div>
    </div>

    <!-- Display the filtered orders in a table -->
    @if(isset($filteredOrders))
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 mt-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <div class="ml-3 my-2">Siparişler ({{ $filteredOrdersCount }})</div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kullanıcı Adı
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ürün Adı
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sipariş Durumu
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Oluşturulma Tarihi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($filteredOrders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $statusNames[$order->status] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at }}</td>
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
    @endif
    <div class="d-flex justify-center mb-3 mt-3">
        {{ $filteredOrders->appends(['office_id' => $selectedOfficeId, 'user_id' => $selectedUserId, 'product_id' => $selectedProductId, 'status' => $selectedStatus, 'start_date' => $startDate, 'end_date' => $endDate])->links() }}
    </div>
    <script>
        // JavaScript to handle office selection
        document.addEventListener('DOMContentLoaded', function () {
            var officeSelect = document.getElementById('office_id');
            var userSelect = document.getElementById('user_id');

            // Function to populate the user select element based on the selected office
            function populateUserSelect(selectedOfficeId) {
                // Clear user options
                userSelect.innerHTML = '<option value="">Tüm Kullanıcılar</option>';

                // If an office is selected, populate users based on the selected office
                if (selectedOfficeId) {
                    @foreach($offices as $office)
                    if ({{$office->id}} == selectedOfficeId) {
                        @foreach($office->users as $user)
                        var option = document.createElement('option');
                        option.value = {{$user->id}};
                        option.textContent = '{{$user->name}}';
                        userSelect.appendChild(option);
                        @endforeach
                    }
                    @endforeach
                }
            }

            // Initial population of user select based on the selected office
            populateUserSelect(officeSelect.value);

            // Handle change event on office select
            officeSelect.addEventListener('change', function () {
                var selectedOfficeId = this.value;
                populateUserSelect(selectedOfficeId);
            });
        });
    </script>
    <script>
        // JavaScript to handle clearing filters
        document.addEventListener('DOMContentLoaded', function () {
            var clearFiltersButton = document.getElementById('clearFilters');
            var officeSelect = document.getElementById('office_id');
            var userSelect = document.getElementById('user_id');
            var productSelect = document.getElementById('product_id');
            var statusSelect = document.getElementById('status');
            var startDateInput = document.getElementById('start_date');
            var endDateInput = document.getElementById('end_date');

            clearFiltersButton.addEventListener('click', function () {
                officeSelect.value = '';
                userSelect.value = '';
                productSelect.value = '';
                statusSelect.value = '';
                startDateInput.value = '';
                endDateInput.value = '';
            });
        });
    </script>
@endsection
