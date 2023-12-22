<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Number Generator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-clr: #d9dae3;
            --white: #fff;
            --grey: #eee;
            --light-grey: #fafafa;
            --dark-grey: #aaa;
            --primary-clr: #00e5b1;
            --secondary-clr: #fdc886;
            --text-clr: #333;
        }

        html {
            font-size: 10px;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-clr);
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--bg-clr);
        }

        .container {
            max-width: 90rem;
            margin: 0 auto;
            padding: 4rem;
            background: var(--white);
            border-radius: 2rem;
            box-shadow: 0 1rem 4rem 0 rgba(0, 0, 0, 0.1);
        }

        .container>* {
            margin-bottom: 2rem;
        }

        .header h3 {
            font-size: 2rem;
            text-align: center;
        }

        .result {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            height: 20rem;
        }

        .result h1 {
            font-size: 5rem;
            color: var(--dark-grey);
        }

        .input-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .input-wrapper {
            display: flex;
            flex-direction: column;
        }

        .input-wrapper label {
            font-size: 1.5rem;
            color: var(--dark-grey);
            line-height: 3rem;
        }

        .input-wrapper input {
            height: 4rem;
            font-size: 1.5rem;
            line-height: 3rem;
            border: 1px solid var(--grey);
            border-radius: 1rem;
            background: var(--light-grey);
            outline-style: none;
            padding: 0 1rem;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .button-group button {
            width: 100%;
            height: 4rem;
            font-size: 1.5rem;
            border-radius: 1rem;
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: 0.25s ease;
        }

        .button-group button span {
            font-size: 1.7rem;
        }

        .button-group button:active {
            transform: scale(0.9);
        }

        #start-stop {
            border: 2px solid var(--primary-clr);
            background: none;
        }

        #instantly {
            background: var(--primary-clr);
        }

        .result h1.active {
            font-size: 15rem;
            color: var(--text-clr);
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
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
                <span class="material-symbols-outlined"> autorenew </span>
                Generate
            </button>
            <button id="start-stop">
                <span class="material-symbols-outlined"> timer </span>
                Start Generating
            </button>
        </div>

        <h3>
            Tersedia: {{ implode(', ', $boothAvailable) }}
        </h3>
    </div>
    <script>
        // Bagian JavaScript yang ada di dalam <script> tag pada halaman HTML Anda

        let intervalId;
        let scannedNumber = null;
        const boothAvailable = <?php echo json_encode($boothAvailable); ?>;
        const instBtn = document.querySelector('#instantly');
        const startStopBtn = document.querySelector('#start-stop');
        const result = document.querySelector('.result h1');

        result.innerHTML = '0';

        instBtn.addEventListener('click', () => {
            if (scannedNumber !== null) {
                result.innerHTML = scannedNumber;
            } else {
                alert('Anda belum melakukan penghasilan angka!');
            }
        });

        startStopBtn.addEventListener('click', () => {
            if (startStopBtn.textContent === 'Start Generating') {
                intervalId = setInterval(() => {
                    const random = getRandomNumber(0, boothAvailable.length - 1);
                    scannedNumber = boothAvailable[random];
                    if (scannedNumber !== undefined) {
                        result.innerHTML = scannedNumber;
                    } else {
                        scannedNumber = boothAvailable[0];
                        result.innerHTML = scannedNumber;
                    }
                }, 100);
                startStopBtn.textContent = 'Stop Generating';
            } else {
                clearInterval(intervalId);
                startStopBtn.textContent = 'Start Generating';

                // Permintaan POST ke route baru
                if (scannedNumber !== null) {
                    fetch('/store-number', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                number: scannedNumber
                            })
                        })
                        .then(response => {
                            if (response.ok) {
                                alert('Angka ' + scannedNumber + ' berhasil dimasukkan ke dalam database.');
                            } else {
                                alert('Gagal memasukkan angka ke dalam database.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                } else {
                    alert('Tidak ada angka yang dihasilkan.');
                }
            }
        });

        function getRandomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    </script>
</body>

</html>
