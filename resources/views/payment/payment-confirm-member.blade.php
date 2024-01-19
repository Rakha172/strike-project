<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Payment Checkout Form</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>


<body>

    <div class="wrapper">
        <div class="payment">
            <div class="payment-logo">
                <p>p</p>
            </div>

            <h2>Payment Confirm Page</h2>

            <div>
                <center><h4>selesaikan pembayaran dalam</h4></center>
                <div id="countdown" style="color: red"></div><br>
            </div>

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
        $(document).ready(function() {
            var remainingTime = {{ $remainingTime }};

            function updateCountdown() {
                var minutes = Math.floor(remainingTime / 60);
                var seconds = remainingTime % 60;

                $('#countdown').html(minutes + ' menit, ' + seconds + ' detik');

                if (remainingTime > 0) {
                    remainingTime--;
                    setTimeout(updateCountdown, 1000);
                } else {
                    // Redirect ke halaman events jika countdown berakhir
                    window.location.href = "{{ route('events') }}";
                }
            }

            updateCountdown();
        });
    </script>



    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
