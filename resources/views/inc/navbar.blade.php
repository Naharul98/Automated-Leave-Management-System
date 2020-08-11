<nav class="navbar navbar-expand-md navbar-light bg-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">
            {{ config('app.name', 'Holiday Reservation') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <!-- If no user is logged in -->
                @guest
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                @endauth
                @auth
                <!-- If user is student -->
                @if(Auth::user()->role != "manager")
                <li class="nav-item"><a class="nav-link" href="/user_area/index">View Previous Requests</a></li>
                <li class="nav-item"><a class="nav-link" href="/user_area/request_new_holiday/">New Request</a></li>
                @endif
                <!-- If user is super-admin -->
                @if(Auth::user()->role == "manager")
                @include('inc.staff_area_navbar_items')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staffs</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/register">Add New Staff</a>
                        <a class="dropdown-item" href="/staff_area/admin">Change Staff</a>
                    </div>
                </li>
                @endif
                @endauth
            </ul>
            @include('inc.navbar_right_snippet')
        </div>
    </div>
</nav>
