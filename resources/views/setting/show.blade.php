<!doctype html>
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
        <div class="card mb-1" style="max-width: 100%; max-height: 600px; background-color:#F5F7F8;">
            <div class="row g-0">
                <div class="col-md-5">
                    <a href="{{ url('logo/' . $setting->logo) }}">
                        <img src="{{ url('logo/' . $setting->logo) }}" style="width: 55%;margin-left: 15px;margin-top:10px"
                            alt="Logo">
                    </a>
                </div>

                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title">Name : {{ $setting->name }}</h5>
                        <h5 class="card-title">History</h5>
                        <textarea name="history" cols="50" rows="3" style="border: none" readonly>{{ $setting->history }}</textarea>
                        <h5 class="card-title">Slogan</h5>
                        <textarea name="slogan" cols="50" rows="2" style="border: none" readonly>{{ $setting->slogan }}</textarea>
                        <h5 class="card-title">Desciption</h5>
                        <textarea name="desc" cols="50" rows="4" style="border: none" readonly>{{ $setting->desc }}</textarea><br><br>
                        <h5 class="card-title">Phone : {{ $setting->phone }}</h5>
                        <h5 class="card-title">Email : {{ $setting->email }}</h5>
                        <h5 class="card-title">WhatsApp Sender : {{ $setting->sender }}</h5>
                        <h5 class="card-title">WhatsApp End Point : {{ $setting->endpoint }}</h5>
                        <h5 class="card-title">WhatsApp API : {{ $setting->api_key }}</h5>
                        <a href="{{ route('setting.index') }}" class="btn btn-dark"
                            style="position: absolute; bottom: 2%; right: 2%;">Back</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</body>

</html>
