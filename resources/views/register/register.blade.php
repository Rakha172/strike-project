<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <title>{{ $title->name }} | Halaman Register</title>

    {{-- CSS Toastr Link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"    />

    {{-- Cdn Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</head>
{{-- JS Toastr Link --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>
    <div class="overlay"></div>
    <form action="{{ route('register') }}" method="POST" class="box">
        @csrf
        <div class="header">
            <h4>Create an account first</h4>
            <p>Welcome, Please register!</p>
        </div>
        <div class="login area">
            <input type="text" name="name" class="name" placeholder="Masukkan Nama" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                <script>
                    toastr.error("{{ $message }}");
                </script>
            @enderror

            <input type="number" name="phone_number" class="phone_number" placeholder="Masukkan Nomor Telepon"
                required>
            @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
                <script>
                    toastr.error("{{ $message }}");
                </script>
            @enderror

            <input type="text" name="email" class="email" placeholder="Masukkan Email" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                <script>
                    toastr.error("{{ $message }}");
                </script>
            @enderror

            <div class="password-container">
                <input type="password" name="password" class="password" id="password" placeholder="Masukkan Password"
                    required>
                <span class="show-password" onclick="showHidePassword('password')">
                    <i class="fa-solid fa-eye password-toggle"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                <script>
                    toastr.error("{{ $message }}");
                </script>
            @enderror


            <div class="password-container">
                <input type="password" name="password_confirmation" class="password" id="password-confirmation"
                    placeholder="Confirm Password" required>
                <span class="show-password" onclick="showHidePassword('password-confirmation')">
                    <i class="fa-solid fa-eye password-toggle"></i>
                </span>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                <script>
                    toastr.error("{{ $message }}");
                </script>
            @enderror

            <div class="form-group">
                <input type="submit" value="Sign Up" class="form-control btn btn-success rounded submit px-3">
            </div>
            <p class="text-wrapper-7">Sudah punya akun?<a href="{{ route('login') }}">Login</a></p>
        </div>
    </form>

    <script>
        function showHidePassword(passwordId, showId, hideId) {
            let passCheck = document.getElementById(passwordId);
            let show = document.getElementById(showId);
            let hide = document.getElementById(hideId);

            if (passCheck.type == 'password') {
                passCheck.type = "text";
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
