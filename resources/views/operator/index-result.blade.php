<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>{{$title->name}} | Results</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body" style="background-color:#c5e4f3;">
                <h1 class="text-center fs-2 mt-4">DATA RESULTS</h1>
                <h2 class="text-center fs-3 mt-4">{{ $event->name }}</h2>
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <a href="{{ route('resultop.create', ['event' => $event->id] ) }}" class="btn btn-dark m-1">Tambah</a>
                    </div>
                    <div class="col-auto">
                        <form action="{{ url('/eventsop') }}">
                            <button type="submit" class="btn btn-dark m-1">Kembali</button>
                        </form>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Participant</th>
                            <th>Berat Ikan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $result->user->name }}</td>
                            <td>{{ $result->weight }}</td>
                            <td>{{ $result->status }}</td>
                            <td>
                                <a href="{{ route('resultop.edit', ['event' => $event->id, 'result' => $result->id]) }}" class="btn btn-primary m-1">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
