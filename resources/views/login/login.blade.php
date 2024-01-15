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

    <title>{{ $title->name }} | Halaman Login</title>
</head>
{{-- JS Toastr Link --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>
    <div class="overlay"></div>
    <form action="{{ route('login') }}" method="POST" class="box">
        @csrf
        <div class="header">
            <h4>Login To Your Account</h4>
            <p>Welcome, Please sign in!</p>
        </div>
        <br>

        <div class="login area">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <script>
                @if (session('status'))
                    toastr.info("{{ session('status') }}", "", {});
                @endif
            </script>

            <script>
                @if (session('logout'))
                    toastr.info("{{ session('logout') }}", "", {});
                @endif
            </script>

            <script>
                @if (session('success'))
                    toastr.info("{{ session('success') }}");
                @endif
            </script>

            @error('email_or_phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
                <script>
                    toastr.error("{{ $message }}");
                </script>
            @enderror

            @error('otp')
                <div class="invalid-feedback">{{ $message }}</div>
                <script>
                    toastr.error("{{ $message }}");
                </script>
            @enderror

            <input type="text" name="email_or_phone_number" class="email" placeholder="Masukkan Email/Nomor Telepon" required>

            <div class="password-container">
                <input type="password" name="password" class="password" id="password" placeholder="Masukkan Password"
                    required>
                <span class="show-password" onclick="showHidePassword('password')">
                    <i class="fa-solid fa-eye password-toggle"></i>
                </span>
            </div>

            <a href="{{ route('password.request') }}">Forgot password?</a>

            <div class="form-group">

                <input type="submit" value="Sign In" class="form-control btn rounded submit px-3">
            </div>
            <p class="text-wrapper-7">Tidak punya akun?<a href="{{ route('register') }}">Regist disini</a></p>
        </div>
    </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
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
