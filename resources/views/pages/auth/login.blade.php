<!doctype html>
<html lang="vi">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <base href="{{ asset('') }}">
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        @yield('title', 'Hệ thống quản lý nội bộ - Foto Management')
    </title>
    <meta property="og:image" content="{{ asset('/assets/images/banner.jpeg') }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="Hệ thống quản lý nội bộ - Foto Management">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:url" content="{{ asset('') }}">
    <meta property="og:description" content="Xây dựng bởi Công ty CPTM Công nghệ Xuân Mai Green">

    <link href="login/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="login/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="login/css/app.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card overflow-hidden text-center rounded-4 p-xxl-4 p-3 mb-0">

                    <a href="/" class="auth-brand mb-3">
                        <img src="assets/images/logo.png"
                            alt="dark logo" height="70" class="logo-dark">
                        <img src="assets/images/logo.png"
                            alt="logo light" height="70" class="logo-light">
                    </a>

                    <div>
                        <h3 class="fw-semibold text-dark">
                            Đăng nhập vào trang
                        </h3>
                    </div>

                    <form action="{{route("PostLogin")}}" class="mt-3 px-4" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input style="padding: 14px 14px; border: none; background-color: #f1f1f177;" required
                                class="form-control" type="text" name="username" autocomplete="off"
                                placeholder="Nhập tài khoản" value="{{ old('username') }}">
                        </div>

                        <div class="mb-3">
                            <div class="input-group input-group-merge group-password">
                                <input required style="padding: 14px 14px; border: none; background-color: #f1f1f177;"
                                    type="password" id="password" class="form-control" placeholder="Nhập mật khẩu"
                                    name="password">
                                <button id="password-toggle" class="btn btn-light" type="button">
                                    <i data-lucide="eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="w-100 py-2 btn btn-primary fw-medium">
                                Đăng nhập
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/vendor.min.js"></script>
    <script src="login/js/bootstrap.bundle.min.js"></script>
    <script src="login/js/password-addon.init.js"></script>
    <script src="assets/js/vendor.min.js"></script>
    {{--
    <script src="assets/js/app.js"></script> --}}
    <script src="assets/vendor/sumoselect/jquery.sumoselect.js"></script>
    <script src="assets/vendor/flatpickr/flatpickr.min.js"></script>
    <script src="assets/js/toastify.js"></script>
    <script src="assets/js/global.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
        $(document).ready(function () {
            @if (session('success'))
                showToast(@json(session('success')), "success");
            @endif

            @if (session('err'))
                showToast(@json(session('err')), "err");
            @endif

            @if ($errors->all())
                $errs = @Json($errors->all());
                $.each($errs, (i, v) => {
                    showToast(v, "err");
                })
            @endif
        });

        $("#password-toggle").on("click", function () {
            const $this = $(this),
                $password = $("#password");
            if ($password.attr("type") === "password") {
                $password.attr("type", "text");
                $("#password-toggle").html('<i data-lucide="eye-closed"></i>');
            } else {
                $password.attr("type", "password");
                $("#password-toggle").html('<i data-lucide="eye"></i>');
            }
            lucide.createIcons();
        });
    </script>
    @yield('script')
</body>

</html>
