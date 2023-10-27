<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Edit Hasil Pemancingan</title>
  </head>
  <body>
    <div class="container">
    <h2>Edit Hasil Pemancingan</h2>
    <form action="{{ route("result.update", $result->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="user_id">User Name:</label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                @foreach ($user as $item)
                    <option value="{{ $item->id }}" @if(old('user_id', $result->user->id) == $item->id) selected @endif>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="events_registration_id">Events Registration:</label>
            <select name="events_registration_id" id="events_registration_id" class="form-control">
                @foreach ($event_registration as $event_reg)
                    <option value="{{ $event_reg->id }}" @if($event_reg->id == $result->event_registration_id) selected @endif>{{ $event_reg->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="weight">Berat Ikan:</label>
            <input type="text" name="weight" id="weight" class="form-control" value="{{ $result->weight }}">
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="special" {{ $result->status == 'special' ? 'selected' : '' }}>Special</option>
                <option value="regular" {{ $result->status == 'regular' ? 'selected' : '' }}>Regular</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
