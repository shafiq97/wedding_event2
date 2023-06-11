<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                            {{ __('Dashboard') }}
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
                                <a id="navbarAdminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <li class="nav-item">
                            <a class="btn btn-light border-1" href="{{ route('chat.center') }}">
                                <i class="fa fa-fw fa-comment"></i>
                                {{ __('Messages') }}
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
