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

                <div class="card space icon-relative">
                    <center><label class="label">Payment Total</label></center><br>
                    <div class="input-container">
                        <i class="fas fa-dollar-sign"></i>
                        <center><input type="text" class="input" value="{{ number_format($event_regist?->payment_total, 0, '.', '.') }}" readonly></center>
                    </div>
                </div><br>
                <div class="card space icon-relative">
                    <center><label class="label">Payment Method</label></center><br>
                    {{-- <i class="far fa-credit-card"></i> --}}
                    <div class="dropdown">
                        <center><button class="dropdown-btn">Select Payment</button></center>
                        <!-- Daftar dropdown -->

                        <div class="dropdown-content">
                            <form action="{{ route('updatePayment', $event_regist->id) }}" method="post">
                                @csrf
                                @method('put')
                                <select name="payment_types_id"
                                    class="form-select @error('payment_types_id') is-invalid @enderror">
                                    @foreach ($paymentTypes as $paymentType)
                                    @if ($paymentType === 0)
                                    @else
                                        <option value="{{ $paymentType->id }}">{{ $paymentType->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('payment_types_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!-- Tombol submit di sini -->
                                <input type="submit" value="Continue" class="btn" style="">
                            </form>
                        </div>
                        </center>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</body>
</html>
