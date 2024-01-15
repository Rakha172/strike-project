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

        @error('name')
            <div class="alert custom-alert-success">
                <div class="blurry-background"></div>
                <div class="alert-content">
                    <h6>
                        <div class="invalid-feedback">{{ $message }}</div>
                    </h6>
                </div>
            </div>
        @enderror

        @error('phone_number')
            <div class="alert custom-alert-erorr">
                <div class="blurry-background"></div>
                <div class="alert-content">
                    <h6>
                        <div class="invalid-feedback">{{ $message }}</div>
                    </h6>
                </div>
            </div>
        @enderror

        {{-- Modal --}}
        <button onclick="openModal()" class="prof">Profile</button>
        <div id="myModal" class="modal">
            <!-- Content For Modal -->
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <form action="{{ route('updateprofile', $user->id) }}" method="POST">
                    @csrf
                    @method('put')

                    <p>Username <input type="text" value="{{ $user->name }}" name="name" title="klik untuk edit"
                            required></p>
                    <p>Nomor Telepon <input type="number" value="{{ $user->phone_number }}" name="phone_number"
                            title="klik untuk edit" required></p>
                    <p>Email <input type="text" readonly value="{{ $user->email }}" title="klik untuk edit"></p>

                    <input value="Save" type="submit" id="submit" onclick="saveChanges()">
                </form>
            </div>
        </div>

        <button class="logout" onclick="confirmLogout()">
            Logout
        </button>
    </div>

    <h1 class="event-title">Events</h1>
    @if (Session::has('success'))
        <div class="alert custom-alert-success">
            <div class="blurry-background"></div>
            <div class="alert-content">
                <p>{{ Session::get('success') }}</p>
            </div>
        </div>
    @endif

    <div class="container">
        @foreach ($events as $item)
            @php
                $isRegistered = $item->members->contains(Auth::user());
                $eventDateTimestamp = strtotime($item['event_date']);
                $todayTimestamp = strtotime(date('Y-m-d'));
            @endphp

            @if ($eventDateTimestamp >= $todayTimestamp)
                <div class="item-container">
                    <div class="img-container">
                        @if ($isRegistered)
                            <?php
                            $eventRegistration = $events_registration
                                ->where('user_id', Auth::user()->id)
                                ->where('event_id', $item->id)
                                ->first();
                            ?>

                            @if ($eventRegistration)
                                @if (
                                    $item->qr_code &&
                                        $eventRegistration->payment_status === 'paid' &&
                                        $eventRegistration->payment_status !== 'attended')
                                    <img src="data:image/png;base64,{{ $item->qr_code }}" alt="QR Code">
                                @else
                                    <?php
                                    $kode = $eventRegistration->id . '/wayangriders/' . $eventRegistration->password;
                                    $filename = 'wayangriders' . $eventRegistration->id . '.png';
                                    $path = public_path("qrcode_images/$filename");
                                    require_once 'qrcode/qrlib.php';
                                    if (!$item->qr_code || $eventRegistration->payment_status === 'paid') {
                                        QRcode::png($kode, $path, 2, 2);
                                        $eventRegistration->update(['qr_code' => base64_encode(file_get_contents($path))]);
                                    }
                                    ?>

                                    @if ($eventRegistration->payment_status === 'waiting')
                                        <img src="{{ $item['image'] }}" alt="Event Image">
                                    @endif

                                    @if ($eventRegistration->payment_status === 'paid')
                                        <img src="{{ asset('qrcode_images/' . $filename) }}" alt="QR Code">
                                    @endif

                                    @if ($eventRegistration->payment_status === 'cancel')
                                        <img src="{{ $item['image'] }}" alt="Event Image">
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

                        @if ($isRegistered && ($eventRegistration && in_array($eventRegistration->payment_status, ['paid'])))
                            <button class="action" disabled>Anda sudah terdaftar untuk Event ini</button>
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
                confirmButtonColor: '#FF0000',
                cancelButtonColor: '#0000FF',
                confirmButtonText: 'Logout!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('logout') }}";
                }
            });
        }
    </script>

    {{-- profile --}}
    <script>
        // Fungsi untuk membuka modal
        function openModal() {
            document.getElementById('myModal').style.display = 'block';
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        // Menutup modal jika area luar modal diklik
        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>


    <script>
        function daftarEvent(eventId) {
            Swal.fire({
                title: 'Bergabunglah sekarang!',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, daftar sekarang!',
                cancelButtonText: 'Tidak, terima kasih',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn-ungu'
                }
            }).then((result) => {
                if (result.isConfirmed) {
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
            });
        }
    </script>


</body>

</html>
