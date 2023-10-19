<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Add Event</title>
  </head>
  <body>

    <div class="container mt-5">
        <form action="{{ route("user.store") }}" method="post">
            @csrf
            @method('post')
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input value="{{ old('name')}}" name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input value="{{ old('email')}}" name="email" type="text" class="form-control @error('email') is-invalid @enderror">
                  @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input value="{{ old('password')}}" name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                  @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
  </body>
</html>

