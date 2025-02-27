<header class="app-topbar">
    <div class="page-container topbar-menu">
        <div class="d-flex align-items-center gap-2">

            <a href="#" class="logo" style="padding: 0;">
                <span class="logo-light">
                    <span class="logo-lg"><img src="assets/images/logo.png" alt="logo"></span>
                    <span class="logo-sm"><img height="50" src="assets/images/logo.png" alt="small logo"></span>
                </span>

                <span class="logo-dark">
                    <span class="logo-lg"><img src="assets/images/logo.png" alt="dark logo"></span>
                    <span class="logo-sm"><img src="assets/images/logo.png" alt="small logo"></span>
                </span>
            </a>

            <button class="sidenav-toggle-button px-2">
                <i class="ri-menu-2-line fs-24"></i>
            </button>

            <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="ri-menu-2-line fs-24"></i>
            </button>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="topbar-item d-sm-flex">
                <button class="topbar-link" id="light-dark-mode" type="button">
                    <i data-lucide="moon" class="light-mode-icon fs-22"></i>
                    <i data-lucide="sun" class="dark-mode-icon fs-22"></i>
                </button>
            </div>
            <div class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                        data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-lg-flex flex-column gap-1">
                            <span class="fw-semibold">
                                {{ Auth::user()->name }}
                            </span>
                        </span>
                        <i class="ri-arrow-down-s-line d-none d-lg-block align-middle ms-2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{route('Logout')}}" class="dropdown-item fw-semibold text-danger">
                            <i data-lucide="log-out" class="me-1 fs-16 align-middle"></i>
                            <span class="align-middle">
                                Đăng xuất
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
