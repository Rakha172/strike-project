<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title->name }} | Add Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        #capturedImage {
            display: none;
        }
    </style>
</head>

<body>
    @extends('componen.layout')
    @section('content')
        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center fs-2 mt-4">Hasil Result Pemancingan</h1>
                    <h2 class="text-center fs-3 mt-4">{{ $event->name }}</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-kamera">
                                <div class="card-body">
                                    <h3 class="card-title">Ambil Foto</h3>
                                    <video id="cameraFeed" width="100%" height="auto" autoplay></video>
                                    <canvas id="canvas" style="display: none;"></canvas>
                                    <img id="capturedImage" src="#" alt="Captured Image">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('resultop.store', ['event' => $event->id]) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <label for="participant">Participant</label>
                                            <select name="participant" class="form-control">
                                                @foreach ($event_registration as $eventReg)
                                                    <option value="{{ $eventReg->user_id }}">{{ $eventReg->user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Berat Ikan</label>
                                            <input value="{{ old('weight') }}" name="weight" type="number"
                                                class="form-control @error('weight') is-invalid @enderror" min="-0">
                                            @error('weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="special">Special</option>
                                                <option value="regular">Regular</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="image_data" id="imageData" value="">
                                        <button onclick="capturePhotoAndSave(); showCapturedImage();"
                                            class="btn btn-primary mt-3"> Ambil Foto dan Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

        <script>
            async function setupCamera() {
                const constraints = {
                    video: {
                        width: 400,
                        height: 300
                    }
                };

                const video = document.getElementById('cameraFeed');
                try {
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    video.srcObject = stream;
                } catch (err) {
                    console.error('Error accessing the camera:', err);
                }
            }

            function capturePhotoAndSave() {
                const video = document.getElementById('cameraFeed');
                const canvas = document.getElementById('canvas');
                const photo = document.getElementById('capturedImage');
                const imageDataInput = document.getElementById('imageData');

                canvas.width = 400;
                canvas.height = 300;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = canvas.toDataURL('image/png');
                photo.setAttribute('src', imageData);
                imageDataInput.value = imageData;

                const formData = new FormData();
                formData.append('imageData', imageData);

                fetch('save_image.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log('Data terkirim:', response);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

                video.style.display = 'none';
            }

            function showCapturedImage() {
                const photo = document.getElementById('capturedImage');
                photo.style.display = 'block';
            }

            setupCamera();
        </script>
    </body>

</html>
@endsection
