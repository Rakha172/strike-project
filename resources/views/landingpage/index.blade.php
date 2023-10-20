@extends('componen.landingpage')
@section('main')
    <nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand mr-5" style="color:#fff;" href="#">STRIKEFISH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-5">
                    <li class="nav-item">
                        <a class="nav-link active" style="color:#fff;" href="#">Acara</a>
                    </li>
                </ul>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0  gap-2">
                        <li class="nav-item">
                            <a href="">
                                <button type="button" class="btn btn-light">Daftar</button>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="">
                                <button type="button" class="btn btn-light">Masuk</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    </nav>
    <div class="container-fluid banner">
        <div class="container text-center">
            <H5 class="display-6">Selamat datang di website kami</H5>
            <h4 class="display-4">StrikeFish</h4>
            <a href="">
                <button type="button" class="btn btn-primary">Cek Acara</button>
            </a>
        </div>
    </div>
    <div class="container-fluid event">
        <div class="container text-center">
            <H4 class="display-3">Acara</H4>
            <div class="display-flex">
                <h4>Galatama</h4>
            </div>
        </div>
    </div>
@endsection
