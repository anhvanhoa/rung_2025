<div class="sidenav-menu">

    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo-light">
            <span class="logo-lg"><img src="assets/images/logo.png" alt="logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>

        <span class="logo-dark">
            <span class="logo-lg"><img src="assets/images/logo-dark.png" alt="dark logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>
    </a>
    <button class="button-close-fullsidebar">
        <i class="ri-close-line align-middle"></i>
    </button>
    <div data-simplebar>
        <ul class="side-nav">
            <li class="side-nav-item">
                <a href="/" class="side-nav-link">
                    <span class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" data-lucide="airplay"
                            class="lucide lucide-airplay">
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                            <path d="m12 15 5 6H7Z"></path>
                        </svg></span>
                    <span class="menu-text"> Dashboard </span>
                    <span class="badge bg-danger rounded">3</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false" aria-controls="sidebarPages"
                    class="side-nav-link collapsed">
                    <span class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" data-lucide="file"
                            class="lucide lucide-file">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                        </svg></span>
                    <span class="menu-text">
                        Cơ sở dữ liệu
                    </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPages" style="">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{route('db.processing')}}" class="side-nav-link">
                                <span class="menu-text">Chế biến gỗ</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{route('db.breed')}}" class="side-nav-link">
                                <span class="menu-text">
                                    Sản xuất giống
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
