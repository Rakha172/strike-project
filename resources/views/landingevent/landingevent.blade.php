<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landingevent.css') }}" />
    <title>halaman event</title>
</head>
<body>
    <div class="navbar">
        Event Ticket Booking
    </div>

    <!-- Tambahkan judul nama event -->
    <h1 class="event-title">Upcoming Events</h1>

    <div class="container">
        <div class="item-container">
            <div class="img-container">
                <img src="./images/img1.jpg" alt="Event image">
            </div>

            <div class="body-container">
                <div class="overlay"></div>

                <div class="event-info">
                    <p class="title">Galatama</p>
                    <div class="separator"></div>
                    <p class="info">Flie Fishing</p>
                    <p class="price">Free</p>

                    <div class="additional-info">
                        <p class="info">
                            <i class="fas fa-map-marker-alt"></i>
                            Grand Central Terminal
                        </p>
                        <p class="info">
                            <i class="far fa-calendar-alt"></i>
                            Sat, Sep 19, 10:00 AM EDT
                        </p>

                        <p class="info description">
                            WELCOME! Every fishing enthusiast has a unique experience while fishing,
                            and we want you to share yours with us! join us<span>more...</span>
                        </p>
                    </div>
                </div>
                <button class="action">Book it</button>
            </div>
        </div>

        <div class="item-container">
            <div class="img-container">
                <img src="./images/img2.jpg" alt="Event image">
            </div>

            <div class="body-container">
                <div class="overlay"></div>

                <div class="event-info">
                    <p class="title">Rod and Reel Fishing</p>
                    <div class="separator"></div>
                    <p class="info">Cimahi, Bandung</p>
                    <p class="price">29$</p>

                    <div class="additional-info">
                        <p class="info">
                            <i class="fas fa-map-marker-alt"></i>
                            245 W 52nd St, New York
                        </p>
                        <p class="info">
                            <i class="far fa-calendar-alt"></i>
                            Sat, Sep 19, 10:00 AM EDT
                        </p>

                        <p class="info description">
                            Welcome! Everyone has a unique perspective after reading a book, and we would love you
                            to share yours with us! We meet one Sunday evening <span>more...</span>
                        </p>
                    </div>
                </div>
                <button class="action">Book it</button>
            </div>
        </div>

        <div class="item-container">
            <div class="img-container">
                <img src="./images/img3.jpg" alt="Event image">
            </div>

            <div class="body-container">
                <div class="overlay"></div>

                <div class="event-info">
                    <p class="title">Fishing Series Competition</p>
                    <div class="separator"></div>
                    <p class="info">New York, NY</p>
                    <p class="price">70$</p>

                    <div class="additional-info">
                        <p class="info">
                            <i class="fas fa-map-marker-alt"></i>
                            245 W 52nd St, New York
                        </p>
                        <p class="info">
                            <i class="far fa-calendar-alt"></i>
                            Sat, Sep 19, 10:00 AM EDT
                        </p>

                        <p class="info description">
                            Welcome! Everyone has a unique perspective after reading a book, and we would love you
                            to share yours with us! We meet one Sunday evening <span>more...</span>
                        </p>
                    </div>
                </div>
                <button class="action">Book it</button>
            </div>
        </div>


    </div>

</body>
</html>
