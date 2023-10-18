<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Halaman Register</title>
  </head>
  <body>
    <div class="container">
        <h1>Register</h1>
        <form action="{{ route('register') }}" method="POST">
            @csrf
                <div class="col-lg-15 form-floating mb-3 ">
                    <input type="text" id="floatingInput" name="name"
                        class="form-control bg-light @error('name') is-invalid @enderror with-image"
                        placeholder="Username">

                    <label for="floatingInput" class="form-label">Username</label>
                    @error('name')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-15 form-floating mb-3 ">
                    <input type="text" id="floatingInput" name="email"
                        class="form-control bg-light @error('email') is-invalid @enderror with-image"
                        placeholder="email">

                    <label for="floatingInput" class="form-label">Email</label>
                    @error('email')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-15 form-floating mb-3 ">
                    <input type="password" id="password1" name="password" class="form-control bg-light @error('password') is-invalid @enderror" placeholder="Password">
                    <label for="floatingInput" class="form-label">Password</label>
                    <div class="eye" onclick="showHidePassword('password1', 'show1', 'hide1')">
                        <i id="show1" class="fa-solid fa-eye password-toggle"></i>
                        <i id="hide1" class="fa-solid fa-eye-slash password-toggle"></i>
                    </div>
                    @error('password')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-15 form-floating mb-3 ">
                    <input type="password" id="password2" name="password_confirmation" class="form-control bg-light @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                    <label for="floatingInput" class="form-label">Confirm Password</label>
                    <div class="eye" onclick="showHidePassword('password2', 'show2', 'hide2')">
                        <i id="show2" class="fa-solid fa-eye password-toggle"></i>
                        <i id="hide2" class="fa-solid fa-eye-slash password-toggle"></i>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            <div class="w-50 text-right">
                <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                </label>
            </div>
                <div class="form-group">
                    <input type="submit" value="Sign Up" class="form-control btn btn-success rounded submit px-3"></button>
                </div>

            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
          </form>
          <p class="text-wrapper-7">Sudah punya akun?<a href="{{ route('login')}}">Login</a></p>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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
