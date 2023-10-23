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
    @extends('componen.layout')

    @section('content')


    <div class="container">
        <div class="card">
                <h1 class="text-center fs-2 mt-4">DATA EVENTS</h1>
            <div class="card-body">

        <a href="{{ route('event.create')}}" class="btn btn-dark">Tambah</a>

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
                <th scope="col">Category</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($events as $key => $evnt)
              <tr>
                <td>{{ $evnt->name }}</td>
                <td><img src="{{ asset($evnt->image) }}" width="100"></td>
                <td>{{ $evnt->price }}</td>
                <td>{{ $evnt->total_booth }}</td>
                <td>{{ $evnt->event_date }}</td>
                <td>{{ $evnt->location }}</td>
                <td>{{ $evnt->description }}</td>
                <td>{{ $evnt->category }}</td>
                <td>
                <td class="d-flex">
                    <a href="{{ route('event.edit', $evnt->id) }}" class="btn btn-warning m-1">Edit</a>

                    <form action="{{ route('event.destroy', $evnt->id)}}"method="POST">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-dark m-1">Delete</button>
                    </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
    {{-- <td colspan="n">
        <div style="text-align: center;"> --}}

    @endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>
