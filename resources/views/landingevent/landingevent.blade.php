<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landingevent.css') }}" />
    <title>halaman event</title>

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
    <div class="navbar">
        Event Ticket Booking
    </div>

    <!-- Tambahkan judul nama event -->
    <h1 class="event-title">Events</h1>
    <div class="container">
        @foreach ($events as $item)
            <div class="item-container">
                <script>
                    @if (Session::has('success'))
                        toastr.info("{{ Session::get('success') }}", "User {{ Auth::user()->name }}", {
                        });
                    @elseif (Session::has('failed'))
                        toastr.error("{{ Session::get('error') }}", "Oops!", {
                        });
                    @endif
                </script>
                <div class="img-container">
                    <img src="{{ $item['image'] }}" alt="Event Image">
                </div>

                <div class="body-container">
                    <div class="overlay"></div>

                    <div class="event-info">
                        <p class="title">{{ $item['name'] }}</p>
                        <div class="separator"></div>
                        <p class="price">Rp. {{ number_format($item['price'], 0, '.', '.') }}</p>

                        <div class="additional-info">
                            <p class="info">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $item['location'] }}
                            </p>
                            <p class="info">
                                <i class="far fa-calendar-alt"></i>
                                {{ $item['event_date'] }}
                            </p>

                            <p class="info description">
                                {{ $item['description'] }}
                            </p>
                        </div>
                    </div>
                    <button class="action" onclick="window.location='{{ route('regisevent') }}';">Book it</button>
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
