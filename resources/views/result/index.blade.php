<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Results</title>
  </head>
  <body>
    @extends('componen.layout')

    @section('content')


    <div class="container">
        <div class="card">
                <h1 class="text-center fs-2 mt-4">DATA RESULTS</h1>
            <div class="card-body">

    <a href="{{ route('result.create') }}" class="btn btn-dark">Tambah</a>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Participant</th>
                <th>Events Registration</th>
                <th>Berat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $loop->iteration }}</td>
                {{-- @if (auth()->check())
                <td>{{ auth()->user()->name }}</td>
                @endif --}}
                <td>{{ $result->user->name }}</td>
                <td>{{ $result->eventRegistration->event->name }}</td>
                <td>{{ $result->weight}} kg</td>
                <td>{{ $result->status }}</td>
                <td>
                    {{-- <a href="{{ route('results.show', $result->id) }}" class="btn btn-info">Detail</a> --}}
                    {{-- <a href="{{ route('result.update', $result->id) }}" class="btn btn-warning m-1">Edit</a> --}}

                    <form action="{{ route('result.destroy', $result->id) }}"method="POST">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-dark m-1">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
