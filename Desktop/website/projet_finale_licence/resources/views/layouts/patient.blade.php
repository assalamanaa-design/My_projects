<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Booking - Medic Care')</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/templatemo-medic-care.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboardd.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboarddd.css') }}" rel="stylesheet">
    <link href="{{ asset('css/help.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    @stack('styles') <!-- Ceci permet d'ajouter des styles personnalisés dans les pages qui étendent ce layout -->
</head>
<body id="top">
    <main>
        <!-- Header (Navbar) -->

        <nav class="navbar navbar-expand-lg bg-light fixed-top shadow-lg">
            <div class="containerr">
                <a class="navbar-brand mx-auto d-lg-none" href="#">
                    Medic Care
                    <strong class="d-block">Health Specialist</strong>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.dashboard') }}">dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.booking') }}">Booking</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.profile') }}">Medical Profile</a>
                        </li>
                        

                        <!-- Logo au centre -->
                        <a class="navbar-brand d-none d-lg-block" href="#">
                            Medic Care
                            <strong class="d-block">Health Specialist</strong>
                        </a>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.scans') }}">Scans Results</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.help') }}">Help & Support</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">
                                Log Out <img src="{{ asset('images/logout.png') }}" alt="Log Out Icon" style="width: 20px; height: 20px;">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        @yield('content') <!-- La section content sera remplie dans chaque vue qui étend ce layout -->
    </main>

    <footer class="site-footer section-padding" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 me-auto col-12">
                    <h5 class="mb-lg-4 mb-3">Opening Hours</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex">
                            Sunday : Closed
                        </li>
                        <li class="list-group-item d-flex">
                            Monday, Tuesday - Firday
                            <span>8:00 AM - 3:30 PM</span>
                        </li>
                        <li class="list-group-item d-flex">
                            Saturday
                            <span>10:30 AM - 5:30 PM</span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 col-12 my-4 my-lg-0">
                    <h5 class="mb-lg-4 mb-3">Our Clinic</h5>
                    <p><a href="mailto:hello@company.co">hello@company.co</a><p>
                    <p>123 Digital Art Street, San Diego, CA 92123</p>
                </div>

                <div class="col-lg-3 col-md-6 col-12 ms-auto">
                    <h5 class="mb-lg-4 mb-3">Socials</h5>
                    <ul class="social-icon">
                        <li><a href="#" class="social-icon-link bi-facebook"></a></li>
                        <li><a href="#" class="social-icon-link bi-twitter"></a></li>
                        <li><a href="#" class="social-icon-link bi-instagram"></a></li>
                        <li><a href="#" class="social-icon-link bi-youtube"></a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-12 ms-auto mt-4 mt-lg-0">
                    <p class="copyright-text">Copyright © Medic Care 2021 
                    <br><br>Design: <a href="https://templatemo.com" target="_parent">TemplateMo</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS FILES -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/scrollspy.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('scripts') <!-- Ceci permet d'ajouter des scripts personnalisés dans les pages qui étendent ce layout -->
</body>
</html>
