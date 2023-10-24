@extends('componen.landingpage')
@section('main')
    <nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand mr-5" style="color:#fff;" href="#">ProjectStraike</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-5">
                    <li class="nav-item">
                        {{-- <a class="nav-link active" style="color:#fff;" href="#">Acara</a> --}}
                    </li>
                </ul>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0  gap-2">
                        <li class="nav-item">

                            <a href="{{ route('register') }}">

                                <button type="button" class="btn btn-light">Register</button>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="{{ route('login') }}">

                                <button type="button" class="btn btn-light">Login</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    </nav>
    <div class="container-fluid banner">
        <div class="container text-center">
            <H5 class="display-6" style="color:#fff;">Selamat datang di website kami</H5>
            <h4 class="display-4" style="color:#fff;">StrikeFish</h4>
            <a href="">
                <button type="button" class="btn btn-primary">Cek Acara</button>
            </a>
        </div>
    </div>

    <div class="container-fluid event">
        <div class="container text-center">
            {{-- <H4 class="display-3">Acara</H4> --}}
            <div class="display-flex">
                {{-- <h4>Galatama</h4> --}}

    {{-- <h1 class="text-center pt-5">Acara</h1> --}}
    <div class="container-fluid event">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-3">
                        <div class="card-header">
                            <h5>Galatama</h5>
                        </div>
                        <div class="card-body">
                            <p> advkoenwovhoheqpinbvfqeufbuqevufnvbweymgpierjb0rnhgngu8uh90rytejt0envyge7rwgcewhyrgnjbithje9netnu9hurynjyejmtemj
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <div class="display-flex">
                                <h5>Galatama</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
