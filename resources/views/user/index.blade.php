<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>User</title>
  </head>
  <body>

    <div class="container mt-5">

        <a href="{{ route('user.create')}}" class="btn btn-primary">Tambah</a>

        @if ($pesan = session('berhasil'))
        <div class="alert alert-primary" role="alert">
           {{ $pesan }}
        </div>
        @endif
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($user as $key => $item)
              <tr>
                <th scope="row">{{ $key + 1}}</th>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->password }}</td>
                <td class="d-flex">
                    <a href="{{ route('user.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ url('/user/'  . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger" onclick="return confirm('yakin hapus ni dek?')"><i aria-hidden="true"></i>Hapus</button></a>
                        </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
    <td colspan="n">
        <div style="text-align: center;">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>

