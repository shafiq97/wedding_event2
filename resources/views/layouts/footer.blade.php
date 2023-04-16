<footer>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-2">
            <div class="col">
                <div class="row">
                    <div class="div">
                        <img height="50px"
                            src="https://cdn.dribbble.com/users/2419815/screenshots/6674402/attachment_98819509_4x.png"
                            alt="">
                    </div>
                </div>
                <div class="row">
                    <p>
                        {{ 'Seamless Booking experience!

' }}
                    </p>
                </div>
                <div class="row">
                    <p>
                        {{ 'All right reserve Athirah 2023' }}
                    </p>
                </div>
            </div>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHeader">
                {{-- Left Side Of Navbar --}}
                {{-- <div class="col">
                    <div class="row">
                        <p>
                            {{ __('Quick Link') }}
                        </p>
                    </div>
                </div> --}}

                <ul class="navbar-nav me-md-auto">
                    <div class="col">
                        <div class="row">
                            <a>
                                {{ __('Quick Link') }}
                            </a>
                        </div>
                        @guest
                            <div class="col">
                                <div class="row">
                                    <a href="{{ route('dashboard') }}">
                                        <i class="fa fa-search"></i>
                                        {{ __('Search') }}
                                    </a>
                                </div>
                                <div class="row">
                                    <a href="{{ route('home') }}">
                                        <i class="fa fa-info"></i>
                                        {{ __('About us') }}
                                    </a>
                                </div>
                            </div>
                            @elseauth
                            @php
                                /** @var \App\Models\User $loggedInUser */
                                $loggedInUser = \Illuminate\Support\Facades\Auth::user();
                                
                                $canViewEvents = $loggedInUser->can('viewAny', App\Models\Venue::class);
                                $canViewEventSeries = $loggedInUser->can('viewAny', App\Models\ServiceSeries::class);
                                $canViewForms = $loggedInUser->can('viewAny', App\Models\Form::class);
                                $canViewOrganizations = $loggedInUser->can('viewAny', App\Models\Organization::class);
                                $canViewLocations = $loggedInUser->can('viewAny', App\Models\Location::class);
                                
                                $canViewUsers = $loggedInUser->can('viewAny', App\Models\User::class);
                                $canViewUserRoles = $loggedInUser->can('viewAny', App\Models\UserRole::class);
                                
                                $canAdmin = $canViewEvents || $canViewEventSeries || $canViewForms || $canViewOrganizations || $canViewLocations || $canViewUsers || $canViewUserRoles;
                            @endphp
                            <div class="row">
                                @if ($canViewEvents)
                                    <a class="" href="{{ route('dashboard.landscaper_report') }}">
                                        <i class="fa fa-home"></i>
                                        {{ __('Dashboard') }}
                                    </a>
                                    <a class="" href="{{ route('dashboard') }}">
                                        <i class="fa fa-star"></i>
                                        {{ __('Review') }}
                                    </a>
                                    <a class="" href="{{ route('dashboard.landscaper') }}">
                                        <i class="fa fa-book"></i>
                                        {{ __('Bookings') }}
                                    </a>
                                @else
                                    <a class="btn btn-light" href="{{ route('dashboard') }}">
                                        <i class="fa fa-search"></i>
                                        {{ __('Search') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endauth
                </ul>

                {{-- Right Side Of Navbar --}}
                <ul class="navbar-nav ms-md-auto mt-0">
                    <div class="col">
                        <div class="row">
                            <p>Contact us</p>
                            <a>
                                <i class="fa fa-phone"></i>
                                {{ __('Phone') }}
                                0119129392
                            </a>
                        </div>
                        <div class="row">
                            <a>
                                <i class="fa fa-envelope"></i>
                                {{ __('Email') }}
                                wedding4u@gmail.com
                            </a>
                        </div>
                        <div class="row">
                            <a>
                                <i class="fa fa-facebook"></i>
                                {{ __('Facebook') }}
                            </a>
                        </div>
                        <div class="row">
                            <a>
                                <i class="fa fa-instagram"></i>
                                {{ __('Instagram') }}
                            </a>
                        </div>
                    </div>
                    {{-- @guest
                        @elseauth
                        @php
                            /** @var \App\Models\User $loggedInUser */
                            $loggedInUser = \Illuminate\Support\Facades\Auth::user();
                            
                            $canViewEvents = $loggedInUser->can('viewAny', App\Models\Venue::class);
                            $canViewEventSeries = $loggedInUser->can('viewAny', App\Models\ServiceSeries::class);
                            $canViewForms = $loggedInUser->can('viewAny', App\Models\Form::class);
                            $canViewOrganizations = $loggedInUser->can('viewAny', App\Models\Organization::class);
                            $canViewLocations = $loggedInUser->can('viewAny', App\Models\Location::class);
                            
                            $canViewUsers = $loggedInUser->can('viewAny', App\Models\User::class);
                            $canViewUserRoles = $loggedInUser->can('viewAny', App\Models\UserRole::class);
                            
                            $canAdmin = $canViewEvents || $canViewEventSeries || $canViewForms || $canViewOrganizations || $canViewLocations || $canViewUsers || $canViewUserRoles;
                        @endphp
                    @endauth --}}
                </ul>
            </div>
        </div>
    </nav>
</footer>
