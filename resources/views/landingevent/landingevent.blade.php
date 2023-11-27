<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landingevent.css') }}" />
    <title>Halaman Event</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <ul class="side-menu">
        <li>
            <a href="{{ route('logout') }}" class="logout">
                <i class='bx bx-log-out-circle'></i>
                Logout
            </a>
        </li>
    </ul>

    <div class="navbar">
        Event Ticket Booking
    </div>
    <h1 class="event-title">Events</h1>

    @if (Session::has('success'))
        <div class="alert custom-alert-success">
            <div class="blurry-background"></div>
            <div class="alert-content">
                <p>{{ Session::get('success') }} {{ Auth::user()->name }}</p>
            </div>
        </div>
    @endif
    <div class="container">
        @php
            $registeredEvents = [];
            $unregisteredEvents = [];
        @endphp

        @foreach ($events as $item)
            @if (!$item->members->contains(Auth::user()))
                <div class="item-container">
                    <div class="img-container">
                        <img src="{{ $item['image'] }}" alt="Event Image">
                    </div>
                    <div class="body-container">
                        <div class="overlay"></div>

                        <div class="event-info">
                            <p class="title">{{ $item['name'] }}</p>
                            <div class="separator"></div>
                            <p class="title">{{ $item['qualification'] }}</p>
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
                            <button class="action" onclick="bookEvent('{{ route('store-event-registration') }}', '{{ $item->id }}');">Book it</button>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <script>
        function bookEvent(url, eventId) {
            // Send an AJAX request to the server
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ event_id: eventId }),
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response from the server
                if (data.success) {
                    alert('Successfully registered for the event.');
                    // Optionally, you can update the UI to reflect the registration status
                } else {
                    alert('Failed to register for the event. ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>

</html>
