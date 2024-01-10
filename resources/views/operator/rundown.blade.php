<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Number Generator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/rundown.css') }}" />
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>Random Number Generator</h3>
        </div>
        <div class="result">
            <h1 class="active">{{ $eventRegistration->booth ?? 'Result' }}</h1>
        </div>

        <div class="button-group">
            <button id="instantly">
                <span class="material-symbols-outlined">  </span>
                Generate
            </button>
            <button id="start-stop">
                <span class="material-symbols-outlined">  </span>
                Start Generating
            </button>
        </div>

        <h3>
            Tersedia: {{ implode(', ', $boothAvailable) }}
        </h3>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        let intervalId;
        let scannedNumber = null;
        const boothAvailable = <?php echo json_encode($boothAvailable); ?>;
        const instBtn = document.querySelector('#instantly');
        const startStopBtn = document.querySelector('#start-stop');
        const result = document.querySelector('.result h1');

        result.innerHTML = '0';

        instBtn.addEventListener('click', () => {
            location.reload();
        });

        startStopBtn.addEventListener('click', () => {
            if (startStopBtn.textContent === 'Start Generating') {
                intervalId = setInterval(() => {
                    const random = getRandomNumber(0, boothAvailable.length - 1);
                    scannedNumber = boothAvailable[random];
                    result.innerHTML = scannedNumber;
                }, 100);
                startStopBtn.textContent = 'Stop Generating';
            } else {
                clearInterval(intervalId);
                startStopBtn.textContent = 'Start Generating';

                if (scannedNumber !== null) {
                    saveNumberToDatabase(scannedNumber);
                } else {
                }
            }
        });

        function getRandomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function saveNumberToDatabase(number) {
            fetch('/operator/rundown/{{ $event->id }}/{{ $eventRegistration->id }}/store-number', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ number: number }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Angka ' + scannedNumber + ' nomor Booth Anda.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Anda sudah memiliki nomor Booth.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan dalam menyimpan angka.'
                    });
                });
        }
    </script>
</body>

</html>
