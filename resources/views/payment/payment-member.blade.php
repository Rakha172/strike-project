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
                    <label class="label">Payment Total</label>
                    {{-- @foreach ($event_regist as $event) --}}
                    <input type="text" class="input" value="{{ number_format($event_regist?->event->price, 0, '.', '.') }}" readonly>
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card space icon-relative">
                    <label class="label">Payment Method</label>
                    {{-- <i class="far fa-credit-card"></i> --}}
                    <div class="dropdown">
                        <button class="dropdown-btn">Pilih Pembayaran</button>

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
                                <input type="submit" value="Lanjut" class="btn">
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
