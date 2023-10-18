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

    <title>Halaman Login</title>
  </head>
  <body>
    <div class="container">
        <h1>Login</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="col-lg-15 form-floating mb-3 ">
                <input type="text" id="floatingInput" name="email" class="form-control bg-light @error('email') is-invalid @enderror" placeholder="Email">
                <label for="floatingInput" class="form-label">Email</label>
                @error('email')
                    <div class="invalid-feedback text-start">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-15 form-floating mb-3 ">
                <input type="password" id="password" name="password" class="form-control bg-light @error('password') is-invalid @enderror" placeholder="Password">
                <label for="floatingInput" class="form-label">Password</label>
                <div class="eye" id="eyePosition" onclick="showHidePassword()">
                    <i id="show" class="fa-solid fa-eye password-toggle"></i>
                    <i id="hide" class="fa-solid fa-eye-slash password-toggle"></i>
                </div>
                @error('password')
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

                <div class="text-wrapper-8  text-end">
                    <a href="{{ route('password.request')}}">Forgot password?</a>
                </div>

                <div class="form-group">
                    <input type="submit" value="Sign In" class="form-control btn btn-success rounded submit px-3">
                </div>
                <div class="form-group d-md-flex">

                <br>
                <p class="text-wrapper-7">Tidak punya akun?<a href="{{ route('register')}}">Regist disini</a></p>
                </div>


            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
          </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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
