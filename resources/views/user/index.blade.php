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
        <div class="card">
            <h1 class="text-center fs-2 mt-4">DATA USER</h1>
            <div class="card-body">
                    <form action="" method="GET">
                        <div class="row mb-2">
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-center">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($user as $no => $usr)
                                        <tr>
                                            <td>{{ $usr->name }}</td>
                                            <td>{{ $usr->email }}</td>
                                            <td style="width: 150px;">
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
