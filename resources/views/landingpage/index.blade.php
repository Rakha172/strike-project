<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing</title>
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/css/landing.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@700;900&display=swap"
        rel="stylesheet">
</head>

<body id="top">
    <header class="header" data-header>
        <div class="container">
            <a href="#" class="logo" style="pointer-events: none;">
                @foreach ($setting as $item)
                    <img style="width:90px; height:90px;" src="{{ asset('logo/' . $item->logo) }}">
                    <div class="logo-name"><span>{{ $item->name }}</span>Strike</div>
                @endforeach
            </a>
            <nav class="navbar" data-navbar>
                <ul class="navbar-list container">

                    <li>
                        <a href="#home" class="navbar-link active" data-nav-link>Home</a>
                    </li>

                    <li>
                        <a href="#about" class="navbar-link" data-nav-link>History</a>
                    </li>

                    <li>
                        <a href="#blog" class="navbar-link" data-nav-link>Event</a>
                    </li>

                    <li>
                        <a href="{{ route('login') }}" class="btn btn-primary">Sign-in</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign-up</a>
                    </li>

                </ul>
            </nav>

            <button class="nav-toggle-btn" aria-label="toggle manu" data-nav-toggler>
                <ion-icon name="menu-outline" aria-hidden="true"></ion-icon>
            </button>

        </div>
    </header>
    <main>
        <article>

            <section class="section hero" aria-label="hero" id="home">
                <div class="container">

                    <div class="hero-content">
                        <h1 class="h1 hero-title">{{ $item->slogan }}</h1>
                        <p class="section-text">
                            {{ $item->desc }}
                        </p>
                    </div>

                    <figure class="hero-banner">
                        <img src="{{ asset('logo/' . $item->logo) }}"" width="769" height="804" alt="hero banner"
                            class="w-100">
                    </figure>

                </div>
            </section>

            <section class="section about" id="about" aria-label="about">
                <div class="container">

                    <figure class="about-banner">
                        <img src="{{ asset('logo/' . $item->logo) }}" width="1262" height="1357" loading="lazy"
                            alt="about banner" class="w-100">
                    </figure>

                    <div class="about-content">

                        <div class="history">
                            <div class="heading">

                                <div>
                                    <h1 class="h2 section-title">Strike History</h1>

                                    <p class="h3">{{ $item['history'] }}</p>

                                </div>
                            </div>
                        </div>
                    </div>
            </section>

            <section class="section blog" id="blog" aria-label="blog">
                <div class="container">

                    <p class="section-subtitle">Recent Blogs</p>

                    <h2 class="h2 section-title">Events</h2>

                    <ul class="blog-list">
                        @foreach ($events as $event)
                            @if (strtotime($event->event_date) > time())
                                <li>
                                    <div class="blog-card">
                                        <figure class="card-banner img-holder" style="--width: 768; --height: 558;">
                                            <img src="{{ $event->image }}" width="768" height="558" loading="lazy"
                                                alt="{{ $event->name }}" class="img-cover">
                                        </figure>
                                        <div class="card-content">
                                            <ul class="card-meta-list">
                                                <li class="card-meta-item">
                                                    <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>
                                                    <time class="card-meta-text" datetime="{{ $event->event_date }}">
                                                        {{ $event->event_date }}
                                                    </time>
                                                </li>
                                                <li class="card-meta-item">
                                                    <ion-icon name="chatbox-outline" aria-hidden="true"></ion-icon>
                                                    <p class="card-meta-text">{{ $event->description }}</p>
                                                </li>
                                            </ul>
                                            <h3 class="h3">
                                                <a href="#" class="card-title">{{ $event->name }}</a>
                                            </h3>
                                            <a href="/register" class="btn btn-outline">Read More</a>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </section>

        </article>
    </main>
    <footer class="footer">


        <div class="section footer-top">
            <div class="container">

                <div class="footer-brand">

                    <a href="#" class="logo2" style="pointer-events: none;">
                        <img style="width:80px; height:80px;" src="{{ asset('logo/' . $item->logo) }}">
                        <div class="logo-name2"><span>Fish</span>Strike</div>
                    </a>
                    {{-- <p class="section-text">
                        Duis cursus, mi quis viverra ornare, eros dolor interdum nulla utimp erdiet commodo diam libero
                        vitae nibh
                        et jus cursus
                        id rutrum lore imperdiet ut sem vitae risus tristique posuere
                    </p> --}}

                    <ul class="social-list">

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-facebook"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-twitter"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-google"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-linkedin"></ion-icon>
                            </a>
                        </li>

                    </ul>

                </div>
                <ul class="footer-list">

                    <li>
                        <p class="footer-list-title">Location</p>
                    </li>

                    <li>
                        <a href="#" class="footer-link">Indonesia</a>
                    </li>

                    <li>
                        <a href="#" class="footer-link">Jawa Barat</a>
                    </li>

                    <li>
                        <a href="#" class="footer-link">Kota Cimahi</a>
                    </li>

                    <li>
                        <a href="#" class="footer-link">Baros</a>
                    </li>


                </ul>

                {{-- <ul class="footer-list">

                    <li>
                        <p class="footer-list-title">Contact Us</p>
                    </li>

                    <li class="footer-item">
                        <ion-icon name="call-outline" aria-hidden="true"></ion-icon>

                        <a href="tel:+12023459999" class="item-link">{{$item->phone}}</a>
                    </li>

                    <li class="footer-item">
                        <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>

                        <a href="mailto:supportvast@gmail.com" class="item-link">{{$item->email}}</a>
                    </li>


                </ul> --}}

            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">

                <p class="copyright">
                    &copy; Pemancingan Galatama
                </p>

            </div>
        </div>

    </footer>
    <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
        <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
    </a>
    <script>
        let menu = document.querySelector('.nav-toggle-btn');
        let navbar = document.querySelector('.navbar');

        menu.onclick = () => {
            menu.classList.toggle('bx-x');
            navbar.classList.toggle('active');
        }

        window.onscroll = () => {
            menu.classList.remove('bx-x');
            navbar.classList.remove('active');
        }
    </script>
    <script src="" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
