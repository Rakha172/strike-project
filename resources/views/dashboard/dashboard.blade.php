<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Dashboard</title>
</head>

<body>

    <div class="sidebar">
        <a href="#" class="logo">
            <img style="width:60px; height:60px;" src="{{ asset('img/Logo.png') }}">
            <div class="logo-name"><span>Project</span>Strike</div>
        </a>
        <ul class="side-menu">

            @if (Auth::check())
                @if (Auth::user()->role === 'admin')
                    <li class="active"><a href="#"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
                    <li><a href="{{ route('event.index') }}"><i class='bx bx-store-alt'></i>Event</a></li>
                    <li><a href="{{ route('setting.index') }}"><i class='bx bx-cog'></i>Setting</a></li>
                    <li><a href="{{ route('user.index') }}"><i class='bx bx-user'></i>Member</a></li>
                    <li><a href="{{ route('event_registration.index') }}"><i class='bx bx-user'></i>EventRegist</a></li>
                    <li class="{{ request()->is('payment*') ? 'active' : '' }}">
                        <a href="{{ route('paymenttypesIndex') }}"><i class='bx bx-dollar'></i>Payment-Types</a>
                    </li>
                @elseif(Auth::user()->role === 'operator')
                    <li><a href="{{ route('eventsop.index') }}"><i class='bx bx-wrench'></i>Operator</a></li>
                @endif
            @endif
        </ul>
        <ul class="side-menu">
            <li>
                <a class="logout" onclick="confirmLogout()" style="cursor: pointer; z-index:1;">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="#" class="profile">
                @php
                    $user = Auth::user();
                    $namaPengguna = $user->name;
                    $inisial = $namaPengguna[0];
                @endphp
                <div class="profile-avatar">{{ $inisial }}</div>
            </a>
        </nav>

        <main>
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                    <script>
                        @if (Session::has('success'))
                            toastr.info("{{ Session::get('success') }}", "{{ Auth::user()->name }}", {});
                        @elseif (Session::has('failed'))
                            toastr.error("{{ Session::get('error') }}", "Oops!", {});
                        @endif
                    </script>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        /
                        <li><a href="#" class="active">Home</a></li>
                    </ul>
                </div>
            </div>

            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3>0</h3>
                        <p>Events</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-show-alt'></i>
                    <span class="info">
                        <h3>0</h3>
                        <p>Member Club</p>
                    </span>
                </li>
            </ul>

            <!-- End of Insights -->

    </div>
    </div>

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

        const toggler = document.getElementById('theme-toggle');

        toggler.addEventListener('change', function() {

            if (this.checked) {
                document.body.classList.add('dark');
            } else {
                document.body.classList.remove('dark');
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
                confirmButtonColor: '#18537a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Logout!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('logout') }}";
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
