<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>spin</title>
    <link href="{{ asset('css/spin.css') }}" rel="stylesheet">
</head>

<body>
    @foreach ($events as $event)
        <div class="event">
            <h3>{{ $event->name }}</h3>
            {{-- <p>Both: {{ $event->random_both }}</p> --}}

            <button id="spin">Spin</button>
            <span class="arrow"></span>
            <div class="container">
                @for ($i = 1; $i <= 1; $i++)
                    <div class="one">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 2; $i++)
                    <div class="two">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 3; $i++)
                    <div class="three">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 4; $i++)
                    <div class="four">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 5; $i++)
                    <div class="five">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 6; $i++)
                    <div class="six">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 7; $i++)
                    <div class="seven">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 8; $i++)
                    <div class="eight">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 9; $i++)
                    <div class="nine">{{ $no[$i - 1] }}</div>
                @endfor
                @for ($i = 1; $i <= 10; $i++)
                    <div class="ten">{{ $no[$i - 1] }}</div>
                @endfor
            </div>

        </div>

        <script>
            // Tambahkan skrip JavaScript untuk melakukan putaran (seperti yang disebutkan pada contoh sebelumnya)
            // ...
        </script>

        </div>
    @endforeach
    <script>
        let container = document.querySelector('.container');
        let btn = document.getElementById('spin');
        let spinning = false;

        btn.onclick = function() {
            if (!spinning) {
                let number = Math.floor(Math.random() * 10) + 1; // Menghasilkan nomor antara 1 hingga 10
                let rotateDegrees = 360 * 5 + (number - 1) * (360 / 10); // Menghitung derajat rotasi

                // Menghilangkan nomor yang telah dipilih
        let selectedNumberDiv = document.querySelector(`.number-${number}`);
        selectedNumberDiv.style.display = 'none';

                container.style.transition = 'transform 5s ease-out';
                container.style.transform = `rotate(${rotateDegrees}deg)`;
                spinning = true;

                // Hapus event listener sebelumnya agar tidak muncul berkali-kali
                container.removeEventListener('transitionend', handleAnimationEnd);

                // Tambahkan event listener untuk menangkap akhir animasi
                container.addEventListener('transitionend', handleAnimationEnd);
            }
        }

        function handleAnimationEnd() {
            let currentRotation = getRotationDegrees(container);
            let selectedNumber = Math.round(currentRotation / (360 / 10)) + 1;
            alert(`Selamat, nomor yang terpilih adalah ${selectedNumber}`);
            spinning = false;
            container.style.transition = ''; // Menghapus transisi untuk putaran berikutnya

            // Menampilkan kembali nomor yang sebelumnya disembunyikan
    let previouslySelectedNumberDiv = document.querySelector(`.number-${selectedNumber}`);
    previouslySelectedNumberDiv.style.display = 'block';
        }

        // Fungsi untuk mendapatkan derajat rotasi saat ini
        function getRotationDegrees(element) {
            let style = window.getComputedStyle(element);
            let matrix = style.transform || style.webkitTransform || style.mozTransform || style.msTransform;
            let angle;
            if (matrix === 'none') {
                angle = 0;
            } else {
                let values = matrix.split('(')[1].split(')')[0].split(',');
                let a = values[0];
                let b = values[1];
                angle = Math.atan2(b, a) * (180 / Math.PI);
            }
            return (angle < 0 ? angle + 360 : angle);
        }
    </script>
</body>

</html>
