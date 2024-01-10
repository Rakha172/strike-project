<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Setting</title>
</head>

<body>
    @extends('componen.layout')
    @section('content')
        <div class="container mt-3">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-5">
                        <a href="{{ url('logo/' . $setting->logo) }}">
                            <img src="{{ url('logo/' . $setting->logo) }}" class="img-fluid" alt="Logo">
                        </a>
                    </div>

                    <div class="col-12 col-md-7">
                        <div class="card-body">
                            <h5 class="card-title">Name</h5>
                            <input readonly type="text" value="{{ $setting->name }}" class="form-control bg-light" />

                            <h5 class="card-title">History</h5>
                            <input readonly type="text" value="{{ $setting->history }}" class="form-control bg-light" />

                            <h5 class="card-title mt-2">Slogan</h5>
                            <input readonly type="text" value="{{ $setting->slogan }}" class="form-control bg-light" />

                            <h5 class="card-title mt-2">Description</h5>
                            <input readonly type="text" value="{{ $setting->desc }}" class="form-control bg-light" />

                            <h5 class="card-title mt-2">Phone</h5>
                            <input readonly type="text" value="{{ $setting->phone }}" class="form-control bg-light"/>

                            <h5 class="card-title mt-2">Email</h5>
                            <input readonly type="text" value="{{ $setting->email }}" class="form-control bg-light" />

                            <h5 class="card-title mt-2">WhatsApp Sender</h5>
                            <input readonly type="text" value="{{ $setting->sender }}" class="form-control bg-light" />

                            <h5 class="card-title mt-2">WhatsApp End Point</h5>
                            <input readonly type="text" value="{{ $setting->endpoint }}" class="form-control bg-light" />

                            <h5 class="card-title mt-2">WhatsApp API</h5>
                            <input readonly type="text" value="{{ $setting->api_key }}" class="form-control bg-light" />

                            <a href="{{ route('setting.index') }}" class="btn btn-dark mt-3">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
