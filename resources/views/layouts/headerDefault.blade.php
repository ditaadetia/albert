<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>SI-ALBERT - UPTD Alat Berat PUPR Kota Pontianak</title>
    <!-- Favicon -->
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.2.0" type="text/css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo_kota_pontianak.png') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css" type="text/css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.2.0') }}" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatable.css') }}">

<!-- jquery -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
    <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
            <img src="{{ asset('img/logo.svg') }}" class="navbar-brand-img" alt="...">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Nav items -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-home text-primary"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::path() === 'peraturan' ? 'active' : '' }}" href="examples/icons.html">
                        <i class="ni ni-bullet-list-67"></i>
                        <span class="nav-link-text">Peraturan</span>
                    </a>
                </li> --}}
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'tenants'  || Request::path() === 'cari-penyewa') ? 'active' : '' }}" href="{{ route('tenants.index') }}">
                            <i class="fa fa-users text-success"></i>
                            <span class="nav-link-text">Penyewa</span>
                        </a>
                    </li>
                @endcan
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'equipments' || Request::path() === 'search') ? 'active' : '' }}" href="{{ route('equipments.index') }}">
                            <i class="fa fa-truck text-yellow"></i>
                            <span class="nav-link-text">Alat Berat</span>
                        </a>
                    </li>
                @endcan
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                @can('admin_kepalauptd_kepaladinas')
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ Request::path() === 'orders/1' || Request::path() === 'orders/2' || Request::path() === 'orders/3' || Request::path() === 'cari-order' ? 'active' : '' }} dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ni ni-cart text-info"></i>
                            <span class="nav-link-text">Penyewaan</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('index', ['category' => '1']) }}">Umum</a>
                            <a class="dropdown-item" href="{{ route('index', ['category' => '2']) }}">Kegiatan Rutin</a>
                            <a class="dropdown-item" href="{{ route('index', ['category' => '3']) }}">Dinas Lain</a>
                            <a class="dropdown-item" href="{{ route('index', ['category' => '4']) }}">Sosial Masyarakat</a>
                        </div>
                    </li>
                @endcan
                @can('bendahara')
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'skrs' || Request::path() === 'cari-skr') ? 'active' : '' }}" href="{{ route('skrs.index') }}">
                            <i class="ni ni-money-coins text-green" aria-hidden="true"></i>
                            <span class="nav-link-text" style="white-space:pre">SKR</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'payments' || Request::path() === 'cari-payment') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                            <i class="ni ni-money-coins text-green" aria-hidden="true"></i>
                            <span class="nav-link-text" style="white-space:pre">Pembayaran</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'fines' || Request::path() === 'cari-fine') ? 'active' : '' }}" href="{{ route('fines.index') }}">
                            <i class="ni ni-money-coins text-yellow" aria-hidden="true"></i>
                            <span class="nav-link-text" style="white-space:pre">Denda</span>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'denda-terlambat-pengembalian' || Request::path() === 'cari-fine') ? 'active' : '' }}" href="{{ route('denda') }}">
                            <i class="ni ni-money-coins text-yellow" aria-hidden="true"></i>
                            <span class="nav-link-text" style="white-space:pre">Denda</span>
                        </a>
                    </li>
                @endcan
                @can('admin_kepalauptd_kepaladinas')
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'pembatalan' || Request::path() === 'cari-pembatalan') ? 'active' : '' }}" href="{{ route('pembatalan') }}">
                            <i class="ni ni-money-coins text-red"></i>
                            <span class="nav-link-text">Pembatalan</span>
                        </a>
                    </li>
                @endcan
                @can('admin_kepalauptd_kepaladinas')
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'refunds' || Request::path() === 'cari-refund') ? 'active' : '' }}" href="{{ route('refunds.index') }}">
                            <i class="ni ni-money-coins text-red"></i>
                            <span class="nav-link-text">Refund</span>
                        </a>
                    </li>
                @endcan
                @can('bendahara')
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'refunds' || Request::path() === 'cari-refund') ? 'active' : '' }}" href="{{ route('refunds.index') }}">
                            <i class="ni ni-money-coins text-red"></i>
                            <span class="nav-link-text">Refund</span>
                        </a>
                    </li>
                @endcan
                @can('admin_kepalauptd')
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'reschedules' || Request::path() === 'cari-reschedule') ? 'active' : '' }}" href="{{ route('reschedules.index') }}">
                            <i class="ni ni-calendar-grid-58 text-dark"></i>
                            <span class="nav-link-text" style="white-space:pre">Reschedule</span>
                        </a>
                    </li>
                @endcan
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::path() === 'keluar_masuk_alat' || Request::path() === 'cari-keluar-masuk-alat') ? 'active' : '' }}" href="{{ route('keluar-masuk-alat.index') }}">
                            <i class='ni ni-curved-next text-warning'></i>
                            <span class="nav-link-text" style="white-space:pre">Keluar Masuk Alat</span>
                        </a>
                    </li>
                @endcan
            </ul>
            </div>
        </div>
    </div>
