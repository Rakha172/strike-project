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
    <div class="body-card">
        <form action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="header">
                    <h4>Change Password</h4>
                    <p>Please enter your new password</p>
                </div>
                <div class="login area">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
                    <script>
                        @if (session('status'))
                            toastr.error("{{ session('status') }}", "", {});
                        @endif
                    </script>
                <div class="form">
                    <input type="hidden" name="token" value="{{ request()->token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">
                    <input type="hidden" name="phone_number" value="{{ request()->phone_number }}">
                    <div class="inputfield">
                        <label for="password">New Password</label>
                        <div class="password-container">
                            <input type="password" name="password" id="password" class="input"
                                placeholder="New Password">
                            <i class="fa fa-eye password-toggle" id="showPassword"></i>
                        </div>
                    </div>
                    <br>
                    <div class="inputfield">
                        <label for="password">Confirm Password</label>
                        <div class="password-container">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="input" placeholder="Confirm Password">
                            <i class="fas fa-eye-slash password-toggle" id="showConfirmPassword"></i>
                        </div>
                    </div>
                    <br>
                    <div class="inputfield">
                        <input type="submit" value="Update Password" class="btn">
                    </div>
                </div>
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
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        const showPassword = document.getElementById('showPassword');
        const showConfirmPassword = document.getElementById('showConfirmPassword');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        showPassword.addEventListener('click', function() {
            togglePasswordVisibility(passwordInput, showPassword);
        });

        showConfirmPassword.addEventListener('click', function() {
            togglePasswordVisibility(confirmPasswordInput, showConfirmPassword);
        });

        function togglePasswordVisibility(input, icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
    <script>
        Let passwordInput = document.getElementById('txtPassword'),
            toogle = document.getElementById('btnToogle'),
            icon = document.getElementById('eyeIcon');

        function togglePassword() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = 'password';
                icon.classList.remove("fa-eye-slash");
            }
        }

        function checkInput() {}

        toggle.addEventListener('click', togglePassword, false);
        toggle.addEventListener('keyup', checkInput, false);
    </script>
</body>

</html>
