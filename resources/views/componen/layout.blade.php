<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <img style="width:60px; height:60px;" src="{{ asset('img/Logo.png') }}">    
            <div class="logo-name"><span>Project</span>Strike</div>
        </a>
        <ul class="side-menu">
            @if (Auth::check())
                @if (Auth::user()->role === 'admin')
                    <li class="{{ request()->is('dashboard*') ? 'active' : '' }}">
                        <a href="{{ url('/dashboard') }}"><i class='bx bxs-dashboard'></i>Dashboard</a>
                    </li>
                    <li class="{{ request()->is('events*') ? 'active' : '' }}">
                        <a href="{{ route('event.index') }}"><i class='bx bx-store-alt'></i>Event</a>
                    </li>
                    <li class="{{ request()->is('setting*') ? 'active' : '' }}">
                        <a href="{{ route('setting.index') }}"><i class='bx bx-cog'></i>Setting</a>
                    </li>
                    <li class="{{ request()->is('user*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}"><i class='bx bx-user'></i>Member</a>
                    </li>
                    <li class="{{ request()->is('event-registration*') ? 'active' : '' }}">
                        <a href="{{ route('event_registration.index') }}"><i class='bx bx-user'></i>EventRegist</a>
                    </li>
                    <li class="{{ request()->is('payment*') ? 'active' : '' }}">
                        <a href="{{ route('paymenttypesIndex') }}"><i class='bx bx-dollar'></i>Payment-Types</a>
                    </li>
                @elseif(Auth::user()->role === 'operator')
                    <li class="{{ request()->is('operator*') ? 'active' : '' }}">
                        <a href="{{ route('eventsop.index') }}"><i class='bx bx-wrench'></i>Event</a>
                    </li>
                @endif
            @endif
        </ul>

        <ul class="side-menu">
            <li>
                <a class="logout" onclick="confirmLogout()" style="cursor: pointer;">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                {{-- <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div> --}}
            </form>

            <input type="checkbox" id="theme-toggle" hidden>
            {{-- <label for="theme-toggle" class="theme-toggle"></label> --}}

            <a href="#" class="profile">
                @php
                    $user = Auth::user();
                    $namaPengguna = $user->name;
                    $inisial = $namaPengguna[0];
                @endphp
                <div class="profile-avatar">{{ $inisial }}</div>
            </a>
        </nav>

        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Dashboard
                            </a></li>
                        /
                        <li><a href="#" id="menu-link" class="active">Home</a></li>
                    </ul>
                </div>
            </div>
            @yield('content')
    </div>

    </main>

    </div>

    <script src="index.js"></script>
    <script>
        const sideLinks = document.querySelectorAll('.sidebar .side-menu li a:not(.logout)');

        sideLinks.forEach(item => {
            const li = item.parentElement;
            item.addEventListener('click', () => {
                sideLinks.forEach(i => {
                    i.parentElement.classList.remove('active');
                })
                li.classList.add('active');
            })
        });

        const menuBar = document.querySelector('.content nav .bx.bx-menu');
        const sideBar = document.querySelector('.sidebar');

        menuBar.addEventListener('click', () => {
            sideBar.classList.toggle('close');
        });

        const searchBtn = document.querySelector('.content nav form .form-input button');
        const searchBtnIcon = document.querySelector('.content nav form .form-input button .bx');
        const searchForm = document.querySelector('.content nav form');

        searchBtn.addEventListener('click', function(e) {
            if (window.innerWidth < 576) {
                e.preventDefault;
                searchForm.classList.toggle('show');
                if (searchForm.classList.contains('show')) {
                    searchBtnIcon.classList.replace('bx-search', 'bx-x');
                } else {
                    searchBtnIcon.classList.replace('bx-x', 'bx-search');
                }
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth < 768) {
                sideBar.classList.add('close');
            } else {
                sideBar.classList.remove('close');
            }
            if (window.innerWidth > 576) {
                searchBtnIcon.classList.replace('bx-x', 'bx-search');
                searchForm.classList.remove('show');
            }
        });

        // const toggler = document.getElementById('theme-toggle');

        // toggler.addEventListener('change', function() {
        //     if (this.checked) {
        //         document.body.classList.add('dark');
        //     } else {
        //         document.body.classList.remove('dark');
        //     }
        // });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Periksa URL saat halaman dimuat
            checkURL();

            // Fungsi untuk memeriksa URL dan mengubah teks
            function checkURL() {
                var path = window.location.pathname;
                if (path.includes("events")) {
                    $("#menu-link").text("Events");
                } else if (path.includes("setting")) {
                    $("#menu-link").text("Setting");
                } else if (path.includes("user")) {
                    $("#menu-link").text("Member");
                } else if (path.includes("event_registration")) {
                    $("#menu-link").text("EventRegist");
                } else if (path.includes("payment")) {
                    $("#menu-link").text("Payment");
                } else if (path.includes("result")) {
                    $("#menu-link").text("Results");
                } else {
                    $("#menu-link").text("Home");
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF0000',
                cancelButtonColor: '#18537a',
                confirmButtonText: 'Logout!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('logout') }}";
                }
            });
        }
    </script>

</body>

</htm
