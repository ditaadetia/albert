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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatable.css') }}">
    <link rel="stylesheet" href="asset('assets/vendor/font-awesome/css/font-awesome.min.css')s">
    <style>
        .border-double { border: 10px double green; }
    </style>

<!-- jquery -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
                        <li class="nav-item">
                            <a class="nav-link {{ (Request::path() === 'denda-terlambat-pengembalian' || Request::path() === 'cari-fine') ? 'active' : '' }}" href="{{ route('denda') }}">
                                <i class="ni ni-money-coins text-yellow" aria-hidden="true"></i>
                                <span class="nav-link-text" style="white-space:pre">Denda</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ (Request::path() === 'fines' || Request::path() === 'cari-fine') ? 'active' : '' }}" href="{{ route('fines.index') }}">
                                <i class="ni ni-money-coins text-yellow" aria-hidden="true"></i>
                                <span class="nav-link-text" style="white-space:pre">Denda</span>
                            </a>
                        </li> --}}
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
    <nav class="navbar navbar-top navbar-expand navbar-dark {{ (Request::path() === route('users.edit', ['user' => auth()->user()->id])) ? 'bg-default' : 'bg-primary' }} border-bottom">
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
     <!-- Header -->
    <div class="header bg-primary pb-6" style="border-bottom-right-radius: 20px; border-bottom-left-radius: 20px;">
        <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                {{-- <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Default</li>
                    </ol>
                    </nav>
                </div> --}}
                </div>
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-muted mb-0">Total Penyewa</h6>
                            <?php $tenants = DB::table('tenants')->count(); ?>
                            <span class="h2 font-weight-bold mb-0">{{ $tenants }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span class="text-nowrap">Since last month</span>
                    </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-muted mb-0">Total Orderan</h6>
                            <?php $orders = DB::table('orders')->count(); ?>
                            <span class="h2 font-weight-bold mb-0">{{ $orders }}</span>
                        </div>
                        <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                            <i class="ni ni-cart"></i>
                        </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        @can('admin')
                            <?php $orders = DB::table('orders')->where('ket_verif_admin', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan
                        @can('kepala_uptd')
                            <?php $orders = DB::table('orders')->where('ket_persetujuan_kepala_uptd', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan
                        @can('kepala_dinas')
                            <?php $orders = DB::table('orders')->where('ket_persetujuan_kepala_dinas', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan
                        <span class="text-nowrap" style="font-size: 12px">Penyewaan Perlu Disetujui</span>
                    </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-muted mb-0">Total Refund</h6>
                            <?php $refunds = DB::table('refunds')->count(); ?>
                            <span class="h2 font-weight-bold mb-0">{{ $refunds }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        @can('admin')
                            <?php $orders = DB::table('refunds')->where('ket_verif_admin', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan
                        @can('kepala_uptd')
                            <?php $orders = DB::table('refunds')->where('ket_persetujuan_kepala_uptd', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan
                        @can('kepala_dinas')
                            <?php $orders = DB::table('refunds')->where('ket_persetujuan_kepala_dinas', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan
                        <span class="text-nowrap" style="font-size: 12px">Refund Perlu Disetujui</span>
                    </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-muted mb-0">Total Reschedule</h6>
                            <?php $reschedules = DB::table('reschedules')->count(); ?>
                            <span class="h2 font-weight-bold mb-0">{{ $reschedules }}</span>
                        </div>
                        <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                            <i class="ni ni-calendar-grid-58"></i>
                        </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        @can('admin')
                            <?php $orders = DB::table('detail_reschedules')->where('ket_verif_admin', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan
                        @can('kepala_uptd')
                            <?php $orders = DB::table('detail_reschedules')->where('ket_persetujuan_kepala_uptd', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan
                        {{-- @can('kepala_dinas')
                            <?php $orders = DB::table('detail_reschedules')->where('ket_persetujuan_kepala_dinas', '=', 'belum')->count(); ?>
                            <span class="text-success mr-2">{{ $orders }}</span>
                        @endcan --}}
                        <span class="text-nowrap" style="font-size: 12px">Reschedule Perlu Disetujui</span>
                    </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    @yield('isicard')
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script src="{{ asset('assets/vendor/signature-pad.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.esm.js" integrity="sha512-l7r77O5BcEK/7O7RdDsjzvcr5vWoXIZUfGFg+Ux5sbZDyAaLvK1AkJS0svnZtK+ns0ZL4B1NW1/Ym/r2D8ajBg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.esm.min.js" integrity="sha512-An8dB8BaoOLn5c8Z4MMGTcynffQQPF83od04ilnUjZFFp8cwCM7xMpz5H1MbdKRGuX05iRiy9mjTqhF5Ycb5gQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.js" integrity="sha512-7Fh4YXugCSzbfLXgGvD/4mUJQty68IFFwB65VQwdAf1vnJSG02RjjSCslDPK0TnGRthFI8/bSecJl6vlUHklaw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/helpers.esm.js" integrity="sha512-D4/TLV2ZsKkp3TEC0YLHfL0cxxLEJRCNkjS81VuswBQD5hDXGcwRAcpI8CXiMMqBbrIyMJjvUuEswEI0STzV6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/helpers.esm.min.js" integrity="sha512-Tr7rEJNzZS8JWzmaQbTL/99DQDgnsklnYBH+mXNvbngHVHPP0hhb2cjWLbFjyKTqE8QZXmEtgC1WDPKZwcrYEw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/vendor/Chart.js/Chart.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
    <?php
        use Carbon\Carbon;
        $tahun = Carbon::now()->format('Y');
        $chartsewajanuari     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='01' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_januari = $chartsewajanuari->jumlah;

        $chartsewafebruari     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='02' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_februari = $chartsewafebruari->jumlah;

        $chartsewamaret     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='03' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_maret = $chartsewamaret->jumlah;

        $chartsewaapril     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='04' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_april = $chartsewaapril->jumlah;

        $chartsewamei     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='05' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_mei = $chartsewamei->jumlah;

        $chartsewajuni     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='06' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_juni = $chartsewajuni->jumlah;

        $chartsewajuli     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='07' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_juli = $chartsewajuli->jumlah;

        $chartsewaagustus     = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='08' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_agustus = $chartsewaagustus->jumlah;

        $chartsewaseptember = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='09' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_september = $chartsewaseptember->jumlah;

        $chartsewaoktober = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='10' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_oktober = $chartsewaoktober->jumlah;

        $chartsewanovember = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='11' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_november = $chartsewanovember->jumlah;

        $chartsewadesember = collect(DB::SELECT("SELECT count(id) AS jumlah from orders where month(created_at)='12' and year(created_at)=$tahun"))->first();
        $jumlah_sewa_desember = $chartsewadesember->jumlah;
    ?>
    <script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
				datasets: [{
					label: 'Jumlah Sewa',
					data: [{{ $jumlah_sewa_januari}}, {{ $jumlah_sewa_februari }}, {{ $jumlah_sewa_maret }}, {{ $jumlah_sewa_april }}, {{ $jumlah_sewa_mei }}, {{ $jumlah_sewa_juni }},{{ $jumlah_sewa_juli }}, {{ $jumlah_sewa_agustus }}, {{ $jumlah_sewa_september }}, {{ $jumlah_sewa_oktober }}, {{ $jumlah_sewa_november }}, {{ $jumlah_sewa_desember }}],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
    <?php $orders = DB::table('orders')->count(); ?>
    <?php $refunds = DB::table('refunds')->count(); ?>
    <?php $reschedules = DB::table('reschedules')->count(); ?>
    <script>
		var ctx = document.getElementById("chartbar").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: ["Total Penyewaan", "Total Refund", "Total Reschedule"],
				datasets: [{
					label: "Rekapitulasi",
					data: [{{ $tenants}}, {{ $refunds }}, {{ $reschedules }}],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
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
