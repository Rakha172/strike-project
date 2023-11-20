<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Edit Result Operator</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center fs-2 mt-4" style="background-color:#cdecfa;">Edit Result Operator</h1>
                <h2 class="text-center fs-3 mt-4">{{ $event->name }}</h2>
                <div class="row">
                    <!-- Bagian untuk kamera -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Ambil Foto</h3>
                                <video id="cameraFeed" width="100%" height="auto" autoplay></video>
                                <button onclick="capturePhoto()" class="btn btn-primary mt-3"> Simpan</button>
                                <canvas id="canvas" style="display: none;"></canvas>
                                <img id="capturedImage" src="#" alt="Captured Image" style="max-width: 100%;">
                            </div>
                        </div>
                    </div>
                    <!-- Form untuk edit data hasil -->
                    <div class="col-md-6">
                        <form action="{{ route("resultop.update", [ 'result' => $result->id]) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="mb-3">
                                <label for="participant">Participant</label>
                                <select name="participant" class="form-control" style="background-color:#cdecfa;">
                                    @foreach($event_registration as $eventReg)
                                        <option value="{{ $eventReg->user_id }}" @if($eventReg->user_id == $result->participant) selected @endif>{{ $eventReg->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Berat Ikan</label>
                                <input value="{{ $result->weight }}" name="weight" type="number" class="form-control @error('weight') is-invalid @enderror" style="background-color:#cdecfa;">
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-control" style="background-color:#cdecfa;">
                                    <option value="special" @if($result->status == 'special') selected @endif>Special</option>
                                    <option value="regular" @if($result->status == 'regular') selected @endif>Regular</option>
                                </select>
                            </div>
                            <input type="hidden" name="image_data" id="imageData" value="{{ $result->image_path }}">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function setupCamera() {
            const constraints = {
                video: { width: 400, height: 300 }
            };

            const video = document.getElementById('cameraFeed');
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
            } catch (err) {
                console.error('Error accessing the camera:', err);
            }
        }

        function capturePhoto() {
    const video = document.getElementById('cameraFeed');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('capturedImage');
    const imageDataInput = document.getElementById('imageData');

    canvas.width = 400;
    canvas.height = 300;
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

    const imageData = canvas.toDataURL('image/png');
    photo.setAttribute('src', imageData);
    photo.style.display = 'block';

    // Set data gambar ke input hidden
    imageDataInput.value = imageData;

    // Panggil fungsi updateResult() untuk mengirimkan permintaan pembaruan
    updateResult();
}

        setupCamera();
    </script>
</body>
</html>
