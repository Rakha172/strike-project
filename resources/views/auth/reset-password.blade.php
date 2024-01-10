<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    {{-- CSS Toastr Link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Cdn Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <title>Strike | Reset Password Page</title>
</head>
{{-- JS Toastr Link --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>
    <div class="overlay"></div>
    <form action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data" class="box">
        @csrf
        <div class="header">
            <h3>Change Password</h3>
            <h6 style="font-weight:bold">Please Enter Your New Password</h6>
        </div>
        <br>

        <div class="login area">

            <input type="hidden" name="token" value="{{ request()->token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">
            <input type="hidden" name="phone_number" value="{{ request()->phone_number }}">

            <div class="password-container">
                <input type="password" name="password" class="password" id="password" placeholder="New Password"
                    required>
                <span class="show-password">
                    <i class="fa-solid fa-eye password-toggle" id="showPassword"></i>
                </span>
            </div>

            <div class="password-container">
                <input type="password" name="password_confirmation" class="password" id="password_confirmation"
                    placeholder="Masukkan Password" required>
                <span class="show-password">
                    <i class="fa-solid fa-eye password-toggle" id="showConfirmPassword"></i>
                </span>
            </div>

            <div class="form-group">
                <input type="submit" value="Update" class="form-control btn rounded submit px-3">
            </div>
        </div>
    </form>

    </div>
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
