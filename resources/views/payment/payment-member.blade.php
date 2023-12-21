<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Checkout Form</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">

</head>

<body>

    <div class="wrapper">
        <div class="payment">
            <div class="payment-logo">
                <p>p</p>
            </div>

            <h2>Payment Page</h2>
            <div class="form">
                <div class="card space icon-relative">
                    <label class="label">Username</label>
                    <input type="text" class="input" value="{{ Auth::user()->name }}" readonly>
                    <i class="fas fa-user"></i>
                </div>
                <div class="card space icon-relative">
                    <label class="label">Payment Total</label>
                    {{-- @foreach ($event_regist as $event) --}}
                        <input type="text" class="input" value="{{ $event_regist?->event->price }}" readonly>
                        <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card space icon-relative">
                    <label class="label">Payment Method</label>
                    {{-- <i class="far fa-credit-card"></i> --}}
                    <div class="dropdown">
                        <button class="dropdown-btn">Pilih Pembayaran</button>

                        <!-- Daftar dropdown -->
                        <div class="dropdown-content">
                            <input type="text" name="payment_method" id="" value="{{$event_regist?->payment_types_id}}" readonly>
                        </div>
                    </div>
                    {{-- @endforeach --}}
                </div>

                </div>
                <center>
                    <input type="submit" value="PAY" class="btn">
                </center>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</body>

</html>
