<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title->name}} | Add Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    @extends('componen.layout')

    @section('content')

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center fs-2 mt-4">Hasil Result Pemancingan</h1>
                <h2 class="text-center fs-3 mt-4">{{ $event->name }}</h2>

                <form action="{{ route("result.store", ['event' => $event->id]) }}" method="POST">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="participant">Participant</label>
                                    <select name="participant" class="form-control">
                                        @foreach($event_registration as $eventReg)
                                            <option value="{{ $eventReg->user_id }}">{{ $eventReg->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Berat Ikan</label>
                                    <input value="{{ old('weight')}}" name="weight" type="number" class="form-control @error('weight') is-invalid @enderror">
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
                            </div>
                </form>
                    </div>
                </div>
            </div>
            @endsection
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </body>
        </html>