</nav>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-default border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item d-xl-none">
                        <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                                data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item d-sm-none">
                            <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ni ni-bell-55 text-blue"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                                <!-- Dropdown header -->
                                <div class="px-3 py-3">
                                <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.
                                </h6>
                                </div>
                                <!-- List group -->
                                <div class="list-group list-group-flush">
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img alt="Image placeholder" src="assets/img/theme/team-1.jpg" class="avatar rounded-circle">
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="mb-0 text-sm">John Snow</h4>
                                        </div>
                                        <div class="text-right text-muted">
                                            <small>2 hrs ago</small>
                                        </div>
                                        </div>
                                        <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                                    </div>
                                    </div>
                                </a>
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img alt="Image placeholder" src="assets/img/theme/team-2.jpg" class="avatar rounded-circle">
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="mb-0 text-sm">John Snow</h4>
                                        </div>
                                        <div class="text-right text-muted">
                                            <small>3 hrs ago</small>
                                        </div>
                                        </div>
                                        <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                                    </div>
                                    </div>
                                </a>
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img alt="Image placeholder" src="assets/img/theme/team-3.jpg" class="avatar rounded-circle">
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="mb-0 text-sm">John Snow</h4>
                                        </div>
                                        <div class="text-right text-muted">
                                            <small>5 hrs ago</small>
                                        </div>
                                        </div>
                                        <p class="text-sm mb-0">Your posts have been liked a lot.</p>
                                    </div>
                                    </div>
                                </a>
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img alt="Image placeholder" src="assets/img/theme/team-4.jpg" class="avatar rounded-circle">
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="mb-0 text-sm">John Snow</h4>
                                        </div>
                                        <div class="text-right text-muted">
                                            <small>2 hrs ago</small>
                                        </div>
                                        </div>
                                        <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                                    </div>
                                    </div>
                                </a>
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img alt="Image placeholder" src="assets/img/theme/team-5.jpg" class="avatar rounded-circle">
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="mb-0 text-sm">John Snow</h4>
                                        </div>
                                        <div class="text-right text-muted">
                                            <small>3 hrs ago</small>
                                        </div>
                                        </div>
                                        <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                                    </div>
                                    </div>
                                </a>
                                </div>
                                <!-- View all -->
                                <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        @if(auth()->user()->foto != '')
                                            <img src="{{ asset('storage/' . auth()->user()->foto) }}" class="user-image" alt="User Image">
                                        @else
                                            <img src="{{ asset('storage/users/no-pict.png')}}" class="user-image" alt="User Image">
                                        @endif
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span style="font-family: 'Josefin Sans', sans-serif !important; color:blue; background-size: cover; width:100%; height:100%" class="hidden-xs">{{ auth()->user()->name }}</span>
                                        <i class="ni ni-bold-down text-blue"></i>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="{{ route('users.edit', ['user' => auth()->user()->id]) }}" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>My profile</span>
                                </a>
                                <a href="{{ route('password.edit', ['password' => auth()->user()->id]) }}" class="dropdown-item">
                                    <i class="fa fa-key"></i>
                                    <span>Ubah Password</span>
                                </a>
                                {{-- <a href="/logout" class="dropdown-item">
                                    <i class="fa fa-key"></i>
                                    <span>Logout</span>
                                </a> --}}
                                <div class="dropdown-divider"></div>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item border-0">
                                        <i class="ni ni-user-run"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="header pb-6 d-flex align-items-center" style="min-height: 500px; border-bottom-right-radius: 20px !important; border-bottom-left-radius: 20px !important; background-image: url({{ asset('assets/img/theme/alat-berat.jpg') }}); background-size: cover; background-position: center top;">
            <!-- Mask -->
            <span class="mask bg-gradient-default opacity-8"></span>
            <!-- Header container -->
            <form action="#" method="post" class="well" id="block-validate" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container-fluid d-flex align-items-center">
                <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="display-1 text-white">Hello, {{ auth()->user()->name }} </h2>
                    @if(auth()->user()->foto != '')
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" style="width:180px; height:180px; border-radius: 50%" class="user-image" alt="User Image">
                    @else
                    <img src="{{ asset('storage/users/no-pict.png') }}" style="width:180px; height:180px; border-radius: 50%" class="user-image" alt="User Image">                    @endif
                    {{-- <div class="form-group">
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" style="width:120px; height:120px; border-radius: 50%" class="user-image" alt="User Image">
                        <input type="file" name="foto" id="foto" class="form-control" style="margin-top:16px;"/>
                        <span class="help-block">Silahkan upload foto untuk update.</span>
                    </div> --}}
                </div>
                {{-- <div class="col-lg-12 col-md-12">
                    <button type="submit" name="update_profil" class="btn btn-warning">
                    <span class="ni ni-check-bold"></span> Ubah Foto Profil
                    </button>
                </div> --}}
                </div>
            </div>
            </form>
        </div>
        @yield('isicardDefault')
    </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <!-- Optional JS -->
  <script src="{{ asset('assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('assets/js/argon.js?v=1.2.0') }}"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
    <script>
        function previewImage() {
            const image = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-preview');
            imgPreview.style.display = 'block'
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src= oFREvent.target.result;
            }
        }
    </script>
    <script>
        function previewBuktiRefund() {
            const image = document.querySelector('#bukti_refund');
            const imgPreview = document.querySelector('.img-preview');
            imgPreview.style.display = 'block'
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src= oFREvent.target.result;
            }
        }
    </script>
  @include('sweetalert::alert')
</body>

</html>
