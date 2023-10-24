<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row" style="margin:20px">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Event Registration</h2>
                    </div>
                    <div class="card-body">

                        @if ($pesan = session('Berhasil'))
                            <div class="alert alert-primary" role="alert">
                                {{ $pesan }}
                            </div>
                        @endif

                        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                            <a href="/"
                                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                                <svg class="bi me-2" width="40" height="32">
                                    <use xlink:href="#bootstrap" />
                                </svg>
                            </a>
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a href="{{ route('event_registration.create') }}"
                                        class="nav-link active" aria-current="page">Add</a></li>
                                {{-- <li class="nav-item"><a href="{{ ('sesi/logout') }}" class="nav-link">Logout</a></li> --}}
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
                                        <tr style="background: darkgrey">
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->event->name }}</td>
                                            <td>{{ $item->event_registration->payment_status }}</td>
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
</body>

</html>
