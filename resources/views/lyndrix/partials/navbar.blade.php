<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
  
    <ul class="navbar-nav">

   
      <li class="nav-item dropdown nav-profile">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          
          <h2 class="badge badge-primary mr-2">$ {{Auth::user()->balanceFloat}} </h2>   
          @if (Auth::user()->avatar == NULL)
          <img src="{{asset('profile/user.jpg')}}" class="avatar">
          @else
          <img src="{{asset('storage/profile/'. Auth::user()->avatar)}}" class="avatar">
          @endif
        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdown">
          <div class="dropdown-header d-flex flex-column align-items-center">
            <div class="figure mb-3">
              @if (Auth::user()->avatar == NULL)
              <img  height="30px" src="{{asset('profile/user.jpg')}}" class="avatar">
              @else
              <img  height="30px" src="{{asset('storage/profile/'. Auth::user()->avatar)}}" class="avatar">
              @endif
              
            </div>
            <div class="info text-center">
              <p class="name font-weight-bold mb-0">{{Auth::user()->name}} ({{ Auth::user()->id }})</p>
              <p class="email text-muted mb-3">{{Auth::user()->email}}</p>
            </div>
          </div>
          <div class="dropdown-body">
            <ul class="profile-nav p-0 pt-3">

              <li class="nav-item">
                <a class="nav-link" href="{{ route('lyndrx.profile') }}">
                  <i data-feather="edit"></i>
                  <span>Edit Profile</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('lyndrx.change.role')}}">
                  <i data-feather="log-out"></i>
                  <span>Switch To X</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{url('logout')}}"><i data-feather="log-out"></i> <span>Log Out</span></a>
              </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>
