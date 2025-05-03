<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <!-- Kaiadmin-style search -->
        <form class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-search pe-1" type="submit">
                        <i class="fa fa-search search-icon"></i>
                    </button>
                </div>
                <input type="text" placeholder="Search ..." class="form-control">
            </div>
        </form>

        <!-- Navbar right section -->
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

            <!-- Small screen search toggle -->
            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn" aria-labelledby="searchDropdown">
                    <form class="navbar-left navbar-form nav-search">
                        <div class="input-group">
                            <input type="text" placeholder="Search ..." class="form-control">
                        </div>
                    </form>
                </ul>
            </li>

            <!-- Messages -->
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="fa fa-envelope"></i>
                </a>
                <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                    <li><div class="dropdown-title d-flex justify-content-between align-items-center">Messages <a class="small" href="#">Mark all as read</a></div></li>
                    <li>
                        <div class="message-notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="#"><div class="notif-img"><img src="{{ asset('assets/img/jm_denis.jpg') }}" alt="Profile"></div><div class="notif-content"><span class="subject">Jimmy</span><span class="block">How are you?</span></div></a>
                                <a href="#"><div class="notif-img"><img src="{{ asset('assets/img/chadengle.jpg') }}" alt="Profile"></div><div class="notif-content"><span class="subject">Chad</span><span class="block">Thanks!</span></div></a>
                            </div>
                        </div>
                    </li>
                    <li><a class="see-all" href="#">See all messages<i class="fa fa-angle-right"></i></a></li>
                </ul>
            </li>

            <!-- Notifications -->
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li><div class="dropdown-title">You have 4 new notification</div></li>
                    <li>
                        <div class="notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="#"><div class="notif-icon notif-primary"><i class="fa fa-user-plus"></i></div><div class="notif-content">New user registered</div></a>
                                <a href="#"><div class="notif-icon notif-success"><i class="fa fa-comment"></i></div><div class="notif-content">Comment on Admin</div></a>
                            </div>
                        </div>
                    </li>
                    <li><a class="see-all" href="#">See all notifications<i class="fa fa-angle-right"></i></a></li>
                </ul>
            </li>

            <!-- Quick Actions -->
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link" data-bs-toggle="dropdown" href="#"><i class="fas fa-layer-group"></i></a>
                <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                        <span class="title mb-1">Quick Actions</span>
                        <span class="subtitle op-7">Shortcuts</span>
                    </div>
                </div>
            </li>

            <!-- User Profile -->
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                    <div class="avatar-sm">
                        <img src="https://i.pravatar.cc/40?img=3" alt="avatar" class="avatar-img rounded-circle">
                    </div>
                    <span class="profile-username">
                        <span class="op-7">Hi,</span>
                        <span class="fw-bold">{{ Auth::user()->nama }}</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg"><img src="https://i.pravatar.cc/100?img=3" alt="image profile" class="avatar-img rounded"></div>
                                <div class="u-text">
                                    <h4>{{ Auth::user()->nama }}</h4>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                </div>
                            </div>
                        </li>
                        <li><div class="dropdown-divider"></div></li>
                        <li><a class="dropdown-item" href="#">My Profile</a></li>
                        <li><a class="dropdown-item" href="#">Inbox</a></li>
                        <li><a class="dropdown-item" href="#">Account Setting</a></li>
                        <li><div class="dropdown-divider"></div></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>