<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Events</title>

    {{-- CSS Toastr Link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Cdn Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

</head>

{{-- JS Toastr Link --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>
    <div class="container"><br>
        <div class="card" style="background: rgb(211, 233, 241);">

            <script>
                @if (Session::has('success'))
                    toastr.info("{{ Session::get('success') }}", "{{ Auth::user()->name }}", {});
                @endif
            </script>

            <form action="{{ route('logout') }}">
                <button
                    style="width: 80px;margin-top:30px;margin-left:10px;
                               background:red;color:white;border-radius:10px">
                    Logout
                </button>
            </form>
            <h1 class="text-center fs-2 mt-1">Halaman Operator Event</h1><br>
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
                            <th scope="col">Start</th>
                            <th scope="col">End</th>
                            <th scope="col">Location</th>
                            <th scope="col">Qualification</th>
                            <th scope="col">Description</th>
                            <th scope="col">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $key => $evnt)
                            @php
                                $eventDate = \Carbon\Carbon::parse($evnt->event_date)->format('Y-m-d');
                                $today = \Carbon\Carbon::now()->format('Y-m-d');
                            @endphp
                            @if ($eventDate == $today)
                                <tr>
                                    <td>{{ $evnt->name }}</td>
                                    <td><img src="{{ asset($evnt->image) }}" width="100"></td>
                                    <td>Rp. {{ number_format($evnt->price, 0, '.', '.') }}</td>
                                    <td>{{ $evnt->total_booth }}</td>
                                    <td>{{ $evnt->event_date }}</td>
                                    <td>{{ $evnt->start }}</td>
                                    <td>{{ $evnt->end }}</td>
                                    <td>{{ $evnt->location }}</td>
                                    <td>{{ $evnt->qualification }}</td>
                                    <td>
                                        {{ strlen($evnt->description) > 100 ? substr($evnt->description, 0, 100) . '...' : $evnt->description }}
                                    </td>
                                    <td>
                                        <a href="{{ route('resultop.index', $evnt->id) }}"
                                            class="btn btn-dark m-1">Result</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
