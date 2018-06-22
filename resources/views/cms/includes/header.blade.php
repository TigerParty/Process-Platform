<nav class="navbar navbar-expand-md navbar-dark bg-second header pt-5">
    <div class="container">
    <div class="navbar-brand ">
        <img class="img-fluid" src="{{ asset('/images/LogoIcon.png')}}">
        <span class="text-white ml-2 mb-0 font-size-1-5">Zambia</span>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse pl-3" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item {{ Request::is(['*location*']) ? 'active' : '' }}">
            <a class="nav-link font-size-1-2" href="{{ route('admin.region.index') }}">
                <i class="fa fa-map-marker mr-1 icon"></i>Location
            </a>
          </li>
        </ul>
        <a href="{{ route('admin.logout') }}" class="font-weight-light float-md-right cursor-pointer text-white">
         <i class="fa fa-sign-out"></i>
          Logout
        </a>
    </div>
    </div>
</nav>
