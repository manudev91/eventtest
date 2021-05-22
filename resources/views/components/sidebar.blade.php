<div>
    <!-- Sidebar outter -->
    <div class="main-sidebar sidebar-style-2">
        <!-- sidebar wrapper -->
        <aside id="sidebar-wrapper">
            <!-- sidebar brand -->
            <div class="sidebar-brand">
                <a href="{{ route('welcome') }}">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <!-- sidebar menu -->
            <ul class="sidebar-menu">
                <!-- menu header -->
                <li class="menu-header">General</li>
                <!-- menu item -->
                <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-fire"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ Route::is('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}">
                    <i class="fa fa-id-card" aria-hidden="true"></i>
                        <span>Profile</span>
                    </a>
                </li>
              
                @if(auth()->user()->user_types == "superadmin")
                 
                <li class="{{ Route::is('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-user"></i>
                        <span>Users</span>
                    </a>
                </li>
                @endif
                <li class="{{ Route::is('event.*') ? 'active' : '' }}">
                    <a href="{{ route('event.index') }}">
                        <i class="fa fa-calendar"></i>
                        <span>Events</span>
                    </a>
                </li>

                <li class="{{ Route::is('userevents') ? 'active' : '' }}">
                    <a href="{{ route('userevents') }}">
                        <i class="fa fa-calendar"></i>
                        <span>User Events</span>
                    </a>
                </li>
            </ul>
        </aside>
    </div>
</div>