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

<div class="container">
    <div class="card">
        <h2 class="card-header text-center">SETTING</h2>
        <div class="card-body">
            @if ($pesan = session('info'))
                <div class="alert alert-primary" role="alert">
                    {{ $pesan }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">History</th>
                            <th scope="col">Slogan</th>
                            <th scope="col">Description</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">WhatsApp Sender</th>
                            <th scope="col">WhatsApp End Point</th>
                            <th scope="col">WhatsApp API</th>
                            <th scope="col">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($setting as $key => $sett)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $sett->name }}</td>
                                <td>
                                    <a href="{{ asset('logo/' . $sett->logo) }}" target="_blank">
                                        <img src="{{ asset('logo/' . $sett->logo) }}" class="img-fluid" style="max-width:200px;max-height:200px;">
                                    </a>
                                </td>
                                <td>{{ $sett->history }}</td>
                                <td>{{ $sett->slogan }}</td>
                                <td>{{ $sett->desc }}</td>
                                <td>{{ $sett->phone }}</td>
                                <td>{{ $sett->email }}</td>
                                <td>{{ $sett->sender }}</td>
                                <td>{{ $sett->endpoint }}</td>
                                <td>{{ $sett->api_key }}</td>
                                <td>
                                    <a href="{{ url('setting/' . $sett->id . '/show') }}" class="btn btn-dark m-1">Read</a>
                                    <a href="{{ route('setting.edit', $sett->id) }}" class="btn btn-info m-1">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>
