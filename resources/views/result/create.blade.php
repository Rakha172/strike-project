<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Hasil Pemancingan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <h1 class="text-center fs-2 mt-4">Tambah Hasil Pemancingan Baru</h1>
            <div class="card-body">
                <form action="{{ route("result.store") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Event</label>
                        <select name="event_id" id="event_id" class="form-control">
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="user_id">User:</label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="events_registration_id">Events Registration:</label>
                        <select name="events_registration_id" id="events_registration_id" class="form-control">
                            @foreach ($event_registration as $event_registration)
                                <option value="{{ $event_registration->id }}">{{ $event_registration->name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="user_id">User:</label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-3">
                        <label class="form-label">Jumlah Ikan</label>
                        <input value="{{ old('fish_count')}}" name="fish_count" type="text" class="form-control @error('fish_count') is-invalid @enderror">
                          @error('fish_count')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>

                    <div class="mb-3">
                    <label class="form-label">Berat Ikan</label>
                    <input value="{{ old('weight')}}" name="weight" type="text" class="form-control @error('weight') is-invalid @enderror">
                        @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="special">Special</option>
                            <option value="regular">Regular</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
