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
        @foreach ($events as $item)
            @php
                $isRegistered = $item->members->contains(Auth::user());
            @endphp

            <div class="item-container">
                <div class="img-container">
                    @if ($isRegistered)
                        <?php
                        $eventRegistration = $events_registration->where('user_id', Auth::user()->id)
                            ->where('event_id', $item->id)
                            ->first();
                        ?>

                        @if ($eventRegistration)
                            @if ($item->qr_code && $eventRegistration->payment_status === 'payed' && $eventRegistration->payment_status !== 'attended')
                                <img src="data:image/png;base64,{{ $item->qr_code }}" alt="QR Code">
                            @else
                                <?php
                                $kode = $eventRegistration->id . '/wayangriders/' . $eventRegistration->password;
                                $filename = 'wayangriders' . $eventRegistration->id . '.png';
                                $path = public_path("qrcode_images/$filename");
                                require_once 'qrcode/qrlib.php';
                                if (!$item->qr_code || $eventRegistration->payment_status === 'payed') {
                                    QRcode::png($kode, $path, 2, 2);
                                    $eventRegistration->update(['qr_code' => base64_encode(file_get_contents($path))]);
                                }
                                ?>

                                @if ($eventRegistration->payment_status === 'payed')
                                    <img src="{{ asset('qrcode_images/' . $filename) }}" alt="QR Code">
                                @endif
                            @endif
                        @endif
                    @else
                        <img src="{{ $item['image'] }}" alt="Event Image">
                    @endif
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

                    @if ($isRegistered)
                        <button class="action" disabled>Already Registered</button>
                    @else
                        <button class="action" onclick="daftarEvent('{{ $item['id'] }}')">Register</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function daftarEvent(eventId) {
            const confirmation = confirm("Do you want to join this event?");
            if (confirmation) {
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
        }
    </script>

</body>

</html>
