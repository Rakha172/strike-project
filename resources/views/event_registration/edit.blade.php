<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Edit User</title>
</head>

<body>
    <div class="container mt-5" style="background: lightgrey">
        <form action="{{ route('event_registration.update', $event_registration)}}" method="POST">
            @csrf
            @method('put')
            <div class="mb-3">
                <label class="form-label">User Name</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                    <option value="">Select</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if(old('user_id', $event_registration->user->id) == $user->id) @endif>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('user_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('user_id') }}</strong>
                    </span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">User Name</label>
                <select name="event_id" class="form-control @error('event_id') is-invalid @enderror">
                    <option value="">Select</option>
                    @foreach ($event as $even)
                        <option value="{{ $even->id }}" @if(old('event_id', $event_registration->user->id) == $even->id)@endif>
                            {{ $even->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('event_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_id') }}</strong>
                    </span>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">Payment Status</label>
                <input value="{{ old('payment_status', $event->payment_status) }}" name="payment_status" type="text" class="form-control @error('payment_status') is-invalid @enderror">
                  @error('payment_status')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
            <button type="submit" class="btn btn-dark">Submit</button>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
