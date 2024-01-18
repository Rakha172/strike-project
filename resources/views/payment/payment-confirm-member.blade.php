<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Payment Checkout Form</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">

</head>


<body>

    <div class="wrapper">
        <div class="payment">
            <div class="payment-logo">
                <p>p</p>
            </div>

            <h2>Payment Confirm Page</h2>
            <p id="countdown"
                style="font-family: 'Arial', sans-serif; font-size: 18px; color: #D80032; text-align: center; margin-top: 20px;">
                Selesaikan Pembayaran Dalam <br> {{ $countdown['minutes'] }} menit {{ $countdown['seconds'] }} detik
            </p>

            <div class="card space icon-relative">
                <center><label class="label">Payment Total</label></center>
                <div class="input-container">
                    <input type="text" class="input-confirm"
                        value="{{ number_format($event_regist->payment_total, 0, '.', '.') }}" style="cursor: pointer"
                        readonly>
                    <i class="fas fa-dollar-sign" id="i"></i>
                </div>
            </div><br>
            <div class="card space icon-relative">
                @foreach ($paymentTypes as $item)
                    @if ($item->id == $event_regist->payment_types_id)
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <center><label class="label">the payment method you use :</label></center>
                            <div class="accordion-item">
                                <h5 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        {{ $item->name }}
                                    </button>
                                </h5>
                            </div>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    {{ $item->account_number }}
                                    <code></code>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </div>

    <script>
        function updateCountdown(minutes, seconds) {
            var countdownElement = document.getElementById('countdown');

            if (countdownElement) {
                countdownElement.innerHTML = 'Selesaikan Pembayaran Dalam  <br> ' + minutes + ' menit ' + seconds +
                    ' detik';
            }

            // Jika waktu sudah habis maka user akan di arahkan ke halaman awal
            if (minutes == 0 && seconds == 0) {
                // Redirect ke route "events"
                window.location.href = "{{ route('events') }}";
            }

            function updatePaymentStatus() {
                // Menggunakan AJAX untuk mengirim permintaan ke server Laravel
                // Sesuaikan route dan data yang dibutuhkan
                $.ajax({
                    url: "{{ route('updatePaymentStatus') }}", // Gantilah dengan nama route yang sesuai
                    method: 'POST',
                    data: {
                        event_regist_id: {{ $event_regist->id }},
                    },
                    success: function(response) {
                        // Redirect ke halaman events setelah mengupdate status pembayaran
                        window.location.href = "{{ route('events') }}";
                    },
                    error: function(error) {
                        console.error('Gagal memperbarui status pembayaran:', error);
                        // Redirect ke halaman events bahkan jika terjadi kesalahan
                        window.location.href = "{{ route('events') }}";
                    }
                });
            }
        }

        // Fungsi mengurangi waktu setiap detik
        function countdownTimer(minutes, seconds) {
            var totalSeconds = minutes * 60 + seconds;

            var interval = setInterval(function() {
                var currentMinutes = Math.floor(totalSeconds / 60);
                var currentSeconds = totalSeconds % 60;

                updateCountdown(currentMinutes, currentSeconds);

                totalSeconds--;

                if (totalSeconds < 0) {
                    clearInterval(interval);
                    // Memanggil fungsi untuk mengupdate status pembayaran
                    updatePaymentStatus();
                }
            }, 1000);
        }

        // Panggil countdownTimer saat dokumen siap
        document.addEventListener('DOMContentLoaded', function() {
            var minutes = {{ $countdown['minutes'] }};
            var seconds = {{ $countdown['seconds'] }};
            countdownTimer(minutes, seconds);
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
