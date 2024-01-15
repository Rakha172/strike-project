<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $title->name }} | Operator</title>
</head>

<body>
    @extends('componen.layout')

    @section('content')
        <div class="container">

            <script>
                @if (Session::has('success'))
                    toastr.info("{{ Session::get('success') }}", "{{ Auth::user()->name }}", {});
                @endif
            </script>

            <div class="card" style="background-color:#F5F7F8;">
                <h1 class="text-center fs-2 mt-4">DATA EVENT</h1>
                <div class="card-body">
                    </nav><br><br>
                    <div class="table-responsive">
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
                                            <td><a href="{{ asset($evnt->image) }}">
                                                    <img src="{{ asset($evnt->image) }}" width="100">
                                                </a>
                                            </td>
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
                                                    class="btn btn-success m-1">Result</a>

                                                @if ($evnt->qualification == 'weight')
                                                    <a href="{{ route('events.chart-result', $evnt->id) }}"
                                                        class="btn btn-primary m-1">Chart Result</a>
                                                @elseif ($evnt->qualification == 'quantity')
                                                    <a href="{{ route('events.chart-total', $evnt->id) }}"
                                                        class="btn btn-primary m-1">Chart Result</a>
                                                @elseif ($evnt->qualification == 'special')
                                                    <a href="{{ route('events.chart-special', $evnt->id) }}"
                                                        class="btn btn-primary m-1">Chart Result</a>
                                                @elseif ($evnt->qualification == 'weight_special')
                                                    <a href="{{ route('events.chart-result-and-special', $evnt->id) }}"
                                                        class="btn btn-primary m-1">Chart Result</a>
                                                @elseif ($evnt->qualification == 'weight_quantity')
                                                    <a href="{{ route('events.chart-result-and-total', $evnt->id) }}"
                                                        class="btn btn-primary m-1">Chart Result</a>
                                                @elseif ($evnt->qualification == 'quantity_special')
                                                    <a href="{{ route('events.chart-result-and-total-special', $evnt->id) }}"
                                                        class="btn btn-primary m-1">Chart Result</a>
                                                @else
                                                    <a href="{{ route('events.chart-combined', $evnt->id) }}"
                                                        class="btn btn-primary m-1">Chart Result</a>
                                                @endif
                                                <a href="{{ route('operator.attended', $evnt->id) }}"
                                                    class="btn btn-warning m-1">Attended</a>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endsection

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function confirmLogout() {
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        text: 'Apakah Anda yakin ingin keluar?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#18537a',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Logout!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('logout') }}";
                        }
                    });
                }
            </script>
</body>

</html>
