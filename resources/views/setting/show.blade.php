<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .card-body{
            color: black
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="card" style="margin:20px;background: #7D7C7C">
        <h3><div class="card-header" style="color: white">Setting Page</div></h3>
        <div class="card-body">
            <h5 class="card-title">Name : {{ $setting->name }}</h5>
            <h5 class="card-title">History: </h5>
            <h6>
                <textarea name="history" style="width: 1000px;background: #7D7C7C">{{ $setting->history }}</textarea>
            </h6>
            
            <h5 class="card-title">Logo :
                <a href="{{ url('logo/' . $setting->logo) }}" title="click here!">
                    <img style="max-width:200px;max-height:200px;" src="{{ url('logo/' . $setting->logo) }}">
                </a>
            </h5>

            <a href="{{ route('setting.index') }}" class="btn btn-secondary">Back</a>
        </div>

    </div>
</body>
</html>
