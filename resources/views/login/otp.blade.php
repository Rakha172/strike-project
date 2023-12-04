<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">OTP CODE</h2>
                        <p class="text-center">Please enter your OTP code for registration</p>
                        <form action="{{ route('login.otp.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="otp_code" class="sr-only">OTP Code</label>
                                <input type="text" class="form-control" name="otp_code" placeholder="Enter OTP Code">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-block">Verify OTP</a>
                            </div>
                            @error('otp_code')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </form>
                        <div class="text-center mt-3" id="otp-expiry">Your OTP code will expire in <span id="countdown">5:00</span> minutes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function startCountdown(duration, display) {
            let timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    display.textContent = "Expired";
                }
            }, 1000);
        }

        window.onload = function () {
            let countdown = 300;
            let display = document.querySelector('#countdown');
            startCountdown(countdown, display);
        };
    </script>
</body>
</html>
