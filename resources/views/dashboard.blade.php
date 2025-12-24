<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIP - Dashboard Pertanahan Nasional</title>
    <!-- Fontawesome & Google Font -->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
  
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .page-section { display: none; }
        .page-section.active { display: block; }
        .sidebar .nav-item .nav-link.active-menu {
            background-color: rgba(255,255,255,0.1);
            font-weight: 600;
        }
        .modal-backdrop.show { opacity: 0.5; }
        .badge-role, .badge-status {
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 600;
        }
        .table-actions .btn {
            padding: 4px 8px;
            font-size: 12px;
        }
        .form-label-required::after {
            content: '*';
            color: #dc3545;
            margin-left: 4px;
        }
        .data-master-header {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }
        .table-penduduk th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        .table-penduduk td {
            vertical-align: middle;
        }
        .report-card {
            border-left: 4px solid #6f42c1;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .report-icon {
            font-size: 3rem;
            opacity: 0.8;
        }
        .report-header {
            background: linear-gradient(135deg, #6f42c1, #5a32a3);
            color: white;
        }
        .filter-section {
            background-color: #f8f9fc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-box {
            background: white;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-box h4 {
            font-size: 2rem;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-box p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        #page-pengaturan .card {
            border: 1px solid #dee2e6 !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
        }
        #page-pengaturan .card-header {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #dee2e6 !important;
        }
        #page-pengaturan .card-body {
            padding: 20px !important;
        }
        #page-pengaturan .form-group {
            margin-bottom: 15px !important;
        }
        #page-pengaturan .form-control {
            width: 100% !important;
            padding: 8px 12px !important;
            border: 1px solid #ced4da !important;
            border-radius: 4px !important;
        }
        #page-pengaturan .btn {
            padding: 8px 16px !important;
            border-radius: 4px !important;
            border: 1px solid transparent !important;
        }
        .profile-photo-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 2px solid #dee2e6;
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="javascript:void(0)" onclick="showPage('dashboard')">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-globe-asia"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIPertanahan</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('dashboard')" id="menu-dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Fitur Utama</div>
            <!-- MENU PETA PERTANAHAN -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/petnah') }}">
                    <i class="fas fa-map-marked-alt text-warning"></i>
                    <span>Peta Pertanahan</span>
                </a>
            </li>
            <!-- MENU DATA MASTER -->
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('datamaster')" id="menu-datamaster">
                    <i class="fas fa-database text-success"></i>
                    <span>Data Master</span>
                </a>
            </li>
            <!-- MENU MANAJEMEN PENGGUNA -->
            @if(auth()->user()->getRoleNames()->first() === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('users')" id="menu-users">
                    <i class="fas fa-users-cog text-info"></i>
                    <span>Manajemen Pengguna</span>
                </a>
            </li>
            @endif
            <!-- MENU LAPORAN (BARU) -->
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('laporan')" id="menu-laporan">
                    <i class="fas fa-file-alt text-purple"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <!-- MENU PENGATURAN -->
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('pengaturan')" id="menu-pengaturan">
                    <i class="fas fa-cogs text-secondary"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <!-- LOGOUT -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span>Logout</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name ?? 'Admin' }}</span>
                                <img class="img-profile rounded-circle" id="topbarProfilePhoto" src="{{ auth()->user()->profile_photo_url ?? asset('sbadmin/img/undraw_profile.svg') }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DASHBOARD PAGE -->
                    <div id="page-dashboard" class="page-section active">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard Pertanahan Nasional</h1>
                            <span class="text-muted">Update: {{ now()->format('d M Y') }}</span>
                        </div>
                        <!-- Statistik Cards -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Penduduk</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">278,6 Juta Jiwa</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Luas Wilayah Daratan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">1,905 Juta km²</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-mountain fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Bidang Tanah</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">126,4 Juta Bidang</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-vector-square fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Bidang Tersertipikat</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">82,3 Juta (65%)</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-certificate fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Chart + Mini Map Row -->
                        <div class="row">
                            <!-- Chart Progress Sertipikasi -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Progress Sertipikasi Tanah Nasional (2020-2025)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="myAreaChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Mini Peta Indonesia -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Peta Indonesia</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Flag_of_Indonesia.svg/1280px-Flag_of_Indonesia.svg.png"
                                             alt="Peta Indonesia" style="width:100%; max-width:300px; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.1);">
                                        <p class="mt-3 text-muted small">Klik menu <strong>Peta Pertanahan</strong> untuk melihat peta interaktif</p>
                                        <a href="{{ url('/petnah') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-map-marked-alt"></i> Buka Peta Lengkap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Footer Info -->
                        <div class="text-center py-4 text-muted">
                            <small>© 2025 Sistem Informasi Pertanahan Nasional • Kementerian ATR/BPN</small>
                        </div>
                    </div>

                    <!-- DATA MASTER PAGE (PENDUDUK) -->
                    <div id="page-datamaster" class="page-section">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">
                                <i class="fas fa-database text-success"></i> Data Master - Penduduk
                            </h1>
                            <div class="d-flex align-items-center">
                                <input type="text" id="searchPenduduk" class="form-control mr-2" style="max-width: 200px;" placeholder="Cari NIK/Nama...">
                                <button class="btn btn-success btn-sm" onclick="openPendudukModal('add')">
                                    <i class="fas fa-plus"></i> Tambah Penduduk
                                </button>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 data-master-header">
                                <h6 class="m-0 font-weight-bold">Daftar Penduduk Terdaftar</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-penduduk" id="pendudukTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="15%">NIK</th>
                                                <th width="20%">Nama Lengkap</th>
                                                <th width="25%">Alamat</th>
                                                <th width="10%">RT/RW</th>
                                                <th width="15%">Provinsi</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pendudukTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- USER MANAGEMENT PAGE -->
                    <div id="page-users" class="page-section">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-users-cog text-info"></i> Manajemen Pengguna</h1>
                            <button class="btn btn-primary btn-sm" onclick="openUserModal('add')">
                                <i class="fas fa-plus"></i> Tambah Pengguna
                            </button>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna Sistem</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="usersTable" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Nama</th>
                                                <th width="20%">Email</th>
                                                <th width="10%">Role</th>
                                                <th width="12%">Status</th>
                                                <th width="10%">Bahasa</th>
                                                <th width="13%">Terdaftar</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Invitation Form Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">Kirim Undangan Pengguna Baru</h6>
                            </div>
                            <div class="card-body">
                                <form id="inviteForm">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inviteName" class="form-label form-label-required">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="inviteName" name="name" required placeholder="Masukkan nama lengkap">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inviteEmail" class="form-label form-label-required">Email</label>
                                                <input type="email" class="form-control" id="inviteEmail" name="email" required placeholder="contoh@email.com">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="inviteRole" class="form-label form-label-required">Role</label>
                                                <select class="form-control" id="inviteRole" name="role" required>
                                                    <option value="user">User</option>
                                                    <option value="staff">Staff</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="d-flex">
                                                    <button type="submit" class="btn btn-success" id="sendInviteBtn">
                                                        <i class="fas fa-paper-plane"></i> Kirim Undangan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> Email undangan akan dikirim dengan kode verifikasi unik.
                                                Pengguna baru dapat mendaftar menggunakan link yang disediakan dalam email.
                                            </small>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- LAPORAN PAGE (BARU) -->
                    <div id="page-laporan" class="page-section">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">
                                <i class="fas fa-file-alt text-purple"></i> Pusat Laporan Pertanahan
                            </h1>
                            <span class="text-muted">Sistem Pelaporan Terintegrasi</span>
                        </div>
                        <div class="filter-section">
                            <h6 class="font-weight-bold mb-3"><i class="fas fa-filter"></i> Filter Laporan</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Periode Dari</label>
                                        <input type="date" class="form-control" id="filterStartDate">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Periode Sampai</label>
                                        <input type="date" class="form-control" id="filterEndDate">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <select class="form-control" id="filterProvinsi">
                                            <option value="">Semua Provinsi</option>
                                            <option value="DKI Jakarta">DKI Jakarta</option>
                                            <option value="Jawa Barat">Jawa Barat</option>
                                            <option value="Jawa Tengah">Jawa Tengah</option>
                                            <option value="Jawa Timur">Jawa Timur</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-primary btn-block" onclick="applyReportFilter()">
                                            <i class="fas fa-search"></i> Terapkan Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Statistics Overview -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="stat-box border-left-primary">
                                    <p class="text-primary mb-1">Total Laporan</p>
                                    <h4 class="text-primary">2,847</h4>
                                    <small class="text-success"><i class="fas fa-arrow-up"></i> +12% dari bulan lalu</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-success">
                                    <p class="text-success mb-1">Laporan Selesai</p>
                                    <h4 class="text-success">2,103</h4>
                                    <small class="text-muted">74% completion rate</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-warning">
                                    <p class="text-warning mb-1">Dalam Proses</p>
                                    <h4 class="text-warning">581</h4>
                                    <small class="text-muted">20% dari total</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-danger">
                                    <p class="text-danger mb-1">Perlu Tindakan</p>
                                    <h4 class="text-danger">163</h4>
                                    <small class="text-danger"><i class="fas fa-exclamation-circle"></i> Prioritas tinggi</small>
                                </div>
                            </div>
                        </div>
                        <!-- Report Types Cards -->
                        <div class="row">
                            <!-- Laporan Penduduk -->
                            <div class="col-lg-4 mb-4">
                                <div class="card report-card shadow h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="font-weight-bold text-primary mb-0">Laporan Penduduk</h5>
                                            <i class="fas fa-users report-icon text-primary"></i>
                                        </div>
                                        <p class="text-muted mb-3">Laporan data demografi dan statistik kependudukan berdasarkan wilayah dan periode tertentu</p>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Total Data: <strong>278.6 Juta</strong></small>
                                            <small class="text-muted d-block">Update Terakhir: <strong>04 Des 2025</strong></small>
                                        </div>
                                        <button class="btn btn-primary btn-block" onclick="generateLaporanPenduduk()">
                                            <i class="fas fa-file-download"></i> Generate Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Laporan Lahan -->
                            <div class="col-lg-4 mb-4">
                                <div class="card report-card shadow h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="font-weight-bold text-success mb-0">Laporan Lahan</h5>
                                            <i class="fas fa-map-marked-alt report-icon text-success"></i>
                                        </div>
                                        <p class="text-muted mb-3">Laporan kepemilikan, sertifikasi, dan status penggunaan lahan pertanahan nasional</p>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Total Bidang: <strong>126.4 Juta</strong></small>
                                            <small class="text-muted d-block">Tersertifikasi: <strong>65%</strong></small>
                                        </div>
                                        <button class="btn btn-success btn-block" onclick="generateLaporanLahan()">
                                            <i class="fas fa-file-download"></i> Generate Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Laporan Sertifikasi -->
                            <div class="col-lg-4 mb-4">
                                <div class="card report-card shadow h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="font-weight-bold text-warning mb-0">Laporan Sertifikasi</h5>
                                            <i class="fas fa-certificate report-icon text-warning"></i>
                                        </div>
                                        <p class="text-muted mb-3">Laporan progress dan statistik proses sertifikasi tanah berdasarkan wilayah dan tahun</p>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Target 2025: <strong>10 Juta</strong></small>
                                            <small class="text-muted d-block">Tercapai: <strong>7.2 Juta (72%)</strong></small>
                                        </div>
                                        <button class="btn btn-warning btn-block" onclick="generateLaporanSertifikasi()">
                                            <i class="fas fa-file-download"></i> Generate Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Laporan Pengguna -->
                            <div class="col-lg-4 mb-4">
                                <div class="card report-card shadow h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="font-weight-bold text-info mb-0">Laporan Pengguna</h5>
                                            <i class="fas fa-users-cog report-icon text-info"></i>
                                        </div>
                                        <p class="text-muted mb-3">Laporan aktivitas dan manajemen pengguna sistem informasi pertanahan</p>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Total Pengguna: <strong>1,247</strong></small>
                                            <small class="text-muted d-block">Aktif Hari Ini: <strong>832</strong></small>
                                        </div>
                                        <button class="btn btn-info btn-block" onclick="generateLaporanPengguna()">
                                            <i class="fas fa-file-download"></i> Generate Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Laporan Transaksi -->
                            <div class="col-lg-4 mb-4">
                                <div class="card report-card shadow h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="font-weight-bold text-danger mb-0">Laporan Transaksi</h5>
                                            <i class="fas fa-exchange-alt report-icon text-danger"></i>
                                        </div>
                                        <p class="text-muted mb-3">Laporan transaksi jual beli, hibah, waris dan perpindahan hak atas tanah</p>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Transaksi Bulan Ini: <strong>45,812</strong></small>
                                            <small class="text-muted d-block">Nilai: <strong>Rp 2.4 Triliun</strong></small>
                                        </div>
                                        <button class="btn btn-danger btn-block" onclick="generateLaporanTransaksi()">
                                            <i class="fas fa-file-download"></i> Generate Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Laporan Sistem -->
                            <div class="col-lg-4 mb-4">
                                <div class="card report-card shadow h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="font-weight-bold text-secondary mb-0">Laporan Sistem</h5>
                                            <i class="fas fa-cogs report-icon text-secondary"></i>
                                        </div>
                                        <p class="text-muted mb-3">Laporan performa sistem, log aktivitas, dan maintenance log</p>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Uptime: <strong>99.98%</strong></small>
                                            <small class="text-muted d-block">Log Terbaru: <strong>04 Des 2025</strong></small>
                                        </div>
                                        <button class="btn btn-secondary btn-block" onclick="generateLaporanSistem()">
                                            <i class="fas fa-file-download"></i> Generate Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PENGATURAN PAGE -->
                    <div id="page-pengaturan" class="page-section">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cogs text-secondary"></i> Pengaturan & Profil Akun</h1>
                            <span class="text-muted">Kelola akun Anda - {{ auth()->user()->name }}</span>
                        </div>
                        <!-- Profile Info Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-user-circle"></i> Informasi Profil - {{ auth()->user()->name }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Nama Lengkap</th>
                                                <th width="25%">Email</th>
                                                <th width="10%">Role</th>
                                                <th width="12%">Status</th>
                                                <th width="10%">Bahasa</th>
                                                <th width="13%">Bergabung</th>
                                                <th width="5%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td><strong>{{ auth()->user()->name }}</strong></td>
                                                <td>{{ auth()->user()->email }}</td>
                                                <td>
                                                    <span class="badge badge-role {{ auth()->user()->getRoleNames()->first() === 'admin' ? 'badge-danger' : (auth()->user()->getRoleNames()->first() === 'staff' ? 'badge-warning' : 'badge-info') }}">
                                                        {{ auth()->user()->getRoleNames()->first() ?? 'user' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-status {{ auth()->user()->is_approved ? 'badge-success' : 'badge-warning' }}">
                                                        {{ auth()->user()->is_approved ? 'Disetujui' : 'Pending' }}
                                                    </span>
                                                </td>
                                                <td>{{ auth()->user()->language_preference === 'id' ? 'Indonesia' : 'English' }}</td>
                                                <td>{{ auth()->user()->created_at->format('d M Y') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-warning" onclick="editProfile()">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Edit Form Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">
                                    <i class="fas fa-edit"></i> Edit Profil & Pengaturan
                                </h6>
                            </div>
                            <div class="card-body">
                                <form id="profileForm" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <img id="profilePhotoPreview" class="profile-photo-preview" src="{{ auth()->user()->profile_photo_url ?? asset('sbadmin/img/undraw_profile.svg') }}" alt="Foto Profil">
                                            <div class="form-group">
                                                <label for="profile_photo">Ubah Foto Profil</label>
                                                <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label form-label-required">Nama Lengkap</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                               value="{{ auth()->user()->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="email" class="form-label form-label-required">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                               value="{{ auth()->user()->email }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="language">Bahasa Interface</label>
                                                        <select class="form-control" id="language" name="language_preference">
                                                            <option value="id" {{ auth()->user()->language_preference == 'id' ? 'selected' : '' }}>
                                                                Indonesia
                                                            </option>
                                                            <option value="en" {{ auth()->user()->language_preference == 'en' ? 'selected' : '' }}>
                                                                English
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="current_password_profile">Password Saat Ini (untuk konfirmasi)</label>
                                                <input type="password" class="form-control" id="current_password_profile"
                                                       name="current_password" placeholder="Masukkan password saat ini">
                                                <small class="form-text text-muted">Diperlukan untuk mengubah data profil</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="saveProfileBtn">
                                                Simpan Perubahan Profil
                                            </button>
                                            <button type="button" class="btn btn-info ml-2" id="changeLanguageBtn">
                                                Ubah Bahasa
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Password Change Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">
                                    Ubah Password Akun
                                </h6>
                            </div>
                            <div class="card-body">
                                <form id="passwordForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="current_password" class="form-label form-label-required">Password Saat Ini</label>
                                                <input type="password" class="form-control" id="current_password"
                                                       name="current_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password" class="form-label form-label-required">Password Baru</label>
                                                <input type="password" class="form-control" id="password"
                                                       name="password" minlength="6" required>
                                                <small class="form-text text-muted">Minimal 6 karakter</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password_confirmation" class="form-label form-label-required">Konfirmasi Password Baru</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                       name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning" id="changePasswordBtn">
                                        Ubah Password
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Account Statistics Overview -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="stat-box border-left-primary">
                                    <p class="text-primary mb-1">Total Login</p>
                                    <h4 class="text-primary">127</h4>
                                    <small class="text-success">+12% dari bulan lalu</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-success">
                                    <p class="text-success mb-1">Aktivitas</p>
                                    <h4 class="text-success">89%</h4>
                                    <small class="text-muted">Tingkat aktif</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-warning">
                                    <p class="text-warning mb-1">Pengaturan</p>
                                    <h4 class="text-warning">12</h4>
                                    <small class="text-muted">Diubah bulan ini</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-danger">
                                    <p class="text-danger mb-1">Notifikasi</p>
                                    <h4 class="text-danger">5</h4>
                                    <small class="text-danger">Belum dibaca</small>
                                </div>
                            </div>
                        </div>
                        <!-- Tambahan Fitur Pengaturan Lainnya (Lengkapin) -->
                        <!-- Card Pengaturan Notifikasi -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-info">
                                    Pengaturan Notifikasi
                                </h6>
                            </div>
                            <div class="card-body">
                                <form id="notifForm">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="emailNotif" checked>
                                            <label class="custom-control-label" for="emailNotif">Aktifkan Notifikasi Email</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="pushNotif">
                                            <label class="custom-control-label" for="pushNotif">Aktifkan Notifikasi Push</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="notifFrequency">Frekuensi Notifikasi</label>
                                        <select class="form-control" id="notifFrequency">
                                            <option>Harian</option>
                                            <option>Mingguan</option>
                                            <option>Bulanan</option>
                                            <option>Tidak Pernah</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-info">
                                        Simpan Pengaturan Notifikasi
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Card Pengaturan Keamanan -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-danger">
                                    Pengaturan Keamanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <form id="securityForm">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="twoFactor" checked>
                                            <label class="custom-control-label" for="twoFactor">Aktifkan Autentikasi Dua Faktor</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="securityQuestion">Pertanyaan Keamanan</label>
                                        <select class="form-control" id="securityQuestion">
                                            <option>Nama hewan peliharaan pertama Anda?</option>
                                            <option>Nama sekolah dasar Anda?</option>
                                            <option>Kota kelahiran ibu Anda?</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="securityAnswer">Jawaban</label>
                                        <input type="text" class="form-control" id="securityAnswer" placeholder="Masukkan jawaban">
                                    </div>
                                    <button type="submit" class="btn btn-danger">
                                        Simpan Pengaturan Keamanan
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Card Pengaturan Tema -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Pengaturan Tema & Tampilan
                                </h6>
                            </div>
                            <div class="card-body">
                                <form id="themeForm">
                                    <div class="form-group">
                                        <label for="themeMode">Mode Tema</label>
                                        <select class="form-control" id="themeMode">
                                            <option value="light">Terang</option>
                                            <option value="dark">Gelap</option>
                                            <option value="auto">Auto (Ikuti Sistem)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fontSize">Ukuran Font</label>
                                        <select class="form-control" id="fontSize">
                                            <option>Kecil</option>
                                            <option>Sedang</option>
                                            <option>Besar</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="highContrast">
                                            <label class="custom-control-label" for="highContrast">Mode Kontras Tinggi</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        Simpan Pengaturan Tema
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PENDUDUK MODAL -->
    <div class="modal fade" id="pendudukModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pendudukModalTitle">Tambah Penduduk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="pendudukForm">
                    <div class="modal-body">
                        <input type="hidden" id="pendudukId" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pendudukNik" class="form-label form-label-required">NIK</label>
                                    <input type="text" class="form-control" id="pendudukNik" name="nik" required maxlength="16" placeholder="16 digit NIK">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pendudukNama" class="form-label form-label-required">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="pendudukNama" name="nama" required placeholder="Nama lengkap">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pendudukAlamat" class="form-label form-label-required">Alamat</label>
                            <textarea class="form-control" id="pendudukAlamat" name="alamat" rows="3" required placeholder="Alamat lengkap"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pendudukRt" class="form-label form-label-required">RT</label>
                                    <input type="text" class="form-control" id="pendudukRt" name="rt" required maxlength="3" placeholder="001">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pendudukRw" class="form-label form-label-required">RW</label>
                                    <input type="text" class="form-control" id="pendudukRw" name="rw" required maxlength="3" placeholder="001">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pendudukProvinsi" class="form-label form-label-required">Provinsi</label>
                                    <select class="form-control" id="pendudukProvinsi" name="provinsi" required>
                                        <option value="">Pilih Provinsi</option>
                                        <option value="Aceh">Aceh</option>
                                        <option value="Sumatera Utara">Sumatera Utara</option>
                                        <option value="Sumatera Utara">Sumatera Utara</option>
                                        <option value="Sumatera Barat">Sumatera Barat</option>
                                        <option value="Riau">Riau</option>
                                        <option value="Kepulauan Riau">Kepulauan Riau</option>
                                        <option value="Jambi">Jambi</option>
                                        <option value="Sumatera Selatan">Sumatera Selatan</option>
                                        <option value="Bangka Belitung">Bangka Belitung</option>
                                        <option value="Bengkulu">Bengkulu</option>
                                        <option value="Lampung">Lampung</option>
                                        <option value="DKI Jakarta">DKI Jakarta</option>
                                        <option value="Jawa Barat">Jawa Barat</option>
                                        <option value="Banten">Banten</option>
                                        <option value="Jawa Tengah">Jawa Tengah</option>
                                        <option value="DI Yogyakarta">DI Yogyakarta</option>
                                        <option value="Jawa Timur">Jawa Timur</option>
                                        <option value="Bali">Bali</option>
                                        <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                                        <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                                        <option value="Kalimantan Barat">Kalimantan Barat</option>
                                        <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                                        <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                                        <option value="Kalimantan Utara">Kalimantan Utara</option>
                                        <option value="Sulawesi Utara">Sulawesi Utara</option>
                                        <option value="Gorontalo">Gorontalo</option>
                                        <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                                        <option value="Sulawesi Barat">Sulawesi Barat</option>
                                        <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                                        <option value="Maluku">Maluku</option>
                                        <option value="Maluku Utara">Maluku Utara</option>
                                        <option value="Papua Barat">Papua Barat</option>
                                        <option value="Papua">Papua</option>
                                        <option value="Papua Tengah">Papua Tengah</option>
                                        <option value="Papua Pegunungan">Papua Pegunungan</option>
                                        <option value="Papua Selatan">Papua Selatan</option>
                                        <option value="Papua Barat Daya">Papua Barat Daya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="pendudukLatitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="pendudukLatitude" name="latitude" placeholder="-6.123456">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="pendudukLongitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="pendudukLongitude" name="longitude" placeholder="106.123456">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-info btn-block" id="getLocationBtn">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small id="locationStatus" class="text-muted"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitPendudukBtn">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- USER MODAL -->
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">Tambah Pengguna Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="userForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="formAction" value="add">
                        <input type="hidden" id="userId" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userName" class="form-label form-label-required">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="userName" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userEmail" class="form-label form-label-required">Email</label>
                                    <input type="email" class="form-control" id="userEmail" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userPassword" class="form-label" id="passwordRequired">Password</label>
                                    <input type="password" class="form-control" id="userPassword" name="password">
                                    <small id="passwordHint" class="form-text text-muted">Min. 6 karakter</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userRole" class="form-label form-label-required">Role</label>
                                    <select class="form-control" id="userRole" name="role" required>
                                        <option value="user">User</option>
                                        <option value="staff">Staff</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userLanguage" class="form-label">Bahasa</label>
                                    <select class="form-control" id="userLanguage" name="language_preference">
                                        <option value="id">Indonesia</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userApproved" class="form-label">Status Persetujuan</label>
                                    <select class="form-control" id="userApproved" name="is_approved">
                                        <option value="1">Disetujui</option>
                                        <option value="0">Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userReason" class="form-label">Alasan Registrasi</label>
                            <textarea class="form-control" id="userReason" name="registration_reason" rows="3" placeholder="Opsional"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitUserBtn">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin ingin keluar?</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">Pilih "Logout" untuk mengakhiri sesi.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT LENGKAP + FITUR BARU SEMUA JALAN -->
    <script>
        // Sidebar toggle (fix)
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
            document.getElementById('accordionSidebar').classList.toggle('toggled');
        });
        document.getElementById('sidebarToggleTop').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
            document.getElementById('accordionSidebar').classList.toggle('toggled');
        });

        function showPage(pageId) {
            document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));
            document.getElementById('page-' + pageId).classList.add('active');
            document.querySelectorAll('#accordionSidebar .nav-link').forEach(link => link.classList.remove('active-menu'));
            document.getElementById('menu-' + pageId)?.classList.add('active-menu');
        }

        // PENDUDUK - URL penduduk/penduduk
        function loadPenduduk(query = '') {
            fetch(`/penduduk/penduduk${query ? '?search=' + encodeURIComponent(query) : ''}`)
                .then(r => r.json())
                .then(data => {
                    const tbody = document.getElementById('pendudukTableBody');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted py-4">Data tidak ditemukan</td></tr>`;
                        return;
                    }
                    data.forEach((p, i) => {
                        tbody.innerHTML += `<tr>
                            <td>${i+1}</td>
                            <td>${p.nik}</td>
                            <td>${p.nama}</td>
                            <td>${p.alamat}</td>
                            <td>${p.rt}/${p.rw}</td>
                            <td>${p.provinsi}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="openPendudukModal('edit', ${JSON.stringify(p)})">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="if(confirm('Yakin hapus?')) fetch('/penduduk/penduduk/${p.id}', {method:'DELETE', headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'}}).then(()=>loadPenduduk())">Hapus</button>
                            </td>
                        </tr>`;
                    });
                });
        }

        document.getElementById('searchPenduduk').addEventListener('keyup', e => loadPenduduk(e.target.value));

        function openPendudukModal(mode, data = {}) {
            const modal = $('#pendudukModal');
            modal.find('.modal-title').text(mode === 'add' ? 'Tambah Penduduk' : 'Edit Penduduk');
            modal.find('#pendudukId').val(data.id || '');
            modal.find('[name="nik"]').val(data.nik || '');
            modal.find('[name="nama"]').val(data.nama || '');
            modal.find('[name="alamat"]').val(data.alamat || '');
            modal.find('[name="rt"]').val(data.rt || '');
            modal.find('[name="rw"]').val(data.rw || '');
            modal.find('[name="provinsi"]').val(data.provinsi || '');
            modal.modal('show');
        }

        document.getElementById('pendudukForm').onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = formData.get('id');
            const url = id ? `/penduduk/penduduk/${id}` : '/penduduk/penduduk';
            const method = id ? 'PUT' : 'POST';

            fetch(url, {method, body: formData, headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})
                .then(r => r.json())
                .then(d => {
                    Swal.fire('Sukses!', 'Data penduduk berhasil disimpan', 'success');
                    $('#pendudukModal').modal('hide');
                    loadPenduduk();
                });
        };

        // USER - URL users/list
        function loadUsers(query = '') {
            fetch(`/users/list${query ? '?search=' + encodeURIComponent(query) : ''}`)
                .then(r => r.json())
                .then(data => {
                    const tbody = document.getElementById('userTableBody');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-4">Data tidak ditemukan</td></tr>`;
                        return;
                    }
                    data.forEach((u, i) => {
                        tbody.innerHTML += `<tr>
                            <td>${i+1}</td>
                            <td>${u.name}</td>
                            <td>${u.email}</td>
                            <td>${u.role}</td>
                            <td>${u.is_approved ? 'Aktif' : 'Pending'}</td>
                            <td>${u.language_preference === 'id' ? 'Indonesia' : 'English'}</td>
                            <td>${new Date(u.created_at).toLocaleDateString('id-ID')}</td>
                            <td><button class="btn btn-sm btn-warning" onclick="openUserModal('edit', ${JSON.stringify(u)})">Edit</button></td>
                        </tr>`;
                    });
                });
        }

        document.getElementById('searchUsers').addEventListener('keyup', e => loadUsers(e.target.value));

        // Foto profil update
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => {
                document.getElementById('profilePhotoPreview').src = ev.target.result;
                document.getElementById('topbarProfilePhoto').src = ev.target.result;
            };
            reader.readAsDataURL(file);

            const fd = new FormData();
            fd.append('profile_photo', file);
            fd.append('_token', '{{ csrf_token() }}');
            fetch('{{ route("profile.photo") }}', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => {
                    if(d.success) {
                        const url = d.profile_photo_url;
                        document.getElementById('topbarProfilePhoto').src = url;
                        document.getElementById('profilePhotoPreview').src = url;
                        // Store updated photo URL in localStorage for other pages
                        localStorage.setItem('userProfilePhotoUrl', url);
                    }
                });
        });

        // Check for updated profile photo from localStorage
        $(document).ready(function() {
            const storedPhotoUrl = localStorage.getItem('userProfilePhotoUrl');
            if (storedPhotoUrl && document.getElementById('topbarProfilePhoto')) {
                document.getElementById('topbarProfilePhoto').src = storedPhotoUrl;
            }
        });

        // Init
        loadPenduduk();
        loadUsers();
    </script>

    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
    <!-- Scripts -->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

   <script>
    // Setup CSRF Token untuk semua AJAX
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    let dataTable, pendudukTable;

    // Page Navigation (tetap seperti asli)
    function showPage(page) {
        $('.page-section').removeClass('active');
        $('#page-' + page).addClass('active');
        $('.sidebar .nav-link').removeClass('active-menu');
        $('#menu-' + page).addClass('active-menu');

        if (page === 'pengaturan') {
            $('#page-pengaturan').show();
        }

        if (page === 'users') loadUsers();
        if (page === 'datamaster') loadPenduduk();
    }

    $(document).ready(function() {
        // Dashboard aktif pertama
        $('#menu-dashboard').addClass('active-menu');

        // Load data awal
        loadPenduduk();
        loadUsers();

        // Validasi input penduduk (tetap ada)
        $('#pendudukNik').on('input', function() { this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16); });
        $('#pendudukRt, #pendudukRw').on('input', function() { this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3); });
        $('#pendudukLatitude, #pendudukLongitude').on('input', function() { this.value = this.value.replace(/[^0-9.\-]/g, ''); });

        // Geolocation (tetap ada)
        $('#getLocationBtn').on('click', function() {
            const status = $('#locationStatus');
            if (navigator.geolocation) {
                status.text('Mendapatkan lokasi...').removeClass('text-danger text-success').addClass('text-warning');
                navigator.geolocation.getCurrentPosition(
                    pos => {
                        $('#pendudukLatitude').val(pos.coords.latitude.toFixed(6));
                        $('#pendudukLongitude').val(pos.coords.longitude.toFixed(6));
                        status.text('Lokasi berhasil!').addClass('text-success').removeClass('text-warning');
                    },
                    err => {
                        status.text('Gagal mendapatkan lokasi').addClass('text-danger');
                    }
                );
            } else {
                status.text('Browser tidak mendukung geolokasi').addClass('text-danger');
            }
        });
    });

    // Undangan pengguna (tetap seperti asli)
    function submitInviteForm(e) {
        e.preventDefault();
        sendInvite();
    }

    function sendInvite() {
        const data = {
            name: $('#inviteName').val().trim(),
            email: $('#inviteEmail').val().trim(),
            role: $('#inviteRole').val()
        };
        if (!data.name || !data.email || !data.role) return Swal.fire('Error!', 'Semua field wajib!', 'error');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) return Swal.fire('Error!', 'Email salah!', 'error');

        $('#sendInviteBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Membuat...');
        $.ajax({
            url: '{{ url("/users/invite") }}',
            method: 'POST',
            data: data,
            success: function(response) {
                $('#inviteForm')[0].reset();
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: response.message, timer: 2000, showConfirmButton: false })
                    .then(() => window.open(response.gmail_url, '_blank'));
                loadUsers();
            },
            error: function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal membuat user', 'error');
            },
            complete: function() {
                $('#sendInviteBtn').prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Kirim Undangan');
            }
        });
    }

    // === USER MANAGEMENT (CRUD full AJAX + auto refresh) ===
    function loadUsers() {
        $.get('{{ url("/users/list") }}').done(function(response) {
            let html = '';
            response.users.forEach((user, index) => {
                const roleName = user.roles?.[0]?.name || 'user';
                const roleClass = roleName === 'admin' ? 'danger' : roleName === 'staff' ? 'warning' : 'info';
                const statusClass = user.is_approved ? 'success' : 'warning';
                html += `<tr>
                    <td class="text-center">${index + 1}</td>
                    <td><strong>${user.name}</strong></td>
                    <td>${user.email}</td>
                    <td><span class="badge badge-role badge-${roleClass}">${roleName.toUpperCase()}</span></td>
                    <td><span class="badge badge-status badge-${statusClass}">${user.is_approved ? 'Disetujui' : 'Pending'}</span></td>
                    <td>${user.language_preference === 'id' ? 'Indonesia' : 'English'}</td>
                    <td>${new Date(user.created_at).toLocaleDateString('id-ID')}</td>
                    <td class="text-center table-actions">
                        <button class="btn btn-sm btn-warning" onclick="editUser(${user.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
            });
            $('#userTableBody').html(html || '<tr><td colspan="8" class="text-center">Tidak ada data</td></tr>');

            if (dataTable) dataTable.destroy();
            dataTable = $('#usersTable').DataTable({
                language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
                pageLength: 10
            });
        });
    }

    function openUserModal(action, userId = null) {
        $('#userForm')[0].reset();
        $('#formAction').val(action);
        if (action === 'add') {
            $('#userModalTitle').text('Tambah Pengguna Baru');
            $('#userId').val('');
            $('#userPassword').prop('required', true);
            $('#passwordRequired').addClass('form-label-required');
            $('#passwordHint').text('Min. 6 karakter');
            $('#submitUserBtn').html('<i class="fas fa-save"></i> Simpan');
        } else {
            $('#userModalTitle').text('Edit Pengguna');
            $('#userPassword').prop('required', false);
            $('#passwordRequired').removeClass('form-label-required');
            $('#passwordHint').text('Kosongkan jika tidak ingin ubah password');
            $('#submitUserBtn').html('<i class="fas fa-save"></i> Update');
        }
        $('#userModal').modal('show');
    }

    function editUser(id) {
        $.get('{{ url("/users") }}/' + id).done(function(response) {
            openUserModal('edit');
            $('#userId').val(response.id);
            $('#userName').val(response.name);
            $('#userEmail').val(response.email);
            $('#userRole').val(response.roles?.[0]?.name || 'user');
            $('#userLanguage').val(response.language_preference);
            $('#userApproved').val(response.is_approved ? '1' : '0');
            $('#userReason').val(response.registration_reason);
        });
    }

    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const action = $('#formAction').val();
        const userId = $('#userId').val();
        let url = '{{ url("/users") }}';
        if (action === 'edit') {
            url += '/' + userId;
            formData.append('_method', 'PUT');
        }

        $('#submitUserBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#userModal').modal('hide');
                Swal.fire({icon: 'success', title: 'Berhasil!', text: response.message || 'Data tersimpan', timer: 2000});
                loadUsers();
            },
            error: function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal simpan', 'error');
            },
            complete: function() {
                $('#submitUserBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
            }
        });
    });

    function deleteUser(id) {
        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data pengguna akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url("/users/users") }}/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire('Terhapus!', '', 'success');
                        loadUsers();
                    }
                });
            }
        });
    }

    // === DATA MASTER PENDUDUK (CRUD full AJAX + auto refresh) ===
    function loadPenduduk(search = '') {
        $.get('{{ url("/penduduk/penduduk") }}', { search }).done(function(response) {
            let html = '';
            if (response.length === 0) {
                html = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
            } else {
                response.forEach((item, i) => {
                    html += `<tr>
                        <td>${i+1}</td>
                        <td><strong>${item.nik}</strong></td>
                        <td>${item.nama}</td>
                        <td>${item.alamat.substring(0,50)}${item.alamat.length > 50 ? '...' : ''}</td>
                        <td>${item.rt || '-'}/${item.rw || '-'}</td>
                        <td>${item.provinsi || '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editPenduduk(${item.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="deletePenduduk(${item.id})"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                });
            }
            $('#pendudukTableBody').html(html);

            if (pendudukTable) pendudukTable.destroy();
            pendudukTable = $('#pendudukTable').DataTable({
                language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
                pageLength: 10,
                ordering: false,
                searching: false
            });
        });
    }

    function openPendudukModal(action, data = null) {
        $('#pendudukForm')[0].reset();
        $('#pendudukId').val('');
        $('#pendudukModalTitle').text(action === 'add' ? 'Tambah Penduduk' : 'Edit Penduduk');
        if (data) {
            $('#pendudukId').val(data.id);
            $('#pendudukNik').val(data.nik);
            $('#pendudukNama').val(data.nama);
            $('#pendudukAlamat').val(data.alamat);
            $('#pendudukRt').val(data.rt);
            $('#pendudukRw').val(data.rw);
            $('#pendudukProvinsi').val(data.provinsi);
            $('#pendudukLatitude').val(data.latitude || '');
            $('#pendudukLongitude').val(data.longitude || '');
        }
        $('#pendudukModal').modal('show');
    }

    function editPenduduk(id) {
        $.get(`{{ url("/penduduk/penduduk") }}/${id}`).done(data => openPendudukModal('edit', data));
    }

    $('#pendudukForm').on('submit', function(e) {
        e.preventDefault();

        const nik = $('#pendudukNik').val().trim();
        if (!/^\d{16}$/.test(nik)) return Swal.fire('Error!', 'NIK harus 16 digit angka!', 'error');

        const rt = $('#pendudukRt').val().trim();
        const rw = $('#pendudukRw').val().trim();
        if (!rt || !rw || !/^\d{1,3}$/.test(rt) || !/^\d{1,3}$/.test(rw)) return Swal.fire('Error!', 'RT/RW harus angka 1-3 digit!', 'error');

        const lat = $('#pendudukLatitude').val().trim();
        const lng = $('#pendudukLongitude').val().trim();
        if (lat && (isNaN(lat) || lat < -90 || lat > 90)) return Swal.fire('Error!', 'Latitude salah!', 'error');
        if (lng && (isNaN(lng) || lng < -180 || lng > 180)) return Swal.fire('Error!', 'Longitude salah!', 'error');

        // Dummy fields tetap ditambahkan
        $(this).append('<input type="hidden" name="tanggal_lahir" value="1990-01-01">');
        $(this).append('<input type="hidden" name="jenis_kelamin" value="Laki-laki">');
        $(this).append('<input type="hidden" name="status_perkawinan" value="Belum Kawin">');
        $(this).append('<input type="hidden" name="pekerjaan" value="Tidak diketahui">');

        const id = $('#pendudukId').val();
        const url = id ? `{{ url("/penduduk/penduduk") }}/${id}` : '{{ url("/penduduk/penduduk") }}';
        const method = id ? 'PUT' : 'POST';

        $('#submitPendudukBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: url,
            method: method,
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function() {
                $('#pendudukModal').modal('hide');
                Swal.fire('Sukses!', 'Data penduduk tersimpan', 'success');
                loadPenduduk($('#searchPenduduk').val());
            },
            error: function() {
                Swal.fire('Error!', 'Gagal menyimpan penduduk', 'error');
            },
            complete: function() {
                $('#submitPendudukBtn').prop('disabled', false).html('Simpan');
            }
        });
    });

    function deletePenduduk(id) {
        Swal.fire({
            title: 'Yakin hapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url("/penduduk/penduduk") }}/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire('Terhapus!', '', 'success');
                        loadPenduduk($('#searchPenduduk').val());
                    }
                });
            }
        });
    }

    // === SETTINGS PAGE (semua fungsi tetap utuh) ===
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#saveProfileBtn');
        const original = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: '{{ url("/profile") }}',
            method: 'PATCH',
            data: $(this).serialize(),
            success: function() {
                Swal.fire({icon: 'success', title: 'Berhasil!', text: 'Profil diperbarui', timer: 2000});
                if ($('#name').val() !== '{{ auth()->user()->name }}') $('.sidebar .text-gray-600').text($('#name').val());
            },
            error: function(xhr) { Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal update profil', 'error'); },
            complete: () => btn.prop('disabled', false).html(original)
        });
    });

    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();
        if ($('#password').val() !== $('#password_confirmation').val()) return Swal.fire('Error!', 'Konfirmasi password beda!', 'error');

        const btn = $('#changePasswordBtn');
        const original = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengubah...');

        $.ajax({
            url: '{{ url("/pengaturan/password") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                Swal.fire({icon: 'success', title: 'Berhasil!', text: 'Password diubah', timer: 2000});
                $('#passwordForm')[0].reset();
            },
            error: function(xhr) { Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal ubah password', 'error'); },
            complete: () => btn.prop('disabled', false).html(original)
        });
    });

    $('#changeLanguageBtn').on('click', function() {
        const lang = $('#language').val();
        const btn = $(this);
        const original = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengubah...');

        $.ajax({
            url: '{{ url("/pengaturan/lang") }}',
            method: 'POST',
            data: { lang: lang, _token: '{{ csrf_token() }}' },
            success: function() {
                Swal.fire({icon: 'success', title: 'Berhasil!', text: 'Bahasa diubah. Reload...', timer: 2000});
                setTimeout(() => location.reload(), 1500);
            },
            error: function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal ubah bahasa', 'error');
                btn.prop('disabled', false).html(original);
            }
        });
    });

    // Chart (tetap ada)
    var ctx = document.getElementById('myAreaChart').getContext('2d');
    var myAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
            datasets: [{
                label: 'Bidang Tersertipikat (Juta)',
                data: [45, 58, 68, 75, 80, 82.3],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: false } }
        }
    });
</script>
</body>
</html>