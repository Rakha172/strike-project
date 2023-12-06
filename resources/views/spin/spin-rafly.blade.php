<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Input</title>
</head>
<body>
    <center>
    <div id="preview-container">
    </div>

    <!-- Formulir input -->
    <form>
        @csrf
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" oninput="updatePreview()" required>
    </form>

    <script>
        function updatePreview() {
            // Ambil nilai dari input
            var nama = document.getElementById('nama').value;

            // Tampilkan hasil di dalam container
            var previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '<h2>Hasil:</h2><p>Nama: ' + nama + '</p>';
        }
    </script>

</body>
</html>
