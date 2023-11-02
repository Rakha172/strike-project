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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@700;900&display=swap"
    rel="stylesheet">
</head>

<body id="top">
  <header class="header" data-header>
    <div class="container">

      <a href="#" class="logo">
        <img style="width:90px; height:90px;" src="{{asset('img/Logo.png')}}">
        <div class="logo-name"><span>Project</span>Strike</div>
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
            <a href="#blog" class="navbar-link" data-nav-link>Even</a>
          </li>

          <li>
            <a href="#" class="btn btn-primary">Sign-in</a>
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



            <h1 class="h1 hero-title">Menyediakan Tempat Pemancingan Terbaik Untuk Anda</h1>

            <p class="section-text">
              Untuk anda yang mempunyai hobi memancing, kami menyediakan  kolam
              pemancingan luas yang berisikan berbagai jenis ikan seperti Ikan Mas (Karper),
               Bawal, Gurame, Mujair, dan Patin di mana anda dapat menyalurkan hobie sepuas hati.
            </p>



          </div>

          <figure class="hero-banner">
            <img src="{{asset('img/well.png')}}" width="769" height="804" alt="hero banner" class="w-100">
          </figure>

        </div>
      </section>

      <section class="section about" id="about" aria-label="about">
        <div class="container">

          <figure class="about-banner">
            <img src="{{asset('img/its.png')}}" width="1262" height="1357" loading="lazy" alt="about banner"
              class="w-100">
          </figure>

          <div class="about-content">

            <div class="history">
              <div class="heading">

                  <div>
                    <h1 class="h2 section-title">History ProjectStrike</h1>

                    <p class="h3">Strike Maniac meluncurkan situs web dan aplikasi pertama mereka, memudahkan pelanggan untuk memesan
                       tempat pemancingan secara online. Mereka juga memperkenalkan program loyalitas yang memberikan diskon dan
                        manfaat eksklusif bagi pelanggan setia.</p>

                  </div>
              </div>
          </div>





      </section>
     <section class="section blog" id="blog" aria-label="blog">
        <div class="container">

          <p class="section-subtitle">Recent Blogs</p>

          <h2 class="h2 section-title">Events</h2>

          <ul class="blog-list">

            <li>
              <div class="blog-card">

                <figure class="card-banner img-holder" style="--width: 768; --height: 558;">
                  <img src="./assets/images/blog-1.jpg" width="768" height="558" loading="lazy"
                    alt="Build A Full Web Chat App From Our Scratch" class="img-cover">
                </figure>

                <div class="card-content">

                  <ul class="card-meta-list">

                    <li class="card-meta-item">
                      <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                      <time class="card-meta-text" datetime="2022-05-22">May 22,2022</time>
                    </li>

                    <li class="card-meta-item">
                      <ion-icon name="chatbox-outline" aria-hidden="true"></ion-icon>

                      <p class="card-meta-text">2 Comment</p>
                    </li>

                  </ul>

                  <h3 class="h3">
                    <a href="#" class="card-title">Build A Full Web Chat App From Our Scratch</a>
                  </h3>

                  <a href="#" class="btn btn-outline">Read More</a>

                </div>

              </div>
            </li>

            <li>
              <div class="blog-card">

                <figure class="card-banner img-holder" style="--width: 768; --height: 558;">
                  <img src="./assets/images/blog-2.jpg" width="768" height="558" loading="lazy"
                    alt="Brush Strokes Energize Trees In Paintings" class="img-cover">
                </figure>

                <div class="card-content">

                  <ul class="card-meta-list">

                    <li class="card-meta-item">
                      <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                      <time class="card-meta-text" datetime="2022-05-22">May 22,2022</time>
                    </li>

                    <li class="card-meta-item">
                      <ion-icon name="chatbox-outline" aria-hidden="true"></ion-icon>

                      <p class="card-meta-text">2 Comment</p>
                    </li>

                  </ul>

                  <h3 class="h3">
                    <a href="#" class="card-title">Brush Strokes Energize Trees In Paintings</a>
                  </h3>

                  <a href="#" class="btn btn-outline">Read More</a>

                </div>

              </div>
            </li>

            <li>
              <div class="blog-card">

                <figure class="card-banner img-holder" style="--width: 768; --height: 558;">
                  <img src="./assets/images/blog-3.jpg" width="768" height="558" loading="lazy"
                    alt="Insights on How to Improve Your Teaching." class="img-cover">
                </figure>

                <div class="card-content">

                  <ul class="card-meta-list">

                    <li class="card-meta-item">
                      <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                      <time class="card-meta-text" datetime="2022-05-22">May 22,2022</time>
                    </li>

                    <li class="card-meta-item">
                      <ion-icon name="chatbox-outline" aria-hidden="true"></ion-icon>

                      <p class="card-meta-text">2 Comment</p>
                    </li>

                  </ul>

                  <h3 class="h3">
                    <a href="#" class="card-title">Insights on How to Improve Your Teaching.</a>
                  </h3>

                  <a href="#" class="btn btn-outline">Read More</a>

                </div>

              </div>
            </li>

          </ul>

        </div>

      </section>

    </article>
  </main>
  <footer class="footer">


    <div class="section footer-top">
      <div class="container">

        <div class="footer-brand">

          <a href="#" class="logo2">
            <img style="width:80px; height:80px;" src="{{asset('img/Logo.png')}}">
            <div class="logo-name2"><span>Project</span>Strike</div>
          </a>
          <p class="section-text">
            Duis cursus, mi quis viverra ornare, eros dolor interdum nulla utimp erdiet commodo diam libero vitae nibh
            et jus cursus
            id rutrum lore imperdiet ut sem vitae risus tristique posuere
          </p>

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
            <p class="footer-list-title">Company</p>
          </li>

          <li>
            <a href="#" class="footer-link">About Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Contact Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Core Services</a>
          </li>

          <li>
            <a href="#" class="footer-link">Our Team</a>
          </li>

          <li>
            <a href="#" class="footer-link">Pricing Plan</a>
          </li>

        </ul>

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
            <a href="#" class="footer-link">Jl.wkkdkdk</a>
          </li>


        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Contact Us</p>
          </li>

          <li class="footer-item">
            <ion-icon name="call-outline" aria-hidden="true"></ion-icon>

            <a href="tel:+12023459999" class="item-link">+62-896-xxxx-xxxx</a>
          </li>

          <li class="footer-item">
            <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>

            <a href="mailto:supportvast@gmail.com" class="item-link">Strike@gmail.com</a>
          </li>


        </ul>

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
  <script src="" defer></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
