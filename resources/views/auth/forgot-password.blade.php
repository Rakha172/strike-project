<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <div class="overlay"></div>
    <form action="{{ route('password.email') }}" method="POST" class="box">
        @csrf
        <div class="header">
            <h4>Forgot Your Password?</h4>
            <p>Please enter your email or WhatsApp number to request a password reset.</p>
        </div>
        <div class="login area">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <script>
                @if (session('status'))
                    toastr.error("{{ session('status') }}", "", {});
                @endif
            </script>
            <form action="{{ route('password.email') }}" method="post" id="form">
                @csrf
            <label for="email_or_whatsapp" style="color: #1f79ff;">Email or WhatsApp Number</label>
            <input type="text" name="email_or_whatsapp" id="email_or_whatsapp" value="{{ old('email_or_whatsapp') }}" class="form-control" style="border-color: #1f79ff;">
            <input type="submit" value="Request Password Reset" class="btn btn-primary" style="background: linear-gradient(to right, #1f79ff, #8ad2df); margin-top: 10px;">
        </div>
        <div class="text-center mt-1">
            <p class="text-wrapper-7 mb-5"><a href="{{ route('login') }}">Back To Login</a></p>
        </div>
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showHidePassword() {
            let passCheck = document.getElementById("password");
            let show = document.getElementById("show");
            let hide = document.getElementById("hide");

            if (passCheck.type == 'password') {
                passCheck.type = "text";
                show.style.display = "block";
                show.style.display = "block";
                hide.style.display = "none";
            } else {
                passCheck.type = "password";
                show.style.display = "none";
                hide.style.display = "block";
            }
        }
    </script>
</body>
</html>
