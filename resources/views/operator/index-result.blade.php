<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Operator Result</title>
    <link rel="stylesheet" href="{{ asset('css/operator.css') }}">
</head>
<body>
    <div class="containerop">
        <nav class="wrapperop">
            <div class="brandop">
                <div class="firstname">Strike</div>
                <div class="lastname">Project</div>
            </div>
            <center>
                <h2 class="hlop">Halaman Result Operator</h2>
            </center>
            <ul class="nav">
                    <form action="{{ url('/eventsop') }}">
                        <button class="button button1" style="color: white">Kembali</button>
                    </form>
            </ul>
        </nav><br><br>

        <div class="card" style="width: 80%;margin:auto;">
            <div class="card-body" style="background-color: lightblue;">
                <h1 class="text-center fs-2 mt-4">DATA RESULTS</h1>
                <h2 class="text-center fs-3 mt-4">{{ $event->name }}</h2>
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <a href="{{ route('resultop.create', ['event' => $event->id] ) }}" class="btn btn-dark m-1">Tambah</a>
                        <a href="{{ route('operator.winner', ['eventId' => $event->id]) }}" class="btn btn-success m-1">Winner</a>
                    </div>
                    </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Participant</th>
                            <th>Berat Ikan</th>
                            <th>Status</th>
                            <th>Pict</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results->sortByDesc('created_at') as $result)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $result->user->name }}</td>
                            <td>{{ $result->weight }}</td>
                            <td>{{ $result->status }}</td>
                            <td>
                                @if($result->image_path)
                                    <img src="{{ asset($result->image_path) }}" style="max-width: 100px; max-height: 100px;" alt="Result Image">
                                @else
                                    No Image
                                @endif
                            </td>
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
