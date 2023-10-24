<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landingevent.css') }}" />
    <title>halaman event</title>
</head>
<body>
    <div class="navbar">
        Event Ticket Booking
    </div>

    <!-- Tambahkan judul nama event -->
    <h1 class="event-title">Events</h1>

    <div class="container">
        <div class="item-container">
            <div class="img-container">
                @foreach ($events as $item)
                    <img src="{{ $item['image'] }}" alt="Event Image">
                @endforeach
            </div>

            <div class="body-container">
                <div class="overlay"></div>

                @foreach ($events as $item)
                <div class="event-info">
                    <p class="title">{{ $item['name'] }}</p>
                @endforeach
                    <div class="separator"></div>
                    {{-- <p class="info">Flie Fishing</p> --}}
                    @foreach ($events as $item)
                    <p class="price">{{ $item['price'] }}</p>
                    @endforeach

                    <div class="additional-info">
                        <p class="info">
                            <i class="fas fa-map-marker-alt"></i>
                            @foreach ($events as $item)
                                    {{ $item['location'] }}
                                @endforeach
                        </p>
                            <p class="info">
                                <i class="far fa-calendar-alt"></i>
                                @foreach ($events as $item)
                                    {{ $item['event_date'] }}
                                @endforeach
                            </p>

                        <p class="info description">
                            @foreach ($events as $item)
                            {{ $item['description'] }}
                        @endforeach
                        </p>
                    </div>
                </div>
                <button class="action" onclick="window.location='{{ route('event_registration.create') }}';">Book it</button>
            </div>
        </div>

        <div class="item-container">
            <div class="img-container">
                @foreach ($events as $item)
                    <img src="{{ $item['image'] }}" alt="Event Image">
                @endforeach
            </div>

            <div class="body-container">
                <div class="overlay"></div>

                <@foreach ($events as $item)
                <div class="event-info">
                    <p class="title">{{ $item['name'] }}</p>
                @endforeach
                    <div class="separator"></div>
                    {{-- <p class="info">Cimahi, Bandung</p> --}}
                    @foreach ($events as $item)
                    <p class="price">{{ $item['price'] }}</p>
                    @endforeach

                    <div class="additional-info">
                        <p class="info">
                            <i class="fas fa-map-marker-alt"></i>
                            @foreach ($events as $item)
                                    {{ $item['location'] }}
                                @endforeach
                        </p>
                        <p class="info">
                            <i class="far fa-calendar-alt"></i>
                            @foreach ($events as $item)
                                {{ $item['event_date'] }}
                            @endforeach
                        </p>

                        <p class="info description">
                            @foreach ($events as $item)
                            {{ $item['description'] }}
                        @endforeach
                        </p>
                    </div>
                </div>
                <button class="action">Book it</button>
            </div>
        </div>

        <div class="item-container">
            <div class="img-container">
                @foreach ($events as $item)
                    <img src="{{ $item['image'] }}" alt="Event Image">
                @endforeach
            </div>

            <div class="body-container">
                <div class="overlay"></div>

                <<@foreach ($events as $item)
                <div class="event-info">
                    <p class="title">{{ $item['name'] }}</p>
                @endforeach
                    <div class="separator"></div>
                    {{-- <p class="info">New York, NY</p> --}}
                    @foreach ($events as $item)
                    <p class="price">{{ $item['price'] }}</p>
                    @endforeach

                    <div class="additional-info">
                        <p class="info">
                            <i class="fas fa-map-marker-alt"></i>
                            @foreach ($events as $item)
                                    {{ $item['location'] }}
                                @endforeach
                        </p>
                        <p class="info">
                            <i class="far fa-calendar-alt"></i>
                            @foreach ($events as $item)
                                {{ $item['event_date'] }}
                            @endforeach
                        </p>

                        <p class="info description">
                            @foreach ($events as $item)
                            {{ $item['description'] }}
                        @endforeach
                        </p>
                    </div>
                </div>
                <button class="action">Book it</button>
            </div>
        </div>


    </div>

</body>
</html>
