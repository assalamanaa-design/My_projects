
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title> {{-- Chaque page peut définir son titre --}}
    
    {{-- CSS Bootstrap & FontAwesome --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    
    {{-- CSS personnalisé --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="{{ asset('css/list.css') }}" rel="stylesheet">
    <link href="{{ asset('css/appointments.css') }}" rel="stylesheet">
    <link href="{{ asset('css/inquiries.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Medic Care</h3>
            <button class="btn btn-close" id="closeSidebar"></button>
        </div>
        <ul class="nav flex-column">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-home"></i>Dashboard</a></li>
            <li class="nav-item"><a href="{{ route('admin.appointments') }}"  class="nav-link"><i class="fas fa-calendar-check"></i> Appointments Management</a></li>
            <li class="nav-item"><a href="{{ route('admin.patients') }}"  class="nav-link"><i class="fas fa-users"></i>Patients Management </a></li>
            <li class="nav-item"><a href="{{ route('scans.create') }}" class="nav-link"><i class="fas fa-vial"></i>Posting Scan Results </a></li>
            <li class="nav-item"><a href="{{ route('admin.inquiries') }}" class="nav-link"><i class="fas fa-cog"></i>Checking Patient Inquiry </a></li>
            <li class="nav-item"><a href="{{ route('admin.upgrades') }}" class="nav-link"><i class="fas fa-crown"></i>Upgrade Requests </a></li>
            <li class="nav-item"><a href="{{ route('admin.premium.patients') }}" class="nav-link"><i class="fas fa-user-check"></i>Extenal Patients  </a></li>
            <hr class="sidebar-divider">
            
            <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-sign-out-alt"></i> Log Out</a>
</li>
        </ul>
    </div>

    <!-- Barre supérieure -->
<div class="topbar" id="topbar">
    <div class="d-flex align-items-center">
        <button id="openSidebar" class="btn me-2"><i class="fas fa-bars"></i></button>
        <h2 class="mb-0"> @switch(Route::currentRouteName())
        @case('admin.dashboard')
            Dashboard
            @break
        @case('admin.appointments')
            Appointments Management
            @break
        @case('admin.patients')
            Patients Management
            @break
         @case('scans.create')
            Posting scans
            @break
        @case('admin.inquiries')
            Patient inquiries
            @break 
        @case('admin.upgrades')
            Upgrade Requests 
            @break
        @case('admin.premium.patients')
            External Patients 
            @break    
        @default
            Dashboard
    @endswitch</h2>
    </div>
    <div class="search-container">
        <input type="search" placeholder="Rechercher..." aria-label="Search">
        <i class="fas fa-search search-icon"></i>
    </div>
    <div class="user-info">
    <div class="user-initials">
        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
    </div>
    <span class="user-name me-2">{{ Auth::user()->name }}</span>
    
    <i class="fas fa-bell fa-lg text-primary ms-3"></i>
</div>
</div>


    <!-- Contenu principal -->
    <div class="main-content">
        @yield('content')  {{-- Affichage du contenu spécifique à chaque page --}}
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/graphes.js') }}"></script>
    <script src="{{ asset('js/dashadmin.js') }}"></script>


    
</body>
</html>
