@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    @if(auth()->user()->role_id == '3')
        @include('orders.userOrder')
    @else
        @include('orders.adminOrder')
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
                    if (targetStatus !== 1){
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
                            var alarmSound = new Audio("{{ asset('caykoy.mp3') }}");
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

        function archiveFunction(event) {
            event.preventDefault(); // prevent form submit
            var form = document.getElementById('delete-form'); // Get the form by its ID
            swal({
                    title: "Sipariş Siliniyor",
                    text: "Bu işlemi yapmak istediğinize emin misiniz?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sil",
                    cancelButtonText: "Geri Dön",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        form.submit(); // Submit the form when the user presses "Sil"
                    } else {
                        swal("", "Sipariş silme işlemi iptal edildi", "error");
                    }
                });
        }

    </script>
@endsection
