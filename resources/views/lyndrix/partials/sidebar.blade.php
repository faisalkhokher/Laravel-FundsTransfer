<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{url('/lyndrx')}}" class="sidebar-brand">
            Lyndrx<span>App</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{url('/lyndrx')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Manage</li>
            <li class="nav-item">
                <a href="{{ url('lyndrx/loan_tracker') }}" class="nav-link">
                    <i class="link-icon" data-feather="shield"></i>
                    <span class="link-title">Request Tracker</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('lyndrx/explore_page') }}" class="nav-link">
                    <i class="link-icon" data-feather="layout"></i>
                    <span class="link-title">Explore Page</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/lyndrx/direct_loan') }}" class="nav-link">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Direct Fund</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/lyndrx/funds') }}" class="nav-link">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Add Fund</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/lyndrx/withdraw') }}" class="nav-link">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Withdraw Fund</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                  <i class="link-icon" data-feather="settings"></i>
                  <span class="link-title">Setting</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="emails">
                  <ul class="nav sub-menu">
                    <li class="nav-item">
                      <a href="{{ url('/lyndrix/information') }}" class="nav-link">Personal Infromation</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ url('/lyndrix/notification') }}" class="nav-link">Notifications</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('logout')}}" class="nav-link">Logout</a>
                    </li>
                  </ul>
                </div>
              </li> --}}

            <li class="nav-item">
                <a href="{{ url('lyndrx/contact_us') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Contact Us</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.plaid') }}" class="nav-link">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Add Plaid</span>
                </a>
            </li>
         </ul>
    </div>
</nav>

