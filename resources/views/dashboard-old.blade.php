<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Sistem Pertanahan Digital</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --card-border: rgba(255, 255, 255, 0.1);
            --text: #f1f5f9;
            --text-light: #cbd5e1;
            --accent: #10b981;
            --sidebar-width: 280px;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0; top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(16, 185, 129, 0.2);
            padding: 2rem 1.5rem;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.9rem;
            color: var(--accent);
            margin-bottom: 3rem;
            text-align: center;
        }

        .nav-link {
            color: var(--text-light);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: .5rem;
            transition: all .3s;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(16, 185, 129, 0.2);
            color: white;
            border-left: 4px solid var(--accent);
            padding-left: calc(1.5rem - 4px);
        }

        .nav-link i {
            font-size: 1.3rem;
            width: 30px;
            text-align: center;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 2rem;
        }

        /* Preloader */
        #preloader {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            transition: opacity .8s;
        }

        .loader {
            width: 80px;
            height: 80px;
            border: 6px solid rgba(16, 185, 129, .3);
            border-top: 6px solid #10b981;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Toast */
        #notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
        }

        .toast {
            background: rgba(30, 41, 59, .95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, .4);
            border-left: 6px solid #10b981;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .4);
            animation: slideIn .6s forwards;
            transform: translateX(400px);
        }

        @keyframes slideIn { to { transform: translateX(0); } }

        /* Cards */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .3);
            opacity: 0;
            transform: translateY(30px);
            transition: all .8s;
        }

        .glass-card.show { opacity: 1; transform: translateY(0); }

        .welcome-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, .18), rgba(5, 150, 105, .08));
            border-left: 6px solid var(--accent);
        }

        .stat-card {
            background: linear-gradient(135deg, #1e293b, #334155);
            border-radius: 18px;
            padding: 28px 20px;
            text-align: center;
            transition: all .4s;
        }

        .stat-card:hover {
            background: linear-gradient(135deg, #334155, #475569);
            transform: translateY(-12px) scale(1.05);
            box-shadow: 0 20px 40px rgba(16, 185, 129, .3);
        }

        .clock {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .preview-area {
            display: none;
        }

        .preview-area.active {
            display: block;
        }

        .dashboard-area {
            display: none;
        }

        .dashboard-area.active {
            display: block;
        }

        #mini-map {
            height: 420px;
            border-radius: 16px;
            border: 2px solid rgba(16, 185, 129, 0.4);
        }

        .map-counter {
            background: rgba(15, 23, 42, 0.9);
            padding: 10px 20px;
            border-radius: 12px;
            margin-top: 10px;
            font-size: 0.9rem;
            text-align: center;
        }

        .preview-frame {
            width: 100%;
            height: calc(100vh - 220px);
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .6);
            background: #1e293b;
        }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
        <h3 class="text-emerald-400 fw-bold">Memuat Dashboard...</h3>
    </div>

    <div id="notification-toast"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">Pertanahan</div>
        <nav class="nav flex-column">
            <button onclick="showDashboard()" class="nav-link active" id="nav-dashboard">
                <i class="fas fa-th-large"></i> Dashboard
            </button>
            <a href="{{ url('/petnah') }}" class="nav-link">
                <i class="fas fa-map"></i> Peta Pertanahan
            </a>
            <button onclick="loadPreview('/datnah')" class="nav-link" id="nav-datnah">
                <i class="fas fa-database"></i> Data Tanah
            </button>
            <button onclick="loadPreview('/lap')" class="nav-link" id="nav-lap">
                <i class="fas fa-file-alt"></i> Laporan
            </button>
            @if(auth()->check() && auth()->user()->hasRole('admin'))
                <button onclick="loadPreview('/users')" class="nav-link" id="nav-users">
                    <i class="fas fa-users"></i> User Management
                </button>
            @endif
            <button onclick="loadPreview('/pengaturan')" class="nav-link" id="nav-pengaturan">
                <i class="fas fa-cog"></i> Pengaturan
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            <button onclick="document.getElementById('logout-form').submit();" class="nav-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Area -->
        <div class="dashboard-area active" id="dashboard-area">
            @php $role = auth()->user()->getRoleNames()->first() ?? 'public'; @endphp

            <div class="container-fluid px-4 py-5">

                <!-- Welcome Card -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="glass-card welcome-card p-5">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <h1 class="display-4 fw-bold mb-3 text-white">Selamat Datang Kembali!</h1>
                                    <h2 class="text-3xl fw-bold mb-4 text-emerald-300">{{ auth()->user()->name }}</h2>
                                    <p class="fs-5 mb-2 text-gray-300">Anda login sebagai:</p>
                                    <span class="badge bg-emerald-500/30 text-emerald-300 border border-emerald-500/50 px-6 py-3 fs-5 fw-bold">
                                        {{ $role === 'admin' ? 'Administrator Sistem' : ($role === 'staff' ? 'Petugas Lapangan' : 'Pengguna Publik') }}
                                    </span>
                                    <span class="badge bg-emerald-600 text-white px-5 py-2 ms-3">{{ strtoupper($role) }}</span>
                                </div>
                                <div class="col-lg-4 text-lg-end">
                                    <div class="clock">
                                        <div class="text-6xl text-emerald-400 mb-2" id="live-clock">00:00:00</div>
                                        <div class="text-xl text-gray-400" id="live-date"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mini Map + Counter -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="glass-card p-4">
                            <h5 class="mb-4 fw-bold text-white">Peta Pertanahan Digital (Live Preview)</h5>
                            <div id="mini-map"></div>
                            <div class="map-counter text-emerald-300">
                                Total Penduduk: <span id="count-penduduk">0</span> | 
                                Bidang Tanah: <span id="count-polygon">0</span> | 
                                Marker: <span id="count-marker">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="row g-4 mb-5">
                    <div class="col-lg-3 col-md-6"><div class="glass-card stat-card"><i class="fas fa-vector-square text-emerald-400 mb-3" style="font-size:3.5rem;"></i><h3 class="display-6 fw-bold mb-1">1,9 jt km²</h3><p class="fs-5 text-gray-300 mb-1">Bidang Tanah</p><small class="text-emerald-400">+12% bulan ini</small></div></div>
                    <div class="col-lg-3 col-md-6"><div class="glass-card stat-card"><i class="fas fa-users text-cyan-400 mb-3" style="font-size:3.5rem;"></i><h3 class="display-6 fw-bold mb-1">72,3%</h3><p class="fs-5 text-gray-300 mb-1">Penduduk</p><small class="text-cyan-400">100% terdata</small></div></div>
                    <div class="col-lg-3 col-md-6"><div class="glass-card stat-card"><i class="fas fa-certificate text-amber-400 mb-3" style="font-size:3.5rem;"></i><h3 class="display-6 fw-bold mb-1">11.204</h3><p class="fs-5 text-gray-300 mb-1">Sertifikat Terbit</p><small class="text-amber-400">87% total</small></div></div>
                    <div class="col-lg-3 col-md-6"><div class="glass-card stat-card"><i class="fas fa-exclamation-triangle text-red-400 mb-3" style="font-size:3.5rem;"></i><h3 class="display-6 fw-bold mb-1">35</h3><p class="fs-5 text-gray-300 mb-1">Sengketa Aktif</p><small class="text-red-400">-5 dari kemarin</small></div></div>
                </div>

                <!-- Grafik -->
                <div class="row g-5 mb-5">
                    <div class="col-lg-8">
                        <div class="glass-card p-5">
                            <h5 class="mb-4 fw-bold text-white">Pertumbuhan Bidang Tanah 2025</h5>
                            <canvas id="lineChart" height="140"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="glass-card p-5 h-100 d-flex flex-column justify-content-center">
                            <h5 class="mb-4 fw-bold text-white">Jenis Kepemilikan</h5>
                            <canvas id="doughnutChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row g-5">
                    <div class="col-12">
                        <div class="glass-card p-5">
                            <h5 class="mb-4 fw-bold text-white">Status Pengurusan Sertifikat</h5>
                            <canvas id="barChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Area -->
        <div class="preview-area" id="preview-area">
            <div class="glass-card p-4">
                <iframe id="preview-frame" class="preview-frame" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function setActiveNav(navId) {
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            if (document.getElementById(navId)) {
                document.getElementById(navId).classList.add('active');
            }
        }

        function showDashboard() {
            document.getElementById('dashboard-area').classList.add('active');
            document.getElementById('preview-area').classList.remove('active');
            setActiveNav('nav-dashboard');
            history.replaceState({}, '', '/');
        }

        function loadPreview(url) {
            document.getElementById('preview-area').classList.add('active');
            document.getElementById('dashboard-area').classList.remove('active');
            document.getElementById('preview-frame').src = url;

            // Determine which nav item to highlight
            if (url === '/datnah') setActiveNav('nav-datnah');
            else if (url === '/lap') setActiveNav('nav-lap');
            else if (url === '/users') setActiveNav('nav-users');
            else if (url === '/pengaturan') setActiveNav('nav-pengaturan');

            history.replaceState({}, '', '/');
        }

        // Preloader & Notifikasi
        window.addEventListener('load', () => {
            document.getElementById('preloader').style.opacity = '0';
            setTimeout(() => {
                document.getElementById('preloader').style.display = 'none';
                document.querySelectorAll('.glass-card').forEach((el, i) => {
                    setTimeout(() => el.classList.add('show'), i * 150);
                });
            }, 800);
            showNotification(`Selamat datang kembali, {{ auth()->user()->name }}!`);
        });

        function showNotification(m) {
            const t = document.createElement('div');
            t.className = 'toast';
            t.innerHTML = `<div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 text-emerald-400" style="font-size:1.5rem;"></i>
                <div><strong>Sistem</strong><br><small>${m}</small></div>
            </div>`;
            document.getElementById('notification-toast').appendChild(t);
            setTimeout(() => t.remove(), 5000);
        }

        // Jam Hidup
        function updateClock() {
            const n = new Date();
            document.getElementById('live-clock').textContent = n.toLocaleTimeString('id-ID', { hour12: false });
            document.getElementById('live-date').textContent = n.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }
        updateClock();
        setInterval(updateClock, 1000);
        AOS.init({ duration: 1000, once: true });

        // Mini Map + Counter
        document.addEventListener('DOMContentLoaded', () => {
            const map = L.map('mini-map').setView([-2.5, 118], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            const homeIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/32/25/25694.png',
                iconSize: [38, 38],
                iconAnchor: [19, 38],
                popupAnchor: [0, -38]
            });

            let counts = { penduduk: 0, polygon: 0, marker: 0 };

            async function loadData(url, type) {
                try {
                    const res = await fetch(url);
                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    const data = await res.json();
                    const featureCount = data.features?.length || 0;
                    counts[type] += featureCount;

                    L.geoJSON(data, {
                        style: type === 'polygon' ? { color: '#10b981', weight: 3, fillOpacity: 0.25 } :
                               type === 'polyline' ? { color: '#f59e0b', weight: 5 } : {},
                        pointToLayer: (f, latlng) => type === 'penduduk' ? L.marker(latlng, { icon: homeIcon }) : null,
                        onEachFeature: (f, l) => {
                            if (f.properties) {
                                let html = '<div style="font-family:Inter,sans-serif; min-width:180px">';
                                for (let k in f.properties) {
                                    html += `<div><strong>${k.toUpperCase()}:</strong> ${f.properties[k]}</div>`;
                                }
                                html += '</div>';
                                l.bindPopup(html);
                            }
                        }
                    }).addTo(map);

                    document.getElementById(`count-${type}`).textContent = counts[type];
                } catch (e) {
                    console.error('Gagal load', type, url, e);
                }
            }

            loadData("/penduduk/penduduk", 'penduduk');
            loadData("/polygon/polygon", 'polygon');
            loadData("/polyline/polyline", 'polyline');
            loadData("/marker/marker", 'marker');

            setTimeout(() => {
                if (map.getBounds().isValid()) map.fitBounds(map.getBounds().pad(0.3));
            }, 4000);

            // Charts
            const cfg = {
                responsive: true,
                plugins: { legend: { labels: { color: '#e2e8f0' } } },
                scales: {
                    x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                    y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } }
                }
            };

            new Chart('lineChart', { type: 'line', data: { labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'], datasets: [{ label: 'Bidang Baru', data: [800,1500,2800,4200,5100,6200,7500,8900,9800,10600,11800,12847], borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.15)', tension: 0.4, fill: true }] }, options: cfg });
            new Chart('doughnutChart', { type: 'doughnut', data: { labels: ['Hak Milik','HGB','HGU','Girik','Lainnya'], datasets: [{ data: [65,20,8,5,2], backgroundColor: ['#10b981','#3b82f6','#f59e0b','#ef4444','#8b5cf6'] }] }, options: { plugins: { legend: { position: 'bottom', labels: { color: '#e2e8f0' } } } } });
            new Chart('barChart', { type: 'bar', data: { labels: ['Diajukan','Diproses','Verifikasi','Terbit','Ditolak'], datasets: [{ data: [850,1200,950,11204,180], backgroundColor: ['#06b6d4','#3b82f6','#8b5cf6','#10b981','#ef4444'] }] }, options: { ...cfg, plugins: { legend: { display: false } } } });
        });
    </script>
</body>
</html>
