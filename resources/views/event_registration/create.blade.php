<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="card" style="margin:20px;">
<div class="card-header">Add Event</div>
<div class="card-body">

    <form action="{{ route('event_registration.store') }}" method="post">
        @csrf <!-- Menggunakan Blade directive untuk csrf_token -->
        <div class="form-group">

            <label class="form-label">User Id</label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                <option value="">Select</option>
                @foreach ($users as $item)
                    <option @if(old('user_id') == $item->id) selected @endif value="{{ $item->id }}">{{ $item->id }}</option>
                @endforeach
            </select>
            @error('event_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <br>

            <label class="form-label">Event Id</label>
            <select name="event_id" class="form-control @error('event_id') is-invalid @enderror">
                <option value="">Select</option>
                @foreach ($events as $event)
                    <option @if(old('event_id') == $event->id) selected @endif value="{{ $event->id }}">{{ $event->name }}</option>
                @endforeach
            </select>
            @error('event_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>
        <br>
        <input type="submit" value="Save" class="btn btn-success"><br>
    </form>
</div>
</div>
</body>
</html>
