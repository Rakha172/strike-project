<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{$title->name}} | Events</title>
  </head>
  <body>
    <div class="container"><br>
        <div class="card" style="background: rgb(211, 233, 241);">
            <form action="{{route('logout')}}">
                <button style="width: 80px;margin-top:80px;margin-left:10px;background:red;color:white;border-radius:10px">
                    Logout
                </button>
                <h1 class="text-center fs-2 mt-1">Halaman Operator Event</h1>
            <div class="card-body">
        @if ($pesan = session('berhasil'))
        <div class="alert alert-primary" role="alert">
           {{ $pesan }}
        </div>
        @endif
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Total Booth</th>
                <th scope="col">Event Date</th>
                <th scope="col">Location</th>
                <th scope="col">Description</th>
                <th scope="col">Option</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($events as $key => $evnt)
              <tr>
                <td>{{ $evnt->name }}</td>
                <td><img src="{{ asset($evnt->image) }}" width="100"></td>
                <td>Rp. {{ number_format($evnt->price, 0, '.', '.')}}</td>
                <td>{{ $evnt->total_booth }}</td>
                <td>{{ $evnt->event_date }}</td>
                <td>{{ $evnt->location }}</td>
                <td>
                    {{ strlen($evnt->description) > 100 ? substr($evnt->description, 0, 100) . '...' : $evnt->description }}
                </td>
                <td>
			        <a href="{{ route('resultop.index', $evnt->id) }}" class="btn btn-dark m-1">Result</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</body>
</html>
