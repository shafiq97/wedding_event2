<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">


    <link rel="apple-touch-icon" type="image/png"
        href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />

    <meta name="apple-mobile-web-app-title" content="CodePen">

    <link rel="shortcut icon" type="image/x-icon"
        href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico" />

    <link rel="mask-icon" type="image/x-icon"
        href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-b4b4269c16397ad2f0f7a01bcdf513a1994f4c94b8af2f191c09eb0d601762b1.svg"
        color="#111" />

    <title>Welcome</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/jquery.fullPage.css'>

    <style>
        #next-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            padding: 10px 20px;
        }

        #next-button a {
            display: block;
            padding: 10px 20px;
            background-color: #f15a24;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
            transition: background-color 0.3s ease;
            font-size: 2.8em;
        }

        #next-button a:hover {
            background-color: #d6400f;
        }

        .centered {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .content-wrapper {
            width: 100%;
            height: 100%;
            color: #fff;
            font-family: Montserrat;
            text-transform: uppercase;
            will-change: transform;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transition: all 1.7s cubic-bezier(0.22, 0.44, 0, 1);
            transition: all 1.7s cubic-bezier(0.22, 0.44, 0, 1);
        }

        #landing .content-wrapper {
            color: #333;
        }

        .content-title {
            font-size: 4vh;
            line-height: 1.4;
        }

        p {
            font-size: 2vh;
        }

        #title {
            font-size: 4vh;
            color: #666;
            margin: 20px 0 0 0;
        }

        .section {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            animation: 1s linear;
            /* box-shadow: 0 0 30px rgba(0, 0, 0, 0.3); */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .section:nth-child(1) {
            z-index: 10;
        }

        .section:nth-child(2) {
            background-image: url(https://images.unsplash.com/photo-1482263231623-6121096b0d3f?dpr=1&auto=compress,format&fit=crop&w=1199&h=799&q=80&cs=tinysrgb&crop=);
            z-index: 9;
        }

        .section:nth-child(3) {
            background-image: url(https://images.unsplash.com/photo-1440549770084-4b381ce9d988?dpr=1&auto=compress,format&fit=crop&w=1199&h=800&q=80&cs=tinysrgb&crop=);
            z-index: 8;
        }

        .section:nth-child(4) {
            z-index: 7;
        }

        .section.fp-completely.active {
            z-index: 20;
        }

        .section.active .content-wrapper {
            transform: translateY(-20vh);
            transition: all 5s cubic-bezier(0.22, 0.44, 0, 1) !important;
        }

        .section.fp-completely .content-wrapper {
            transform: translateY(20vh);
            transition: all 5s cubic-bezier(0.22, 0.44, 0, 1) !important;
        }

        .section.fp-completely.active .content-wrapper {
            margin-top: 0;
            transform: translateY(0);
            position: relative;
        }

        .section.prev.down {
            animation-name: toup;
        }

        .section.active.up {
            animation-name: fromup;
        }

        .section.active.down {
            animation-name: fromdown;
            z-index: 12;
        }

        .section.next.up {
            animation-name: todown;
            z-index: 12;
        }

        @keyframes fromdown {
            from {
                transform: translateY(50%);
            }

            100% {
                transform: translateY(0%);
            }
        }

        @keyframes toup {
            from {
                z-index: 20;
                transform: translateY(0%);
            }

            100% {
                z-index: 20;
                transform: translateY(-100%);
            }
        }

        @keyframes fromup {
            from {
                z-index: 20;
                transform: translateY(-100%);
            }

            100% {
                z-index: 20;
                transform: translateY(0%);
            }
        }

        @keyframes todown {
            from {
                transform: translateY(0%);
            }

            100% {
                transform: translateY(50%);
            }
        }
    </style>

    <script>
        window.console = window.console || function(t) {};
    </script>



</head>

<body translate="no">
    

    <div id="homepage">
        <section id="landing" class="background section">
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: darkblue">
                    <div class="container px-2">
                        <div class="div">
                            <img height="50px"
                                src="https://cdn.dribbble.com/users/2419815/screenshots/6674402/attachment_98819509_4x.png"
                                alt="">
                        </div>
                        <a class="navbar-brand" href="{{ route('dashboard') }}">
                            {{ config('app.name') }}
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                            aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarHeader">
                            <ul class="navbar-nav me-md-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard') }}">
                                        <i class="fa fa-home"></i>
                                        {{ __('Homepage') }}
                                    </a>
                                </li>
                            </ul>
                            <ul class="navbar-nav ms-md-auto mt-0">
                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">
                                            <i class="fa fa-sign-in-alt"></i>
                                            {{ __('Login') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">
                                            <i class="fa fa-user-plus"></i>
                                            {{ __('Register') }}
                                        </a>
                                    </li>
                                @else
                                    @php
                                        /** @var \App\Models\User $loggedInUser */
                                        $loggedInUser = \Illuminate\Support\Facades\Auth::user();
                                        $role = $loggedInUser->userRoles->pluck('name')->toArray();
                                        
                                        $canViewEvents = $loggedInUser->can('viewAny', App\Models\Venue::class);
                                        $canViewEventSeries = $loggedInUser->can('viewAny', App\Models\ServiceSeries::class);
                                        $canViewForms = $loggedInUser->can('viewAny', App\Models\Form::class);
                                        $canViewOrganizations = $loggedInUser->can('viewAny', App\Models\Organization::class);
                                        $canViewLocations = $loggedInUser->can('viewAny', App\Models\Location::class);
                                        
                                        $canViewUsers = $loggedInUser->can('viewAny', App\Models\User::class);
                                        $canViewUserRoles = $loggedInUser->can('viewAny', App\Models\UserRole::class);
                                        
                                        $canAdmin = $canViewEvents || $canViewEventSeries || $canViewForms || $canViewOrganizations || $canViewLocations || $canViewUsers || $canViewUserRoles;
                                    @endphp
                                    @if ($canAdmin)
                                        <li class="nav-item dropdown">
                                            <a id="navbarAdminDropdown" class="nav-link dropdown-toggle" href="#"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-wrench"></i>
                                                {{ __('Setting') }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarAdminDropdown">
                                                @if ($canViewEvents)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('events.index') }}">
                                                            <i class="fa fa-fw fa-calendar-days"></i>
                                                            {{ __('Venues') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                {{-- @if ($canViewEventSeries)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('event-series.index') }}">
                                                            <i class="fa fa-fw fa-calendar-week"></i>
                                                            {{ __('Venues series') }}
                                                        </a>
                                                    </li>
                                                @endif --}}
                                                {{-- @if ($canViewForms)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('forms.index') }}">
                                                            <i class="fa fa-fw fa-table-list"></i>
                                                            {{ __('Forms') }}
                                                        </a>
                                                    </li>
                                                @endif --}}
                                                {{-- @if ($canViewOrganizations)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('organizations.index') }}">
                                                            <i class="fa fa-fw fa-sitemap"></i>
                                                            {{ __('Organizations') }}
                                                        </a>
                                                    </li>
                                                @endif --}}
                                                @if ($canViewLocations)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('locations.index') }}">
                                                            <i class="fa fa-fw fa-location-pin"></i>
                                                            {{ __('Locations') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($canViewUsers || $canViewUserRoles)
                                                    <li class="dropdown-divider"></li>
                                                @endif
                                                @if ($canViewUsers)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('users.index') }}">
                                                            <i class="fa fa-fw fa-users"></i>
                                                            {{ __('Users') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($canViewUserRoles)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('user-roles.index') }}">
                                                            <i class="fa fa-fw fa-user-group"></i>
                                                            {{ __('User roles') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('dashboard.landscaper_report') }}">
                                                            <i class="fa fa-fw fa-file-alt"></i>
                                                            {{ __('Reports') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('payments.show') }}">
                                                            <i class="fa fa-fw fa-credit-card"></i>
                                                            {{ __('Payments') }}
                                                        </a>
                                                    </li>
                                                @endif
        
                                            </ul>
                                        </li>
                                    @endif
                                    <li class="nav-item dropdown">
                                        <a id="navbarUserDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user-circle"></i>
                                            Hi, {{ $loggedInUser->name }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                                            @if ($loggedInUser->can('editAccount', \App\Models\User::class))
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('account.edit') }}">
                                                        <i class="fa fa-fw fa-user-cog"></i>
                                                        {{ __('My account') }}
                                                    </a>
                                                </li>
                                                @if ($role[0] == 'User')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('dashboard.bookings') }}">
                                                            <i class="fa fa-fw fa-book"></i>
                                                            {{ __('Bookings') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('wishlist') }}">
                                                            <i class="fa fa-fw fa-heart"></i>
                                                            {{ __('Wishlist') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($role[0] == 'Vendor')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('dashboard.landscaper') }}">
                                                            <i class="fa fa-fw fa-book"></i>
                                                            {{ __('Customer Bookings') }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-fw fa-sign-out-alt"></i>
                                                    {{ __('Logout') }}
                                                </a>
                                            </li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                @csrf
                                            </form>
                                        </ul>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="btn btn-light border-1" href="{{ route('chat.center') }}">
                                            <i class="fa fa-fw fa-comment"></i>
                                            {{ __('Messages') }}
                                        </a>
                                    </li> --}}
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="content-wrapper bgpaper centered">
                <div class="logo">
                    <svg id="web" onclick="obt1.reset().play();" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200"
                        height="200" viewBox="0 0 32 32">
                        <path id="p1" fill="#555"
                            d="M12.468 0.123c-3.568 0.339-6.955 2.155-9.341 5.016-1.614 1.924-2.58 4.058-2.948 6.501-0.245 1.629-0.086 4.151 0.36 5.694 0.757 2.616 2.991 5.254 5.658 6.688 1.254 0.677 2.407 1.088 4.295 1.528 1.254 0.296 1.377 0.303 0.786 0.079-2.011-0.778-4.072-2.335-5.333-4.029-0.937-1.247-1.643-2.84-1.946-4.375-0.166-0.85-0.216-2.479-0.108-3.474 0.577-5.29 4.591-10.234 9.333-11.503 1.47-0.396 3.315-0.497 4.901-0.274 1.139 0.166 2.84 0.605 3.863 1.002 0.454 0.173 0.887 0.339 0.966 0.368 0.252 0.094-0.324-0.382-1.059-0.872-1.744-1.153-4.209-2.025-6.508-2.292-0.836-0.094-2.234-0.13-2.919-0.058z">
                        </path>
                        <path id="p2" fill="#555"
                            d="M22.090 3.503c-1.276 0.123-2.357 0.432-3.423 0.966-0.62 0.317-1.031 0.569-0.937 0.577 0.022 0 0.216-0.065 0.432-0.151 0.627-0.238 1.384-0.353 2.321-0.353 1.96 0 3.726 0.634 5.24 1.896 1.391 1.146 2.45 3.142 2.818 5.276 0.483 2.832-0.18 5.823-1.852 8.36-1.593 2.407-3.813 4.274-6.407 5.391l-0.685 0.296-0.375-0.137c-0.591-0.209-0.605-0.209-0.353 0 0.123 0.101 0.231 0.216 0.231 0.245 0 0.137-2.004 0.598-3.027 0.699-0.541 0.058-0.541 0.058-0.216 0.108 0.699 0.115 2.342 0.050 3.186-0.123 0.195-0.036 0.195-0.036 0.123 0.18-0.108 0.31-0.887 1.016-1.391 1.261-1.016 0.49-2.27 0.771-3.467 0.778-1.189 0-1.859-0.223-2.090-0.699l-0.123-0.267-0.115 0.166c-0.065 0.094-0.115 0.317-0.115 0.512-0.007 0.324 0.014 0.382 0.288 0.634 0.512 0.468 1.11 0.613 2.551 0.605 0.98-0.007 1.29-0.036 1.759-0.159 0.317-0.087 0.584-0.144 0.598-0.13 0.065 0.065-0.476 0.541-0.807 0.706-0.512 0.259-1.384 0.44-1.968 0.404-0.555-0.029-0.872-0.166-0.995-0.411-0.086-0.166-0.086-0.166-0.137 0.065-0.137 0.613 0.879 1.088 2.054 0.98l0.468-0.050-0.18 0.144c-0.404 0.324-1.463 0.432-1.737 0.18-0.151-0.137-0.151-0.137-0.13 0.043 0.058 0.36 0.843 0.548 1.514 0.36 0.382-0.108 0.735-0.368 0.858-0.634 0.079-0.166 0.223-0.288 0.468-0.404 0.692-0.317 1.11-0.843 1.117-1.384 0-0.202 0.050-0.259 0.569-0.555 1.023-0.591 1.434-1.096 1.643-1.982l0.123-0.497 1.124-0.375c2.566-0.85 4.843-2.263 6.811-4.223 2.076-2.083 3.308-4.252 3.87-6.811 0.223-1.023 0.238-3.51 0.036-4.454-0.822-3.726-3.409-6.27-7.013-6.897-0.627-0.108-2.148-0.187-2.659-0.137z">
                        </path>
                        <path id="p3" class="zoomloop" fill="#f15a24"
                            d="M18.775 17.521c-1.067 0.151-2.191 0.649-3.005 1.326-0.512 0.418-1.088 1.088-1.268 1.456-0.065 0.13-0.13 0.238-0.151 0.238s-0.13-0.144-0.245-0.317c-0.677-1.074-2.227-1.146-3.15-0.144-0.454 0.49-0.67 1.031-0.706 1.744-0.058 1.031 0.245 1.477 1.535 2.249 1.038 0.62 1.658 1.139 2.061 1.715l0.123 0.166 0.526-0.404c0.641-0.483 1.6-0.959 3.056-1.514 1.888-0.728 2.854-1.276 3.611-2.068 0.512-0.533 0.793-1.088 0.887-1.751 0.209-1.47-0.569-2.486-2.076-2.703-0.541-0.079-0.598-0.079-1.196 0.007z">
                        </path>
                    </svg>
                    <h1 id="title">Wedding Hall Booking</h1>
                </div>
            </div>
        </section>
        <section class="background section" id="about">
            <div class="content-wrapper centered">
                <div class="container">
                    <h3 class="content-title">Welcome!</h3>
                    <p class="content-subtitle">
                        Welcome to our landscape service! We are a team of experienced professionals who are dedicated
                        to providing top-quality landscaping services for both residential and commercial properties.
                    </p>
                </div>
            </div>
        </section>
        <section id="work" class="background section">
            <div class="content-wrapper centered">
                <div class="container">
                    <h3 class="content-title">Our Mission</h3>
                    <p class="content-subtitle">
                        Our mission is to create beautiful and functional outdoor spaces that meet the unique needs and
                        preferences of each of our clients. We take great pride in our work and strive to exceed
                        expectations on every project we take on.</p>
                </div>
            </div>
        </section>
        <section id="contact" class="background section">
            <div class="content-wrapper centered">
                <div class="container">
                    <h3 class="content-title">Why Choosing Us</h3>
                    <p class="content-subtitle">
                        At our landscape service, we believe that communication and collaboration are key to a
                        successful project. That's why we take the time to listen to our clients and work closely with
                        them throughout the design and installation process.</p>
                </div>
            </div>
        </section>
    </div>
    <script
        src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-2c7831bb44f98c1391d6a4ffda0e1fd302503391ca806e7fcc7b9b87197aec26.js">
    </script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/vendors/jquery.easings.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/vendors/scrolloverflow.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/jquery.fullPage.min.js'></script>
    <script id="rendered-js">
        $(document).ready(function() {
            $('#homepage').fullpage({
                scrollingSpeed: 1000,
                autoScrolling: true,
                fitToSection: true,
                fitToSectionDelay: 2000,
                anchors: ['home', 'about-us', 'what-we-do', 'our-work'],
                sectionsColor: ['#f2f2f2', '#1BBC9B', '#7E8F7C', '#C63D0F'],
                verticalCentered: false,
                navigation: true,
                navigationPosition: 'right',
                navigationTooltips: ['Eureka Mediatech', 'About Us', 'What we do', 'Our Work'],
                responsiveWidth: 900,
                onLeave: function(index, nextIndex, direction) {
                    if (direction == "up") {
                        $(".section").removeClass("down");
                        $(".section").removeClass("next");
                        $(".section").removeClass("prev");
                        $("#homepage .section:nth-child(" + nextIndex + ")").addClass("up");
                        $("#homepage .section:nth-child(" + nextIndex + ")").next().addClass("next up");
                        $("#homepage .section:nth-child(" + nextIndex + ")").prev().addClass("prev up");
                    } else {
                        $(".section").removeClass("up");
                        $(".section").removeClass("next");
                        $(".section").removeClass("prev");
                        $("#homepage .section:nth-child(" + nextIndex + ")").addClass("down");
                        $("#homepage .section:nth-child(" + nextIndex + ")").next().addClass(
                            "next down");
                        $("#homepage .section:nth-child(" + nextIndex + ")").prev().addClass(
                            "prev down");
                    }
                    console.log(direction + nextIndex);
                }
            });

        });
        //# sourceURL=pen.js
    </script>

    <div id="next-button">
        <a href="{{ route('login') }}" class="btn btn-default">Find your wedding hall now!</a>
    </div>
</body>

</html>
