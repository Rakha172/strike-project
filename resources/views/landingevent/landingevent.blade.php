<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landingevent.css') }}" />
    {{-- notification confirm logout --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <title>Halaman Event</title>
</head>

<body>
    <div class="navbar">
        Event Ticket Booking
        <br>
        <button class ="prof">
            <a href="">Profile</a>
        </button>
        <button class="logout" onclick="confirmLogout()">
                Logout
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

            @if (!$isRegistered)
                <div class="item-container">
                    <div class="img-container">
                        @if ($item->members->contains(Auth::user()))
                            @if ($item->qr_code)
                                <img src="data:image/png;base64,{{ $item->qr_code }}" alt="QR Code">
                            @else
                                <?php
                                $kode = $item->id . '/wayangriders/' . $item->password;
                                $filename = 'wayangriders' . $item->id . '.png';
                                $path = public_path("qrcode_images/$filename");
                                require_once 'qrcode/qrlib.php';
                                QRcode::png($kode, $path, 2, 2);
                                // Simpan $kode ke dalam model $item untuk penggunaan berikutnya
                                $item->update(['qr_code' => base64_encode(file_get_contents($path))]);
                                ?>
                                <img src="{{ asset('qrcode_images/' . $filename) }}" alt="QR Code">
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
            @endif
        @endforeach

        {{-- Menampilkan yang sudah terdaftar ke bagian bawah --}}
        @foreach ($events as $item)
            @php
                $isRegistered = $item->members->contains(Auth::user());
            @endphp

            @if ($isRegistered)
                <div class="item-container">
                    <div class="img-container">
                        @if ($item->members->contains(Auth::user()))
                            @if ($item->qr_code)
                                <img src="data:image/png;base64,{{ $item->qr_code }}" alt="QR Code">
                            @else
                                <?php
                                $kode = $item->id . '/wayangriders/' . $item->password;
                                $filename = 'wayangriders' . $item->id . '.png';
                                $path = public_path("qrcode_images/$filename");
                                require_once 'qrcode/qrlib.php';
                                QRcode::png($kode, $path, 2, 2);
                                // Simpan $kode ke dalam model $item untuk penggunaan berikutnya
                                $item->update(['qr_code' => base64_encode(file_get_contents($path))]);
                                ?>
                                <img src="{{ asset('qrcode_images/' . $filename) }}" alt="QR Code">
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
            @endif
        @endforeach
    </div>

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
