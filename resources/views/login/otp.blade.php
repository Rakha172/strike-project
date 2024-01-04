<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <title>OTP Verification</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="overlay"></div>
    <form action="{{ route('login.otp.store')  }}" method="POST" class="box">
        @csrf
        <div class="header">
            <center><h4>OTP CODE</h4></center><br>
            <h6>Please enter your OTP code for registration</h6>

            <div class="text-center mt-2" id="otp-expiry">Your OTP code will expire in <span id="countdown" style="background: red">5:00</span> minutes</div>
        </div>
        <br>

        <div class="login area">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

            <input type="text" name="otp_code"  class="otp" placeholder="Enter OTP Code" required>
            <div class="form-group">
                <button type="submit" id="submitotp" class="form-control btn rounded submit px-3">Verify OTP</button>
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
