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
        .profile-photo-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 2px solid #dee2e6;
        }
        .modal-xl {
            max-width: 95%;
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
            
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/petnah') }}">
                    <i class="fas fa-map-marked-alt text-warning"></i>
                    <span>Peta Pertanahan</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('datamaster')" id="menu-datamaster">
                    <i class="fas fa-database text-success"></i>
                    <span>Data Master</span>
                </a>
            </li>
            
            @if(auth()->user()->getRoleNames()->first() === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('users')" id="menu-users">
                    <i class="fas fa-users-cog text-info"></i>
                    <span>Manajemen Pengguna</span>
                </a>
            </li>
            @endif
            
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('laporan')" id="menu-laporan">
                    <i class="fas fa-file-alt text-purple"></i>
                    <span>Laporan</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="showPage('pengaturan')" id="menu-pengaturan">
                    <i class="fas fa-cogs text-secondary"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            
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
                
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DASHBOARD PAGE -->
                    <div id="page-dashboard" class="page-section active">
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
                    </div>

                    <!-- DATA MASTER PAGE -->
                    <div id="page-datamaster" class="page-section">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">
                                <i class="fas fa-database text-success"></i> Data Master - Penduduk
                            </h1>
                            <div>
                                <button class="btn btn-info btn-sm mr-2" onclick="loadPenduduk()" title="Refresh data">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
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
                                        <tbody id="pendudukTableBody">
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="fas fa-spinner fa-spin"></i> Memuat data...
                                                </td>
                                            </tr>
                                        </tbody>
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
                                <form id="inviteForm" onsubmit="submitInviteForm(event)">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inviteName" class="form-label form-label-required">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="inviteName" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inviteEmail" class="form-label form-label-required">Email</label>
                                                <input type="email" class="form-control" id="inviteEmail" name="email" required>
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
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block" id="sendInviteBtn">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- LAPORAN PAGE -->
                    <div id="page-laporan" class="page-section">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">
                                <i class="fas fa-file-alt text-purple"></i> Pusat Laporan Pertanahan
                            </h1>
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
                                        <button class="btn btn-primary btn-block">
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
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-success">
                                    <p class="text-success mb-1">Laporan Selesai</p>
                                    <h4 class="text-success">2,103</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-warning">
                                    <p class="text-warning mb-1">Dalam Proses</p>
                                    <h4 class="text-warning">581</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box border-left-danger">
                                    <p class="text-danger mb-1">Perlu Tindakan</p>
                                    <h4 class="text-danger">163</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PENGATURAN PAGE -->
                    <div id="page-pengaturan" class="page-section">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cogs text-secondary"></i> Pengaturan & Profil Akun</h1>
                        </div>
                        
                        <!-- Profile Info Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
                            </div>
                            <div class="card-body">
                                <form id="profileForm">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <img id="profilePhotoPreview" class="profile-photo-preview" 
                                                 src="{{ auth()->user()->profile_photo_url ?? asset('sbadmin/img/undraw_profile.svg') }}">
                                            <div class="form-group">
                                                <label for="profile_photo">Ubah Foto Profil</label>
                                                <input type="file" class="form-control-file" id="profile_photo" 
                                                       name="profile_photo" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nama Lengkap</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                               value="{{ auth()->user()->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                               value="{{ auth()->user()->email }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="saveProfileBtn">
                                                <i class="fas fa-save"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Password Change Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-warning">Ubah Password</h6>
                            </div>
                            <div class="card-body">
                                <form id="passwordForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Password Saat Ini</label>
                                                <input type="password" class="form-control" name="current_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Password Baru</label>
                                                <input type="password" class="form-control" id="password" 
                                                       name="password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Konfirmasi Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" 
                                                       name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning" id="changePasswordBtn">
                                        <i class="fas fa-key"></i> Ubah Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PENDUDUK -->
    <div class="modal fade" id="pendudukModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="pendudukModalTitle">Tambah Penduduk</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="pendudukForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="pendudukId" name="id">
                        
                        <!-- Informasi Dasar -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-id-card"></i> Informasi Identitas</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pendudukNik">NIK <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pendudukNik" name="nik" 
                                                   maxlength="16" placeholder="16 digit angka" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pendudukNama">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pendudukNama" name="nama" 
                                                   placeholder="Nama lengkap sesuai KTP" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pendudukTanggalLahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="pendudukTanggalLahir" name="tanggal_lahir">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pendudukJenisKelamin">Jenis Kelamin</label>
                                            <select class="form-control" id="pendudukJenisKelamin" name="jenis_kelamin">
                                                <option value="">Pilih</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="pendudukAlamat">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="pendudukAlamat" name="alamat" 
                                              rows="2" placeholder="Alamat lengkap" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pendudukRt">RT <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pendudukRt" name="rt" 
                                                   maxlength="3" placeholder="001" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pendudukRw">RW <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pendudukRw" name="rw" 
                                                   maxlength="3" placeholder="001" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pendudukKelurahan">Kelurahan/Desa</label>
                                            <input type="text" class="form-control" id="pendudukKelurahan" name="kelurahan">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pendudukKecamatan">Kecamatan</label>
                                            <input type="text" class="form-control" id="pendudukKecamatan" name="kecamatan">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pendudukKota">Kota/Kabupaten</label>
                                            <input type="text" class="form-control" id="pendudukKota" name="kota">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pendudukProvinsi">Provinsi <span class="text-danger">*</span></label>
                                            <select class="form-control" id="pendudukProvinsi" name="provinsi" required>
                                                <option value="">Pilih Provinsi</option>
                                                <option value="Aceh">Aceh</option>
                                                <option value="Sumatera Utara">Sumatera Utara</option>
                                                <option value="Sumatera Barat">Sumatera Barat</option>
                                                <option value="Riau">Riau</option>
                                                <option value="Jambi">Jambi</option>
                                                <option value="Sumatera Selatan">Sumatera Selatan</option>
                                                <option value="Bengkulu">Bengkulu</option>
                                                <option value="Lampung">Lampung</option>
                                                <option value="DKI Jakarta">DKI Jakarta</option>
                                                <option value="Jawa Barat">Jawa Barat</option>
                                                <option value="Jawa Tengah">Jawa Tengah</option>
                                                <option value="DI Yogyakarta">DI Yogyakarta</option>
                                                <option value="Jawa Timur">Jawa Timur</option>
                                                <option value="Bali">Bali</option>
                                                <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                                                <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Koordinat GPS -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-crosshairs"></i> Koordinat GPS (Opsional)</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="pendudukLatitude">Latitude</label>
                                            <input type="text" class="form-control" id="pendudukLatitude" name="latitude" 
                                                   placeholder="-6.123456">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="pendudukLongitude">Longitude</label>
                                            <input type="text" class="form-control" id="pendudukLongitude" name="longitude" 
                                                   placeholder="106.123456">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-info btn-block" id="getLocationBtn" title="Dapatkan Lokasi GPS">
                                            <i class="fas fa-crosshairs"></i> GPS
                                        </button>
                                    </div>
                                </div>
                                <small id="locationStatus" class="form-text"></small>
                            </div>
                        </div>

                        <!-- Data Kontak & Pribadi -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-user"></i> Data Pribadi & Kontak (Opsional)</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pendudukAgama">Agama</label>
                                            <select class="form-control" id="pendudukAgama" name="agama">
                                                <option value="">Pilih</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen">Kristen</option>
                                                <option value="Katolik">Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pendudukPekerjaan">Pekerjaan</label>
                                            <input type="text" class="form-control" id="pendudukPekerjaan" name="pekerjaan">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pendudukStatusKawin">Status Perkawinan</label>
                                            <select class="form-control" id="pendudukStatusKawin" name="status_kawin">
                                                <option value="">Pilih</option>
                                                <option value="Belum Kawin">Belum Kawin</option>
                                                <option value="Kawin">Kawin</option>
                                                <option value="Cerai Hidup">Cerai Hidup</option>
                                                <option value="Cerai Mati">Cerai Mati</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pendudukTelepon">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="pendudukTelepon" name="telepon" maxlength="15">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pendudukEmail">Email</label>
                                            <input type="email" class="form-control" id="pendudukEmail" name="email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success" id="submitPendudukBtn">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL PENDUDUK -->
    <div class="modal fade" id="detailPendudukModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-eye"></i> Detail Penduduk</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detailPendudukContent">
                    <div class="text-center py-4">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p class="mt-2">Memuat data...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- USER MODAL -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="userForm">
                    <div class="modal-body">
                        <input type="hidden" id="formAction" value="add">
                        <input type="hidden" id="userId" name="id">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userName" class="form-label-required">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="userName" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userEmail" class="form-label-required">Email</label>
                                    <input type="email" class="form-control" id="userEmail" name="email" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userPassword" id="passwordRequired">Password</label>
                                    <input type="password" class="form-control" id="userPassword" name="password">
                                    <small id="passwordHint" class="form-text text-muted">Min. 6 karakter</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userRole" class="form-label-required">Role</label>
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
                                    <label for="userLanguage">Bahasa</label>
                                    <select class="form-control" id="userLanguage" name="language_preference">
                                        <option value="id">Indonesia</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userApproved">Status</label>
                                    <select class="form-control" id="userApproved" name="is_approved">
                                        <option value="1">Disetujui</option>
                                        <option value="0">Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitUserBtn">Simpan</button>
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

    <!-- Scripts -->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

    <script>
    // Setup CSRF Token
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    let dataTable, pendudukTable;
    let pendudukData = []; // Storage untuk data penduduk

    // Page Navigation
    function showPage(page) {
        $('.page-section').removeClass('active');
        $('#page-' + page).addClass('active');
        $('.sidebar .nav-link').removeClass('active-menu');
        $('#menu-' + page).addClass('active-menu');

        if (page === 'users') {
            if ($('#userTableBody').children().length === 0 || $('#userTableBody').text().includes('Memuat')) {
                loadUsers();
            }
        }
        
        if (page === 'datamaster') {
            loadPenduduk();
        }
    }

    $(document).ready(function() {
        // Sidebar toggle
        $('#sidebarToggle, #sidebarToggleTop').on('click', function() {
            $('body').toggleClass('sidebar-toggled');
            $('#accordionSidebar').toggleClass('toggled');
        });

        // Dashboard aktif pertama
        $('#menu-dashboard').addClass('active-menu');

        // Load profile photo dari localStorage
        loadProfilePhoto();
        
        // Validasi input penduduk
        $('#pendudukNik').on('input', function() { 
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16); 
        });
        $('#pendudukRt, #pendudukRw').on('input', function() { 
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3); 
        });
        $('#pendudukTelepon').on('input', function() { 
            this.value = this.value.replace(/[^0-9+]/g, '').slice(0, 15); 
        });

        // Geolocation
        $('#getLocationBtn').on('click', function() {
            const status = $('#locationStatus');
            const btn = $(this);
            
            if (navigator.geolocation) {
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
                status.text('Mendapatkan lokasi...').removeClass('text-danger text-success').addClass('text-warning');
                
                navigator.geolocation.getCurrentPosition(
                    pos => {
                        $('#pendudukLatitude').val(pos.coords.latitude.toFixed(6));
                        $('#pendudukLongitude').val(pos.coords.longitude.toFixed(6));
                        status.text('✓ Lokasi berhasil didapatkan!').addClass('text-success').removeClass('text-warning');
                        btn.prop('disabled', false).html('<i class="fas fa-crosshairs"></i> GPS');
                    },
                    err => {
                        status.text('✗ Gagal mendapatkan lokasi. Pastikan GPS aktif.').addClass('text-danger').removeClass('text-warning');
                        btn.prop('disabled', false).html('<i class="fas fa-crosshairs"></i> GPS');
                    }
                );
            } else {
                status.text('Browser tidak mendukung geolokasi').addClass('text-danger');
            }
        });

        // Profile photo change dengan persistent storage
        $('#profile_photo').on('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            // Validasi file
            if (!file.type.match('image.*')) {
                Swal.fire('Error!', 'File harus berupa gambar', 'error');
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) { // 2MB
                Swal.fire('Error!', 'Ukuran file maksimal 2MB', 'error');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(ev) {
                const photoUrl = ev.target.result;
                updateProfilePhoto(photoUrl);
                
                // Simpan ke localStorage dengan key unik user
                const userId = '{{ auth()->user()->id ?? "guest" }}';
                localStorage.setItem('profile_photo_' + userId, photoUrl);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Foto profil berhasil diubah',
                    timer: 2000,
                    showConfirmButton: false
                });
            };
            reader.readAsDataURL(file);
        });

        // Submit forms
        $('#pendudukForm').on('submit', submitPenduduk);
        $('#profileForm').on('submit', submitProfile);
        $('#passwordForm').on('submit', submitPassword);
        $('#userForm').on('submit', submitUser);
    });

    // ========== PROFILE PHOTO FUNCTIONS ==========
    function loadProfilePhoto() {
        const userId = '{{ auth()->user()->id ?? "guest" }}';
        const savedPhoto = localStorage.getItem('profile_photo_' + userId);
        
        if (savedPhoto) {
            updateProfilePhoto(savedPhoto);
        }
    }

    function updateProfilePhoto(photoUrl) {
        $('#profilePhotoPreview').attr('src', photoUrl);
        $('#topbarProfilePhoto').attr('src', photoUrl);
    }

    // ========== PENDUDUK CRUD FUNCTIONS ==========
    function loadPenduduk() {
        if (pendudukTable) {
            pendudukTable.destroy();
            pendudukTable = null;
        }

        $('#pendudukTableBody').html('<tr><td colspan="7" class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat data...</td></tr>');

        // Simulasi API call - Ganti dengan endpoint backend Anda
        $.ajax({
            url: '{{ url("/penduduk/penduduk") }}',
            method: 'GET',
            success: function(response) {
                pendudukData = response;
                renderPendudukTable();
            },
            error: function() {
                // Fallback: Gunakan mock data jika backend belum siap
                pendudukData = getMockPendudukData();
                renderPendudukTable();
            }
        });
    }

    function renderPendudukTable() {
        let html = '';
        
        if (!pendudukData || pendudukData.length === 0) {
            html = '<tr><td colspan="7" class="text-center text-muted py-4"><i class="fas fa-inbox"></i> Belum ada data penduduk</td></tr>';
        } else {
            pendudukData.forEach((item, i) => {
                html += `<tr>
                    <td class="text-center">${i+1}</td>
                    <td><strong>${item.nik || '-'}</strong></td>
                    <td>${item.nama || '-'}</td>
                    <td>${(item.alamat || '').substring(0,50)}${(item.alamat || '').length > 50 ? '...' : ''}</td>
                    <td class="text-center">${item.rt || '-'}/${item.rw || '-'}</td>
                    <td>${item.provinsi || '-'}</td>
                    <td class="text-center table-actions">
                        <button class="btn btn-sm btn-info" onclick="detailPenduduk(${item.id})" title="Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="editPenduduk(${item.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deletePenduduk(${item.id})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
        }
        
        $('#pendudukTableBody').html(html);
        
        // Initialize DataTable
        pendudukTable = $('#pendudukTable').DataTable({
            language: { 
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                emptyTable: "Belum ada data penduduk"
            },
            pageLength: 10,
            order: [[1, 'asc']]
        });
    }

    function openPendudukModal(action, id = null) {
        $('#pendudukForm')[0].reset();
        $('#locationStatus').text('').removeClass('text-success text-danger text-warning');
        
        if (action === 'add') {
            $('#pendudukModalTitle').text('Tambah Penduduk Baru');
            $('#pendudukId').val('');
            $('#submitPendudukBtn').html('<i class="fas fa-save"></i> Simpan Data');
        } else if (action === 'edit' && id) {
            $('#pendudukModalTitle').text('Edit Data Penduduk');
            $('#submitPendudukBtn').html('<i class="fas fa-save"></i> Update Data');
            
            // Load data untuk edit
            const penduduk = pendudukData.find(p => p.id == id);
            if (penduduk) {
                $('#pendudukId').val(penduduk.id);
                $('#pendudukNik').val(penduduk.nik);
                $('#pendudukNama').val(penduduk.nama);
                $('#pendudukAlamat').val(penduduk.alamat);
                $('#pendudukRt').val(penduduk.rt);
                $('#pendudukRw').val(penduduk.rw);
                $('#pendudukKelurahan').val(penduduk.kelurahan);
                $('#pendudukKecamatan').val(penduduk.kecamatan);
                $('#pendudukKota').val(penduduk.kota);
                $('#pendudukProvinsi').val(penduduk.provinsi);
                $('#pendudukLatitude').val(penduduk.latitude);
                $('#pendudukLongitude').val(penduduk.longitude);
                $('#pendudukTanggalLahir').val(penduduk.tanggal_lahir);
                $('#pendudukJenisKelamin').val(penduduk.jenis_kelamin);
                $('#pendudukAgama').val(penduduk.agama);
                $('#pendudukPekerjaan').val(penduduk.pekerjaan);
                $('#pendudukStatusKawin').val(penduduk.status_kawin);
                $('#pendudukTelepon').val(penduduk.telepon);
                $('#pendudukEmail').val(penduduk.email);
            }
        }
        
        $('#pendudukModal').modal('show');
    }

    function editPenduduk(id) {
        openPendudukModal('edit', id);
    }

    function detailPenduduk(id) {
        $('#detailPendudukModal').modal('show');
        
        const penduduk = pendudukData.find(p => p.id == id);
        if (!penduduk) {
            $('#detailPendudukContent').html('<div class="alert alert-danger">Data tidak ditemukan</div>');
            return;
        }
        
        const html = `
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr><th width="40%">NIK</th><td><strong>${penduduk.nik || '-'}</strong></td></tr>
                        <tr><th>Nama Lengkap</th><td>${penduduk.nama || '-'}</td></tr>
                        <tr><th>Tanggal Lahir</th><td>${penduduk.tanggal_lahir || '-'}</td></tr>
                        <tr><th>Jenis Kelamin</th><td>${penduduk.jenis_kelamin || '-'}</td></tr>
                        <tr><th>Agama</th><td>${penduduk.agama || '-'}</td></tr>
                        <tr><th>Status Kawin</th><td>${penduduk.status_kawin || '-'}</td></tr>
                        <tr><th>Pekerjaan</th><td>${penduduk.pekerjaan || '-'}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr><th width="40%">Alamat</th><td>${penduduk.alamat || '-'}</td></tr>
                        <tr><th>RT/RW</th><td>${penduduk.rt || '-'}/${penduduk.rw || '-'}</td></tr>
                        <tr><th>Kelurahan</th><td>${penduduk.kelurahan || '-'}</td></tr>
                        <tr><th>Kecamatan</th><td>${penduduk.kecamatan || '-'}</td></tr>
                        <tr><th>Kota</th><td>${penduduk.kota || '-'}</td></tr>
                        <tr><th>Provinsi</th><td>${penduduk.provinsi || '-'}</td></tr>
                        <tr><th>Koordinat</th><td>${penduduk.latitude || '-'}, ${penduduk.longitude || '-'}</td></tr>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <h6><i class="fas fa-phone"></i> Kontak</h6>
                    <table class="table table-bordered">
                        <tr><th width="20%">Telepon</th><td>${penduduk.telepon || '-'}</td></tr>
                        <tr><th>Email</th><td>${penduduk.email || '-'}</td></tr>
                    </table>
                </div>
            </div>
        `;
        
        $('#detailPendudukContent').html(html);
    }

    function submitPenduduk(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = $('#pendudukId').val();
        const isEdit = id ? true : false;
        
        $('#submitPendudukBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        
        $.ajax({
            url: isEdit ? `{{ url("/penduduk/penduduk") }}/${id}` : '{{ url("/penduduk/penduduk") }}',
            method: isEdit ? 'PUT' : 'POST',
            data: Object.fromEntries(formData),
            success: function(response) {
                $('#pendudukModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message || 'Data berhasil disimpan',
                    timer: 2000
                });
                loadPenduduk();
            },
            error: function(xhr) {
                // Fallback: Simpan ke mock data jika backend belum siap
                if (isEdit) {
                    const index = pendudukData.findIndex(p => p.id == id);
                    if (index !== -1) {
                        pendudukData[index] = { ...pendudukData[index], ...Object.fromEntries(formData), id: parseInt(id) };
                    }
                } else {
                    const newId = pendudukData.length > 0 ? Math.max(...pendudukData.map(p => p.id)) + 1 : 1;
                    pendudukData.push({ ...Object.fromEntries(formData), id: newId });
                }
                
                $('#pendudukModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan (mode demo)',
                    timer: 2000
                });
                renderPendudukTable();
            },
            complete: function() {
                $('#submitPendudukBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan Data');
            }
        });
    }

    function deletePenduduk(id) {
        Swal.fire({
            title: 'Yakin hapus data?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url("/penduduk/penduduk") }}/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: response.message || 'Data berhasil dihapus',
                            timer: 1500
                        });
                        loadPenduduk();
                    },
                    error: function() {
                        // Fallback: Hapus dari mock data
                        pendudukData = pendudukData.filter(p => p.id != id);
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Data berhasil dihapus (mode demo)',
                            timer: 1500
                        });
                        renderPendudukTable();
                    }
                });
            }
        });
    }

    function getMockPendudukData() {
        return [
            {
                id: 1,
                nik: '3201234567890001',
                nama: 'Ahmad Fauzi',
                alamat: 'Jl. Merdeka No. 123',
                rt: '001',
                rw: '005',
                kelurahan: 'Babakan',
                kecamatan: 'Bogor Tengah',
                kota: 'Bogor',
                provinsi: 'Jawa Barat',
                latitude: '-6.597147',
                longitude: '106.806038',
                tanggal_lahir: '1990-05-15',
                jenis_kelamin: 'Laki-laki',
                agama: 'Islam',
                pekerjaan: 'PNS',
                status_kawin: 'Kawin',
                telepon: '081234567890',
                email: 'ahmad@email.com'
            },
            {
                id: 2,
                nik: '3201234567890002',
                nama: 'Siti Nurhaliza',
                alamat: 'Jl. Sudirman No. 45',
                rt: '003',
                rw: '002',
                kelurahan: 'Paledang',
                kecamatan: 'Bogor Tengah',
                kota: 'Bogor',
                provinsi: 'Jawa Barat',
                latitude: '-6.589744',
                longitude: '106.790992',
                tanggal_lahir: '1992-08-20',
                jenis_kelamin: 'Perempuan',
                agama: 'Islam',
                pekerjaan: 'Guru',
                status_kawin: 'Kawin',
                telepon: '081298765432',
                email: 'siti@email.com'
            },
            {
                id: 3,
                nik: '3201234567890003',
                nama: 'Budi Santoso',
                alamat: 'Jl. Pajajaran No. 78',
                rt: '002',
                rw: '004',
                kelurahan: 'Tegallega',
                kecamatan: 'Bogor Tengah',
                kota: 'Bogor',
                provinsi: 'Jawa Barat',
                latitude: '-6.595038',
                longitude: '106.792694',
                tanggal_lahir: '1988-12-10',
                jenis_kelamin: 'Laki-laki',
                agama: 'Islam',
                pekerjaan: 'Wiraswasta',
                status_kawin: 'Kawin',
                telepon: '081234567891',
                email: 'budi@email.com'
            }
        ];
    }

    // ========== USER MANAGEMENT FUNCTIONS ==========
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
        }).fail(function() {
            $('#userTableBody').html('<tr><td colspan="8" class="text-center text-danger">Gagal memuat data</td></tr>');
        });
    }

    function submitInviteForm(e) {
        e.preventDefault();
        const data = {
            name: $('#inviteName').val().trim(),
            email: $('#inviteEmail').val().trim(),
            role: $('#inviteRole').val()
        };
        
        if (!data.name || !data.email || !data.role) {
            return Swal.fire('Error!', 'Semua field wajib diisi!', 'error');
        }

        $('#sendInviteBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: '{{ url("/users/invite") }}',
            method: 'POST',
            data: data,
            success: function(response) {
                $('#inviteForm')[0].reset();
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Berhasil!', 
                    text: response.message, 
                    timer: 2000 
                });
                loadUsers();
            },
            error: function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal membuat undangan', 'error');
            },
            complete: function() {
                $('#sendInviteBtn').prop('disabled', false).html('<i class="fas fa-paper-plane"></i>');
            }
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
            $('#submitUserBtn').html('<i class="fas fa-save"></i> Simpan');
        } else {
            $('#userModalTitle').text('Edit Pengguna');
            $('#userPassword').prop('required', false);
            $('#passwordRequired').removeClass('form-label-required');
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
        });
    }

    function submitUser(e) {
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
                Swal.fire({
                    icon: 'success', 
                    title: 'Berhasil!', 
                    text: response.message, 
                    timer: 2000
                });
                loadUsers();
            },
            error: function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal simpan', 'error');
            },
            complete: function() {
                $('#submitUserBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
            }
        });
    }

    function deleteUser(id) {
        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data pengguna akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url("/users") }}/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: response.message,
                            timer: 1500
                        });
                        loadUsers();
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal hapus', 'error');
                    }
                });
            }
        });
    }

    // ========== SETTINGS FUNCTIONS ==========
    function submitProfile(e) {
        e.preventDefault();
        const btn = $('#saveProfileBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: '{{ url("/profile") }}',
            method: 'PATCH',
            data: $(this).serialize(),
            success: function() {
                Swal.fire({
                    icon: 'success', 
                    title: 'Berhasil!', 
                    text: 'Profil diperbarui', 
                    timer: 2000
                });
            },
            error: function(xhr) { 
                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal update', 'error'); 
            },
            complete: () => btn.prop('disabled', false).html('<i class="fas fa-save"></i> Simpan Perubahan')
        });
    }

    function submitPassword(e) {
        e.preventDefault();
        
        if ($('#password').val() !== $('#password_confirmation').val()) {
            return Swal.fire('Error!', 'Konfirmasi password tidak cocok!', 'error');
        }

        const btn = $('#changePasswordBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengubah...');

        $.ajax({
            url: '{{ url("/pengaturan/password") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                Swal.fire({
                    icon: 'success', 
                    title: 'Berhasil!', 
                    text: 'Password diubah', 
                    timer: 2000
                });
                $('#passwordForm')[0].reset();
            },
            error: function(xhr) { 
                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal ubah password', 'error'); 
            },
            complete: () => btn.prop('disabled', false).html('<i class="fas fa-key"></i> Ubah Password')
        });
    }

    // Chart
    var ctx = document.getElementById('myAreaChart');
    if (ctx) {
        ctx = ctx.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
                datasets: [{
                    label: 'Bidang Tersertipikat (Juta)',
                    data: [45, 58, 68, 75, 80, 82.3],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: { 
                    y: { 
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return value + ' Jt';
                            }
                        }
                    } 
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Juta Bidang';
                            }
                        }
                    }
                }
            }
        });
    }
    </script>
</body>
</html>