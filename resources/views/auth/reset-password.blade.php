<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>

  <!-- Tambahkan Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
  <div class="container">
    <div class="confirm-wrap p-4 p-md-5">
      <div class="overlap">
        <div class="w-1">
          <h3 class="mb-4 text-center">RESET<br>PASSWORD</h3>
          <p class="mb-4 text-center">Buatlah password baru Anda!</p>
        </div>

        <form action="{{ route('password.update', ['token' => $token ]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="token" value="{{request()->token}}">
          <input type="hidden" name="email" value="{{request()->email}}">

          <div class="overlap-1">
            <div class="rectangle">
              <div class="form-floating mb-3">
                <input type="password" id="floatingInput" name="password" class="form-control bg-light @error('password') is-invalid @enderror with-image" placeholder="Password">
                <label for="floatingInput">New Password</label>
                @error('name')
                <div class="invalid-feedback text-start">
                  {{ $message }}
                </div>
                @enderror
                <img src="{{ asset('img/login/padlock-1.png') }}" alt="" class="input-image">
              </div>
            </div>
          </div>

          <div class="overlap-2">
            <div class="rectangle">
              <div class="form-floating mb-3">
                <input type="password" id="floatingInput" name="password_confirmation" class="form-control bg-light @error('password') is-invalid @enderror" placeholder="Password">
                <label for="floatingInput">Confirm New Password</label>
                @error('password')
                <div class="invalid-feedback text-start">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="form-group">
            <input type="submit" value="Reset Password" class="form-control btn btn-success rounded submit px-3">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Tambahkan Bootstrap JavaScript (jika diperlukan) -->

</body>
</html>
