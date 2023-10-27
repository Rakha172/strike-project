<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Edit setting</title>
</head>

<body style="background: lightgrey">
    <div class="container mt-5 border border-3 border-dark">
        <center>
            <h3>Edit Setting</h3>
        </center>
        <form action="{{ route('setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input value="{{ old('name', $setting->name) }}" name="name" type="text"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">History</label>
                <textarea name="history" type="text" class="form-control @error('history') is-invalid @enderror">{{ old('history', $setting->history) }}"</textarea>
                @error('history')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">

                <label for="logo" class="form-label">Logo</label>
                <img style="max-width:150px;max-height:150px;"src="{{ asset('logo/' . $setting->logo) }}">
                <input type="file" name="logo" class="form-control bg-light @error('logo') is-invalid @enderror"
                    value="{{ old('logo', $setting->logo) }}">
                @error('logo')
                    <div class="invalid-feedback text-start">
                        <b>{{ $message }}</b>
                    </div>
                @enderror

                <br>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input value="{{ old('location', $setting->location) }}" name="location" type="text" class="form-control @error('location') is-invalid @enderror">
                      @error('location')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>


                <br>

                <center>
                    <input value="Update Data" type="submit"
                        style="background-color: darkgrey;border-radius:15px;width:400px;"></br>
                </center>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>
