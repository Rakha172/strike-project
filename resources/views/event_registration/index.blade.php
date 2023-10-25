<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>EventRegist</title>
  </head>
  <body>
    @extends('componen.layout')

    @section('content')

    <div class="container">
        <div class="card">
            <h1 class="text-center fs-2 mt-4">DATA EVENTREGIST</h1>
            <div class="card-body">
                        @if ($pesan = session('Berhasil'))
                            <div class="alert alert-primary" role="alert">
                                {{ $pesan }}
                            </div>
                        @endif

                            <ul class="nav nav-pills">
                                <li class="nav-item"><a href="{{ ('sesi/logout') }}" class="nav-link">Logout</a></li>
                            </ul>
                        </header>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Users_Name</th>
                                        <th scope="col">Event_Name</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event_registration as $key => $item)
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->event->name }}</td>
                                            <td>{{ $item->payment_status }}</td>
                                            <td class="d-flex">
                                                <a href="{{ route('event_registration.edit', $item->id) }}"
                                                    class="btn btn-warning m-1">Edit</a>

                                                <form
                                                    action="{{ route('event_registration.destroy', $item->id) }}"method="POST">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="submit" class="btn btn-dark m-1" onclick="return('yakin mau di hapus?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>
