<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{$title->name}} | Setting</title>
  </head>
  <body>
    @extends('componen.layout')
    @section('content')
    <div class="card mb-1" style="max-width: 100%; max-height: 400px; background-color:#F5F7F8;">
        <div class="row g-0">
            <div class="col-md-5">
                <img src="{{ url('logo/' . $setting->logo) }}" class="img-fluid rounded-start" alt="Logo">
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h5 class="card-title">Name : {{ $setting->name }}</h5>
                    <h5 class="card-title">History</h5>
                    <p class="card-text">{{ $setting->history }}</p>
                    <a href="{{ route('setting.index') }}" class="btn btn-dark" style="position: absolute; bottom: 2%; right: 2%;">Back</a>

                </div>
            </div>
        </div>
    </div>
@endsection
</body>
</html>
