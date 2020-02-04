<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('stisla/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('stisla/modules/fontawesome/css/all.min.css')}}">
  {{-- <link rel="stylesheet" href="{{asset('stisla/modules/datepicker/datepicker3.css')}}">
 --}}  {{-- <link rel="stylesheet" href="{{asset('stisla/modules/bootstrap-daterangepicker/daterangepicker.css')}}"> --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('stisla/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('stisla/css/components.css')}}">
</head>
<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
            </div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{asset('images/'.Auth::user()->photos)}}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::user()->name}} </div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('user.profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              @if(Auth::user()->level==1)
              <a href="{{ route('setting.index') }}" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
               @endif
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
          </div>
          <ul class="sidebar-menu">
          <li class="menu-header">Dashboard</li>      
            <li>
            <a class="nav-link" href="{{route('home')}}">
                <i class="fas fa-columns"></i>
                <span>Dashboard</span>
            </a>
            </li>
            @if(Auth::user()->level==1)
            <li>
                <a class="nav-link" href="{{route('category.index')}}">
                    <i class="fas fa-boxes"></i>
                    <span>Kategori</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('product.index')}}">
                    <i class="fas fa-box"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('supplier.index')}}">
                    <i class="fas fa-dolly-flatbed"></i>
                    <span>Supplier</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('member.index')}}">
                    <i class="fas fa-credit-card"></i>
                    <span>Member</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('spending.index')}}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Pengeluaran</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('user.index')}}">
                    <i class="fas fa-users"></i>
                    <span>User</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('selling.index')}}">
                    <i class="fas fa-store-alt"></i>
                    <span>Penjualan</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('purchase.index')}}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pembelian</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('report.index')}}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </li>
            @else
            <li>
                <a class="nav-link" href="{{route('transaction.index')}}">
                    <i class="fas fa-fire"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{route('transaction.new')}}">
                    <i class="fas fa-fire"></i>
                    <span>Transaksi Baru</span>
                </a>
            </li>
            @endif
            
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield('content-header')</h1>
          </div>

          <div class="section-body">
            @yield('content')
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset('stisla/modules/jquery.min.js')}}"></script>
  <script src="{{asset('stisla/modules/popper.js')}}"></script>
  <script src="{{asset('stisla/modules/tooltip.js')}}"></script>
  <script src="{{asset('stisla/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('stisla/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('stisla/modules/moment.min.js')}}"></script>
  <script src="{{asset('stisla/js/stisla.js')}}"></script>
  {{-- <script src="{{asset('stisla/modules/datepicker/bootstrap-datepicker.js')}}"></script> --}}
  {{-- <script src="{{asset('stisla/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script> --}}
  <!-- JS Libraies -->
  <script src="{{asset('stisla/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('stisla/modules/chart.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('stisla/js/page/components-table.js')}}"></script>
  
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <!-- Template JS File -->
  <script src="{{asset('stisla/js/scripts.js')}}"></script>
  <script src="{{asset('stisla/js/custom.js')}}"></script>
  <script src="{{ asset('stisla/validator.min.js') }}"></script>

  @yield('script')
</body>
</html>