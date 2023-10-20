<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Events</title>
  </head>
  <body>
    <div class="container mt-5">
        <center>
            <h2>Crud Setting</h2>
        </center>
        <div class="card" style="background: rgb(99, 212, 250)">
            <div class="card-body">
                @if ($pesan = session('info'))
                    <div class="alert alert-secondary" role="alert">
                        {{ $pesan }}
                    </div>
                @endif
                <div class="table-responsive mt-3 rounded">
                    <table class="table table-hover table-bordered table-stripped" style="background-color: darkgrey"
                        id="example2">
                        <thead style="width: 100px">
                            <th>#</th>
                            <th>Name</th>
                            <th>History</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($setting as $no => $hasil)
                                <tr>
                                    <th>{{ $no + 1 }}</th>
                                    <td>{{ $hasil->name }}</td>
                                    <td>
                                        <a href="{{ asset('logo/' . $hasil->logo) }}">
                                            <img style="max-width:200px;max-height:200px;"src="{{ asset('logo/' . $hasil->logo) }}">
                                        </a>
                                    </td>
                                    <td>{{ $hasil->history }}</td>
                                    <td>
                                        <a href="{{ url('setting/' . $hasil->id . '/show') }}"
                                            class="btn btn-primary">Read</a>
                                        <a href="{{ route('setting.edit', $hasil->id) }}"
                                            class="btn btn-warning">Edit</a>
                                    </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>

