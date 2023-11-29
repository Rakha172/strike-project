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
        <br>
        <button class="logout">
            <a href="{{ route('logout') }}" style="color: black;text-decoration: none;">
                Logout
            </a>
        </button>

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
            @if ($item->members->contains(Auth::user()))
                @php
                    $registeredEvents[] = $item;
                @endphp
            @else
                @php
                    $unregisteredEvents[] = $item;
                @endphp
            @endif
        @endforeach

        @foreach (array_merge($unregisteredEvents, $registeredEvents) as $item)
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

                    @if ($item->members->contains(Auth::user()))
                        <button class="action" disabled>Already Registered</button>
                    @else
                        <button class="action" onclick="daftarEvent('{{ $item['id'] }}')">Book it</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function daftarEvent(eventId) {
            const urlRegistrasi = "{{ route('event_registration.store') }}";
            const formulir = document.createElement('form');
            formulir.action = urlRegistrasi;
            formulir.method = 'post';

            const inputTokenCSRF = document.createElement('input');
            inputTokenCSRF.type = 'hidden';
            inputTokenCSRF.name = '_token';
            inputTokenCSRF.value = "{{ csrf_token() }}";
            formulir.appendChild(inputTokenCSRF);

            const inputEventId = document.createElement('input');
            inputEventId.type = 'hidden';
            inputEventId.name = 'event_id';
            inputEventId.value = eventId;
            formulir.appendChild(inputEventId);

            const inputUserId = document.createElement('input');
            inputUserId.type = 'hidden';
            inputUserId.name = 'user_id';
            inputUserId.value = "{{ auth()->user()->id }}";
            formulir.appendChild(inputUserId);

            document.body.appendChild(formulir);
            formulir.submit();
        }
    </script>
</body>

</html>
