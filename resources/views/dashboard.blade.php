<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Sistem Informasi Pertanahan</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --secondary: #0ea5e9;
            --purple: #a855f7;
            --amber: #f59e0b;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        body {
            background: linear-gradient(135deg, var(--slate-50) 0%, var(--slate-100) 100%);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, var(--slate-800) 0%, var(--slate-900) 100%);
            padding: 24px 16px;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .logo-text h1 {
            color: white;
            font-size: 18px;
            font-weight: 700;
        }

        .logo-text p {
            color: var(--slate-300);
            font-size: 12px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            margin-bottom: 8px;
            border-radius: 8px;
            color: var(--slate-300);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .menu-item:hover {
            background: var(--slate-700);
            color: white;
        }

        .menu-item.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .menu-item i {
            font-size: 18px;
            width: 20px;
        }

        .bottom-menu {
            position: absolute;
            bottom: 24px;
            left: 16px;
            right: 16px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.full-width {
            margin-left: 0;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 16px 24px;
            border-bottom: 1px solid var(--slate-200);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .menu-toggle {
            display: none;
            background: var(--slate-100);
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            color: var(--slate-700);
            font-size: 18px;
        }

        .header-title h2 {
            font-size: 20px;
            color: var(--slate-800);
            margin-bottom: 4px;
        }

        .header-title p {
            font-size: 14px;
            color: var(--slate-600);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--slate-100);
            padding: 8px 16px;
            border-radius: 8px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 200px;
            color: var(--slate-700);
        }

        .notification-btn {
            position: relative;
            background: var(--slate-100);
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            color: var(--slate-700);
        }

        .notification-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--slate-100);
            padding: 8px 12px;
            border-radius: 8px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary) 0%, #0d9488 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .user-info p {
            font-size: 14px;
            font-weight: 600;
            color: var(--slate-800);
        }

        .user-info span {
            font-size: 12px;
            color: var(--slate-600);
        }

        /* Container */
        .container {
            padding: 24px;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary) 0%, #0d9488 100%);
            padding: 32px;
            border-radius: 16px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.2);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 24px;
        }

        .welcome-text h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .welcome-text p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 16px;
        }

        .welcome-meta {
            display: flex;
            gap: 24px;
            font-size: 14px;
        }

        .welcome-meta div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .map-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--primary);
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .map-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--slate-200);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card:nth-child(1) { animation-delay: 0s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.2s; }
        .stat-card:nth-child(4) { animation-delay: 0.3s; }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.emerald {
            background: #d1fae5;
            color: var(--primary);
        }

        .stat-icon.blue {
            background: #dbeafe;
            color: var(--secondary);
        }

        .stat-icon.purple {
            background: #f3e8ff;
            color: var(--purple);
        }

        .stat-icon.amber {
            background: #fef3c7;
            color: var(--amber);
        }

        .stat-change {
            background: #d1fae5;
            color: #059669;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--slate-600);
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--slate-200);
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .action-btn {
            padding: 24px;
            border-radius: 12px;
            border: none;
            color: white;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .action-btn.emerald {
            background: linear-gradient(135deg, var(--primary) 0%, #0d9488 100%);
        }

        .action-btn.blue {
            background: linear-gradient(135deg, var(--secondary) 0%, #0284c7 100%);
        }

        .action-btn.purple {
            background: linear-gradient(135deg, var(--purple) 0%, #9333ea 100%);
        }

        .action-btn.amber {
            background: linear-gradient(135deg, var(--amber) 0%, #d97706 100%);
        }

        .action-btn i {
            font-size: 32px;
            margin-bottom: 12px;
            display: block;
        }

        .action-btn p {
            font-weight: 600;
            font-size: 14px;
        }

        /* Two Column Layout */
        .two-column {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--slate-200);
        }

        .activity-item {
            display: flex;
            gap: 16px;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: background 0.3s ease;
        }

        .activity-item:hover {
            background: var(--slate-50);
        }

        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-top: 8px;
            flex-shrink: 0;
        }

        .activity-dot.green { background: #22c55e; }
        .activity-dot.blue { background: var(--secondary); }
        .activity-dot.purple { background: var(--purple); }
        .activity-dot.amber { background: var(--amber); }

        .activity-content {
            flex: 1;
        }

        .activity-type {
            font-weight: 600;
            font-size: 14px;
            color: var(--slate-800);
            margin-bottom: 2px;
        }

        .activity-desc {
            font-size: 13px;
            color: var(--slate-600);
            margin-bottom: 4px;
        }

        .activity-time {
            font-size: 12px;
            color: var(--slate-400);
        }

        .notification-item {
            display: flex;
            gap: 12px;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .notification-item.amber-bg {
            background: #fef3c7;
            border: 1px solid #fbbf24;
        }

        .notification-item.blue-bg {
            background: #dbeafe;
            border: 1px solid #60a5fa;
        }

        .notification-item.green-bg {
            background: #d1fae5;
            border: 1px solid #34d399;
        }

        .notification-icon {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .notification-item.amber-bg .notification-icon { color: #d97706; }
        .notification-item.blue-bg .notification-icon { color: #2563eb; }
        .notification-item.green-bg .notification-icon { color: #059669; }

        .notification-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .notification-item.amber-bg .notification-title { color: #78350f; }
        .notification-item.blue-bg .notification-title { color: #1e3a8a; }
        .notification-item.green-bg .notification-title { color: #064e3b; }

        .notification-text {
            font-size: 13px;
        }

        .notification-item.amber-bg .notification-text { color: #92400e; }
        .notification-item.blue-bg .notification-text { color: #1e40af; }
        .notification-item.green-bg .notification-text { color: #065f46; }

        .view-all-btn {
            width: 100%;
            text-align: center;
            padding: 12px;
            color: var(--primary);
            font-weight: 600;
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .view-all-btn:hover {
            color: var(--primary-dark);
        }

        /* Footer */
        .footer {
            background: white;
            padding: 16px 24px;
            border-top: 1px solid var(--slate-200);
            text-align: center;
            color: var(--slate-600);
            font-size: 14px;
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .user-info {
                display: none;
            }

            .search-box {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .welcome-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .two-column {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="logo-section">
            <div class="logo-icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <div class="logo-text">
                <h1>SIP</h1>
                <p>Pertanahan</p>
            </div>
        </div>

        <nav>
            <a href="/dashboard" class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="/petnah" class="menu-item">
                <i class="fas fa-map"></i>
                <span>Peta Pertanahan</span>
            </a>
            <a href="/datnah" class="menu-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Data Tanah</span>
            </a>
            <a href="/paper" class="menu-item">
                <i class="fas fa-file-alt"></i>
                <span>GeoPaper</span>
            </a>
            <a href="/ten" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Tentang</span>
            </a>
            <a href="/lap" class="menu-item">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="bottom-menu">
            <a href="/set" class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            <a href="/logout" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="header-title">
                        <h2>Dashboard</h2>
                        <p>Sistem Informasi Pertanahan</p>
                    </div>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari data...">
                    </div>
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge"></span>
                    </button>
                    <div class="user-profile">
                        <div class="user-avatar">A</div>
                        <div class="user-info">
                            <p>Admin</p>
                            <span>Administrator</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="container">
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1>Selamat Datang! 👋</h1>
                        <p>Sistem Informasi Pertanahan - Kelola data pertanahan dengan mudah dan efisien</p>
                        <div class="welcome-meta">
                            <div>
                                <i class="fas fa-calendar"></i>
                                <span id="currentDate"></span>
                            </div>
                            <div>
                                <i class="fas fa-clock"></i>
                                <span id="currentTime"></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="/peta" class="map-btn">
                            <i class="fas fa-map"></i>
                            <span>Buka Peta</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon emerald">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span class="stat-change">+12%</span>
                    </div>
                    <div class="stat-value">2,847</div>
                    <div class="stat-label">Total Bidang Tanah</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon blue">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span class="stat-change">+8%</span>
                    </div>
                    <div class="stat-value">2,634</div>
                    <div class="stat-label">Sertifikat Terdaftar</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon purple">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="stat-change">+5%</span>
                    </div>
                    <div class="stat-value">1,892</div>
                    <div class="stat-label">Pemilik Terdaftar</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon amber">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="stat-change">+3%</span>
                    </div>
                    <div class="stat-value">15,432</div>
                    <div class="stat-label">Luas Total (Ha)</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3 class="section-title">
                    <i class="fas fa-bolt"></i>
                    Aksi Cepat
                </h3>
                <div class="actions-grid">
                    <a href="/peta" class="action-btn emerald">
                        <i class="fas fa-map"></i>
                        <p>Buka Peta</p>
                    </a>
                    <a href="/petnah" class="action-btn blue">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Data Tanah</p>
                    </a>
                    <a href="/paper" class="action-btn purple">
                        <i class="fas fa-file-alt"></i>
                        <p>GeoPaper</p>
                    </a>
                    <a href="/lap" class="action-btn amber">
                        <i class="fas fa-chart-bar"></i>
                        <p>Laporan</p>
                    </a>
                </div>
            </div>

            <!-- Activities & Notifications -->
            <div class="two-column">
                <!-- Recent Activities -->
                <div class="card">
                    <h3 class="section-title">
                        <i class="fas fa-clock"></i>
                        Aktivitas Terbaru
                    </h3>
                    <div>
                        <div class="activity-item">
                            <div class="activity-dot green"></div>
                            <div class="activity-content">
                                <div class="activity-type">Pendaftaran</div>
                                <div class="activity-desc">Sertifikat baru #SRT-2024-001</div>
                                <div class="activity-time">10 menit lalu</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot blue"></div>
                            <div class="activity-content">
                                <div class="activity-type">Perubahan</div>
                                <div class="activity-desc">Update data bidang tanah A-123</div>
                                <div class="activity-time">25 menit lalu</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot purple"></div>
                            <div class="activity-content">
                                <div class="activity-type">Verifikasi</div>
                                <div class="activity-desc">Validasi dokumen kepemilikan</div>
                                <div class="activity-time">1 jam lalu</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot green"></div>
                            <div class="activity-content">
                                <div class="activity-type">Pendaftaran</div>
                                <div class="activity-desc">Sertifikat baru #SRT-2024-002</div>
                                <div class="activity-time">2 jam lalu</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot amber"></div>
                            <div class="activity-content">
                                <div class="activity-type">Laporan</div>
                                <div class="activity-desc">Generate laporan bulanan</div>
                                <div class="activity-time">3 jam lalu</div>
                            </div>
                        </div>
                    </div>
                    <button class="view-all-btn">Lihat Semua Aktivitas →</button>
                </div>

                <!-- Notifications -->
                <div class="card">
                    <h3 class="section-title">
                        <i class="fas fa-bell"></i>
                        Notifikasi
                    </h3>
                    <div>
                        <div class="notification-item amber-bg">
                            <div class="notification-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title">Reminder</div>
                                <div class="notification-text">5 sertifikat akan berakhir masa berlakunya dalam 30 hari</div>
                            </div>
                        </div>

                        <div class="notification-item blue-bg">
                            <div class="notification-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title">Dokumen Baru</div>
                                <div class="notification-text">3 dokumen menunggu verifikasi Anda</div>
                            </div>
                        </div>

                        <div class="notification-item green-bg">
                            <div class="notification-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title">Update Sistem</div>
                                <div class="notification-text">Sistem berhasil diperbarui ke versi 2.1.0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <footer class="footer">
            <div>© 2024 Sistem Informasi Pertanahan. All rights reserved.</div>
        </footer>
    </main>

    <!-- JavaScript -->
    <script>
        // Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.getElementById('mainContent');

        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Update Time
        function updateTime() {
            const now = new Date();
            
            // Format Date
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateStr = now.toLocaleDateString('id-ID', options);
            document.getElementById('currentDate').textContent = dateStr;
            
            // Format Time
            const timeStr = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTime').textContent = timeStr;
        }

        // Update time immediately and then every second
        updateTime();
        setInterval(updateTime, 1000);

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add hover effect to menu items
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateX(5px)';
                }
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    </script>
</body>
</html>