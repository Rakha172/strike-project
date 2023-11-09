<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landingevent.css') }}" />
    <title>Halaman Event</title>

</head>

<body>
    <div class="navbar">
        Event Ticket Booking
    </div>

    <!-- Tambahkan judul nama event -->
    <h1 class="event-title">Events</h1>

    @if (Session::has('success'))
        <div class="alert custom-alert-success">
            <div class="blurry-background"></div>
            <div class="alert-content">
                <p>{{ Session::get('success') }} '{{ Auth::user()->name }}'</p>
            </div>
        </div>
    @endif

    <div class="container">
        @foreach ($events as $item)
            <div class="item-container">
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
