<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{$title->name}} | Add Setting</title>
  </head>
  <body>
    @extends('componen.layout')

    @section('content')

    <div class="container mt-5">
        <div class="card">
            <h1 class="text-center fs-2 mt-4">DATA SETTING</h1>
        <div class="card-body">

        <form action="{{ route("setting.store") }}" method="post" enctype="multipart/form-data">
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
                <label class="form-label">Location</label>
                <input value="{{ old('location')}}" name="location" type="text" class="form-control @error('location') is-invalid @enderror">
                  @error('location')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

            <p class="text ps-4">Image</p>
            <div class="form-group">
                <input value="{{ old('image') }}" type="file" id="image" name="image" accept="image/*"
                    class="form-control-file @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">History</label>
                <input value="{{ old('history')}}" name="history" type="text" class="form-control @error('history') is-invalid @enderror">
                  @error('history')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
            <button type="submit" class="btn btn-dark">Submit</button>
          </form>
    </div>
    @endsection
  </body>
</html>


