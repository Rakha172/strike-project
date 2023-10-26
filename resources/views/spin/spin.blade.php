<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>spin</title>
    <link href="{{ asset('css/spin.css') }}" rel="stylesheet">
</head>
<body>
    <button id="spin">spin</button>
    <span class="arrow"></span>
    <div class="container">
        <div class="one">1</div>
        <div class="two">10</div>
        <div class="three">9</div>
        <div class="four">8</div>
        <div class="five">7</div>
        <div class="six">6</div>
        <div class="seven">5</div>
        <div class="eight">4</div>
        <div class="nine">3</div>
        <div class="ten">2</div>
    </div>

    <script>
        let container = document.querySelector('.container');
        let btn = document.getElementById('spin');
        let spinning = false;

        btn.onclick = function () {
            if (!spinning) {
                let number = Math.floor(Math.random() * 10) + 1; // Menghasilkan nomor antara 1 hingga 10
                let rotateDegrees = 360 * 5 + (number - 1) * (360 / 10); // Menghitung derajat rotasi

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
        }

        // Fungsi untuk mendapatkan derajat rotasi saat ini
        function getRotationDegrees(element) {
            let style = window.getComputedStyle(element);
            let matrix = style.transform || style.webkitTransform || style.mozTransform;
            if (matrix === 'none') return 0;
            let values = matrix.split('(')[1].split(')')[0].split(',');
            let a = values[0];
            let b = values[1];
            let angle = Math.round(Math.atan2(b, a) * (180 / Math.PI));
            return angle < 0 ? angle + 360 : angle;
        }
    </script>
</body>
</html>
