@role('admin')
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{url('/admin')}}" class="sidebar-brand">
            Lyndrx<span>App</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    @endrole
    @role('x')
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="{{url('/')}}" class="sidebar-brand">
                Lyndrx<span>App</span>
            </a>
            <div class="sidebar-toggler not-active">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        @endrole
        @role('admin')
        <div class="sidebar-body">
            <ul class="nav">
                <li class="nav-item nav-category">Main</li>
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item nav-category">Manage</li>


                <li class="nav-item">
                    <a href="{{ url('/admin/users') }}" class="nav-link">
                        <i class="link-icon" data-feather="users"></i>
                        <span class="link-title">Users</span>
                </li>
                </a>
                <li class="nav-item">
                    <a href="{{ route('funds.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="dollar-sign"></i>
                        <span class="link-title">Funds</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lynloan.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="dollar-sign"></i>
                        <span class="link-title">Direct fund</span>
                    </a>
                </li>


            </ul>
        </div>
        @endrole

        @role('x')

        <div class="sidebar-body">
            <ul class="nav">
                <li class="nav-item nav-category">Main</li>
                <li class="nav-item">
                    <a href="{{url('/')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item nav-category">Manage</li>
                <li class="nav-item">
                    <a href="{{ url('x/request_loan') }}" class="nav-link">
                        <i class="link-icon" data-feather="unlock"></i>
                        <span class="link-title">Funds</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/x/direct_loan') }}" class="nav-link">
                        <i class="link-icon" data-feather="dollar-sign"></i>
                        <span class="link-title">Direct funds</span>
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
                      <a href="{{ url('/x/information') }}" class="nav-link">Personal Infromation</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/x/notification') }}" class="nav-link">Notifications</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
        </li> --}}
        <li class="nav-item">
            <a href="{{ url('x/loan') }}" class="nav-link">
                <i class="link-icon" data-feather="shield"></i>
                <span class="link-title">Transactions</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('x.funds.index') }}" class="nav-link">
                <i class="link-icon" data-feather="shield"></i>
                <span class="link-title">Add Funds</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('x.funds.withdraw') }}" class="nav-link">
                <i class="link-icon" data-feather="shield"></i>
                <span class="link-title">withdraw Funds</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('x/contact_us') }}" class="nav-link">
                <i class="link-icon" data-feather="users"></i>
                <span class="link-title">Contact Us</span>
            </a>
        </li>

        </ul>
        </div>
        @endrole
    </nav>