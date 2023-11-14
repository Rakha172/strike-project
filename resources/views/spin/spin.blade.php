<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spin</title>
    <link href="{{ asset('css/spin.css') }}" rel="stylesheet">
</head>

<body>
    @foreach ($events as $event)
        <div class="event">
            <h3>{{ $event->name }}</h3>

            <button id="spin{{ $event->id }}" class="spin" data-event-id="{{ $event->id }}">Spin</button>
                <div class="container" id="container{{ $event->id }}" data-event-id="{{ $event->id }}">
            <div class="container" data-event-id="{{ $event->id }}">
                @foreach ($numbers as $number)
                    <div class="number" data-number="{{ $number }}">{{ $number }}</div>
                @endforeach
            </div>
        </div>
    @endforeach

    <script>
        // Menangani klik pada tombol spin
        document.querySelectorAll('.spin').forEach(function(button) {
            button.addEventListener('click', function() {
                var eventId = this.getAttribute('data-event-id');
                var container = document.querySelector('.container[data-event-id="' + eventId + '"]');

                // Mendapatkan nomor yang sudah terpilih dalam div container terkait
                var selectedNumber = container.querySelector('.number.selected');

                if (selectedNumber) {
                    // Menghapus nomor yang sudah terpilih dari tampilan
                    selectedNumber.style.display = 'none';
                    selectedNumber.classList.remove('selected');
                }

                // Memilih nomor secara acak
                var numbers = container.querySelectorAll('.number:not(.selected)');
                if (numbers.length > 0) {
                    var randomIndex = Math.floor(Math.random() * numbers.length);
                    var selected = numbers[randomIndex];

                    // Menandai nomor sebagai terpilih
                    selected.classList.add('selected');
                } else {
                    // Tambahkan logika atau tindakan lain jika semua nomor sudah terpilih
                    console.log('Semua nomor sudah terpilih');
                }
            });
        });
    </script>
</body>

</html>
