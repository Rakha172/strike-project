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
                        @foreach ($events as $item)
                            @if (!$item->members->contains(Auth::user()))
                                <!-- ... (bagian lainnya) ... -->
                                <button class="action" data-event-id="{{ $item->id }}">Book it</button>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.action').forEach(function(button) {
                button.addEventListener('click', function() {
                    var eventId = this.getAttribute('data-event-id');
                    // Kirim permintaan AJAX ke server untuk membuat event registration
                    fetch('{{ route('store-event-registration') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                user_id: '{{ auth()->user()->id }}',
                                event_id: eventId,
                                booth: 1, // Ganti sesuai kebutuhan Anda
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message); // Tampilkan pesan alert dari response
                            // Redirect atau lakukan tindakan lain jika diperlukan
                            window.location.reload(); // Reload halaman setelah berhasil
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat mendaftar event.');
                        });
                });
            });
        });
    </script>

</body>

</html>
