<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Pertanahan - Sistem Informasi Pertanahan</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <style>
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
        
        .tab-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            font-weight: 600;
        }
        
        .tab-inactive {
            background: white;
            color: #6b7280;
        }
        
        .tab-inactive:hover {
            background: #f3f4f6;
            color: #10b981;
        }

        /* Loading Overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .loading-overlay.active {
            display: flex;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #10b981;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #34d399;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #f87171;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen">
    
    <!-- Header -->
    <header class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-white p-3 rounded-lg shadow-md">
                        <i class="fas fa-map-marked-alt text-3xl text-green-600"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Sistem Informasi Pertanahan</h1>
                        <p class="text-green-100">Data Pertanahan & Pemetaan Digital</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/" class="bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-green-50 transition">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="flex border-b">
                <button onclick="switchTab('penduduk')" id="tab-penduduk" class="flex-1 px-6 py-4 text-center transition tab-active">
                    <i class="fas fa-users mr-2"></i>Data Penduduk
                </button>
                <button onclick="switchTab('polygon')" id="tab-polygon" class="flex-1 px-6 py-4 text-center transition tab-inactive">
                    <i class="fas fa-draw-polygon mr-2"></i>Data Polygon
                </button>
                <button onclick="switchTab('polyline')" id="tab-polyline" class="flex-1 px-6 py-4 text-center transition tab-inactive">
                    <i class="fas fa-route mr-2"></i>Data Polyline
                </button>
                <button onclick="switchTab('marker')" id="tab-marker" class="flex-1 px-6 py-4 text-center transition tab-inactive">
                    <i class="fas fa-map-marker-alt mr-2"></i>Data Marker
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="p-6">
                
                <!-- Penduduk Table -->
                <div id="content-penduduk" class="tab-content">
                    <div id="alert-container-penduduk"></div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Daftar Penduduk</h3>
                    
                    <!-- Search and Entries -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                        <div class="flex items-center gap-2">
                            <label class="text-gray-700">Show</label>
                            <select id="entries-penduduk" onchange="changeEntries('penduduk')" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label class="text-gray-700">entries</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-gray-700">Search:</label>
                            <input type="text" id="search-penduduk" onkeyup="searchTable('penduduk')" placeholder="Cari nama atau NIK..." class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 w-64">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-green-600 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">No</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">NIK</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Nama</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Alamat</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Telepon</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Latitude</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Longitude</th>
                                </tr>
                            </thead>
                            <tbody id="table-penduduk" class="bg-white">
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500 border">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-sm text-gray-600" id="info-penduduk">
                        Showing <span id="showing-penduduk">0</span> of <span id="total-penduduk">0</span> entries
                    </div>
                </div>

                <!-- Polygon Table -->
                <div id="content-polygon" class="tab-content hidden">
                    <div id="alert-container-polygon"></div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Daftar Polygon (Data Tanah)</h3>
                    
                    <!-- Search and Entries -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                        <div class="flex items-center gap-2">
                            <label class="text-gray-700">Show</label>
                            <select id="entries-polygon" onchange="changeEntries('polygon')" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label class="text-gray-700">entries</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-gray-700">Search:</label>
                            <input type="text" id="search-polygon" onkeyup="searchTable('polygon')" placeholder="Cari nama..." class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 w-64">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-emerald-600 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">No</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Nama</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Luas (m²)</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Keterangan</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Warna</th>
                                </tr>
                            </thead>
                            <tbody id="table-polygon" class="bg-white">
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 border">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-sm text-gray-600" id="info-polygon">
                        Showing <span id="showing-polygon">0</span> of <span id="total-polygon">0</span> entries
                    </div>
                </div>

                <!-- Polyline Table -->
                <div id="content-polyline" class="tab-content hidden">
                    <div id="alert-container-polyline"></div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Daftar Polyline (Jalur)</h3>
                    
                    <!-- Search and Entries -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                        <div class="flex items-center gap-2">
                            <label class="text-gray-700">Show</label>
                            <select id="entries-polyline" onchange="changeEntries('polyline')" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label class="text-gray-700">entries</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-gray-700">Search:</label>
                            <input type="text" id="search-polyline" onkeyup="searchTable('polyline')" placeholder="Cari nama..." class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 w-64">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-teal-600 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">No</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Nama</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Jarak (m)</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Keterangan</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Warna</th>
                                </tr>
                            </thead>
                            <tbody id="table-polyline" class="bg-white">
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 border">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-sm text-gray-600" id="info-polyline">
                        Showing <span id="showing-polyline">0</span> of <span id="total-polyline">0</span> entries
                    </div>
                </div>

                <!-- Marker Table -->
                <div id="content-marker" class="tab-content hidden">
                    <div id="alert-container-marker"></div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Daftar Marker (Titik Lokasi)</h3>
                    
                    <!-- Search and Entries -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                        <div class="flex items-center gap-2">
                            <label class="text-gray-700">Show</label>
                            <select id="entries-marker" onchange="changeEntries('marker')" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label class="text-gray-700">entries</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-gray-700">Search:</label>
                            <input type="text" id="search-marker" onkeyup="searchTable('marker')" placeholder="Cari nama..." class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 w-64">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-cyan-600 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">No</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Nama</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Tipe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Deskripsi</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Latitude</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold border">Longitude</th>
                                </tr>
                            </thead>
                            <tbody id="table-marker" class="bg-white">
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 border">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-sm text-gray-600" id="info-marker">
                        Showing <span id="showing-marker">0</span> of <span id="total-marker">0</span> entries
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 Sistem Informasi Pertanahan. All rights reserved.</p>
        </div>
    </footer>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading">
        <div class="spinner"></div>
    </div>

    <script>
      // CSRF Token Setup
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Helper function untuk handle response
async function handleResponse(response) {
    const contentType = response.headers.get('content-type');
    
    if (contentType && contentType.includes('application/json')) {
        return await response.json();
    } else {
        const text = await response.text();
        console.error('Server returned non-JSON response:', text);
        throw new Error('Server mengembalikan response yang tidak valid.');
    }
}

// Tab Switching
function switchTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    document.querySelectorAll('[id^="tab-"]').forEach(tab => {
        tab.classList.remove('tab-active');
        tab.classList.add('tab-inactive');
    });
    
    document.getElementById('content-' + tabName).classList.remove('hidden');
    document.getElementById('tab-' + tabName).classList.remove('tab-inactive');
    document.getElementById('tab-' + tabName).classList.add('tab-active');
}

// Search Table
function searchTable(type) {
    const input = document.getElementById('search-' + type);
    const filter = input.value.toLowerCase();
    const table = document.getElementById('table-' + type);
    const rows = table.querySelectorAll('tr.data-row');
    
    let visibleCount = 0;
    const maxEntries = parseInt(document.getElementById('entries-' + type).value);
    
    rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        const shouldShow = text.indexOf(filter) > -1;
        
        if (shouldShow && visibleCount < maxEntries) {
            row.style.display = '';
            visibleCount++;
            row.cells[0].textContent = visibleCount;
        } else {
            row.style.display = 'none';
        }
    });
    
    updateShowingText(type, visibleCount);
}

// Change Entries
function changeEntries(type) {
    const maxEntries = parseInt(document.getElementById('entries-' + type).value);
    const table = document.getElementById('table-' + type);
    const rows = table.querySelectorAll('tr.data-row');
    
    let visibleCount = 0;
    
    rows.forEach((row) => {
        if (row.style.display !== 'none' || document.getElementById('search-' + type).value === '') {
            if (visibleCount < maxEntries) {
                row.style.display = '';
                visibleCount++;
                row.cells[0].textContent = visibleCount;
            } else {
                row.style.display = 'none';
            }
        }
    });
    
    updateShowingText(type, visibleCount);
}

// Update Showing Text
function updateShowingText(type, visibleCount) {
    const totalElement = document.getElementById('total-' + type);
    const showingElement = document.getElementById('showing-' + type);
    
    if (totalElement && showingElement) {
        const total = totalElement.textContent;
        if (visibleCount > 0 && total > 0) {
            showingElement.textContent = '1 to ' + visibleCount;
        } else {
            showingElement.textContent = '0';
        }
    }
}

// Show Alert
function showAlert(type, message, tabType = 'penduduk') {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${alertClass}`;
    alertDiv.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
    
    const container = document.getElementById('alert-container-' + tabType);
    if (container) {
        container.innerHTML = '';
        container.appendChild(alertDiv);
        
        setTimeout(() => alertDiv.remove(), 5000);
    }
}

// Show Loading
function showLoading(show) {
    const loadingElement = document.getElementById('loading');
    if (loadingElement) {
        loadingElement.classList.toggle('active', show);
    }
}

// Load Penduduk
async function loadPenduduk() {
    try {
        const response = await fetch('/penduduk/penduduk', {
            headers: { 'Accept': 'application/json' }
        });
        const data = await handleResponse(response);
        
        const tbody = document.getElementById('table-penduduk');
        tbody.innerHTML = '';
        
        if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="px-4 py-8 text-center text-gray-500 border">Tidak ada data penduduk</td></tr>';
            document.getElementById('total-penduduk').textContent = '0';
            document.getElementById('showing-penduduk').textContent = '0';
            return;
        }
        
        const fragment = document.createDocumentFragment();
        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-green-50 transition data-row';
            row.innerHTML = `
                <td class="px-4 py-3 border">${index + 1}</td>
                <td class="px-4 py-3 border font-semibold">${item.nik}</td>
                <td class="px-4 py-3 border">${item.nama}</td>
                <td class="px-4 py-3 border">${item.alamat}</td>
                <td class="px-4 py-3 border">${item.telepon || '-'}</td>
                <td class="px-4 py-3 border">${parseFloat(item.latitude).toFixed(6)}</td>
                <td class="px-4 py-3 border">${parseFloat(item.longitude).toFixed(6)}</td>
            `;
            fragment.appendChild(row);
        });
        tbody.appendChild(fragment);
        
        document.getElementById('total-penduduk').textContent = data.length;
        changeEntries('penduduk');
        
    } catch (error) {
        console.error('Error loading penduduk:', error);
        showAlert('error', 'Gagal memuat data penduduk: ' + error.message, 'penduduk');
        document.getElementById('table-penduduk').innerHTML = '<tr><td colspan="7" class="px-4 py-8 text-center text-red-500 border">Error: ' + error.message + '</td></tr>';
    }
}

// Load Polygon
async function loadPolygon() {
    try {
        const response = await fetch('/polygon/polygon', {
            headers: { 'Accept': 'application/json' }
        });
        const data = await handleResponse(response);
        
        const tbody = document.getElementById('table-polygon');
        tbody.innerHTML = '';
        
        if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500 border">Tidak ada data polygon</td></tr>';
            document.getElementById('total-polygon').textContent = '0';
            document.getElementById('showing-polygon').textContent = '0';
            return;
        }
        
        const fragment = document.createDocumentFragment();
        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-emerald-50 transition data-row';
            row.innerHTML = `
                <td class="px-4 py-3 border">${index + 1}</td>
                <td class="px-4 py-3 border font-semibold">${item.nama}</td>
                <td class="px-4 py-3 border">${parseFloat(item.luas).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                <td class="px-4 py-3 border">${item.keterangan || '-'}</td>
                <td class="px-4 py-3 border">
                    <span class="inline-block w-12 h-3 rounded" style="background-color: ${item.warna}"></span>
                    <span class="ml-2">${item.warna}</span>
                </td>
            `;
            fragment.appendChild(row);
        });
        tbody.appendChild(fragment);
        
        document.getElementById('total-polygon').textContent = data.length;
        changeEntries('polygon');
        
    } catch (error) {
        console.error('Error loading polygon:', error);
        showAlert('error', 'Gagal memuat data polygon: ' + error.message, 'polygon');
        document.getElementById('table-polygon').innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-red-500 border">Error: ' + error.message + '</td></tr>';
    }
}

// Load Polyline (ditambahkan untuk melengkapi, asumsikan endpoint /polyline/polyline)
async function loadPolyline() {
    try {
        const response = await fetch('/polyline/polyline', {
            headers: { 'Accept': 'application/json' }
        });
        const data = await handleResponse(response);
        
        const tbody = document.getElementById('table-polyline');
        tbody.innerHTML = '';
        
        if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500 border">Tidak ada data polyline</td></tr>';
            document.getElementById('total-polyline').textContent = '0';
            document.getElementById('showing-polyline').textContent = '0';
            return;
        }
        
        const fragment = document.createDocumentFragment();
        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-blue-50 transition data-row'; // Sesuaikan class jika perlu
            row.innerHTML = `
                <td class="px-4 py-3 border">${index + 1}</td>
                <td class="px-4 py-3 border font-semibold">${item.nama}</td>
                <td class="px-4 py-3 border">${parseFloat(item.luas || 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                <td class="px-4 py-3 border">${item.keterangan || '-'}</td>
                <td class="px-4 py-3 border">
                    <span class="inline-block w-12 h-3 rounded" style="background-color: ${item.warna || '#000'}"></span>
                    <span class="ml-2">${item.warna || '#000'}</span>
                </td>
            `;
            fragment.appendChild(row);
        });
        tbody.appendChild(fragment);
        
        document.getElementById('total-polyline').textContent = data.length;
        changeEntries('polyline');
        
    } catch (error) {
        console.error('Error loading polyline:', error);
        showAlert('error', 'Gagal memuat data polyline: ' + error.message, 'polyline');
        document.getElementById('table-polyline').innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-red-500 border">Error: ' + error.message + '</td></tr>';
    }
}

// Load Marker
async function loadMarker() {
    try {
        const response = await fetch('/marker/marker', {
            headers: { 'Accept': 'application/json' }
        });
        const data = await handleResponse(response);
        
        const tbody = document.getElementById('table-marker');
        tbody.innerHTML = '';
        
        if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-gray-500 border">Tidak ada data marker</td></tr>';
            document.getElementById('total-marker').textContent = '0';
            document.getElementById('showing-marker').textContent = '0';
            return;
        }
        
        const fragment = document.createDocumentFragment();
        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-cyan-50 transition data-row';
            row.innerHTML = `
                <td class="px-4 py-3 border">${index + 1}</td>
                <td class="px-4 py-3 border font-semibold">${item.nama}</td>
                <td class="px-4 py-3 border">
                    <span class="bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-sm">${item.tipe}</span>
                </td>
                <td class="px-4 py-3 border">${item.deskripsi || '-'}</td>
                <td class="px-4 py-3 border">${parseFloat(item.latitude).toFixed(6)}</td>
                <td class="px-4 py-3 border">${parseFloat(item.longitude).toFixed(6)}</td>
            `;
            fragment.appendChild(row);
        });
        tbody.appendChild(fragment);
        
        document.getElementById('total-marker').textContent = data.length;
        changeEntries('marker');
        
    } catch (error) {
        console.error('Error loading marker:', error);
        showAlert('error', 'Gagal memuat data marker: ' + error.message, 'marker');
        document.getElementById('table-marker').innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-red-500 border">Error: ' + error.message + '</td></tr>';
    }
}

// Fungsi untuk mendeteksi perubahan di DB (polling sederhana setiap 30 detik)
function startPolling() {
    setInterval(async () => {
        try {
            await Promise.all([
                loadPenduduk(),
                loadPolygon(),
                loadPolyline(),
                loadMarker()
            ]);
        } catch (error) {
            console.error('Error during polling:', error);
        }
    }, 30000); // Polling setiap 30 detik, sesuaikan jika perlu
}

// Load all data when page loads
document.addEventListener('DOMContentLoaded', function() {
    showLoading(true);
    
    Promise.all([
        loadPenduduk(),
        loadPolygon(),
        loadPolyline(),
        loadMarker()
    ]).then(() => {
        showLoading(false);
        startPolling(); // Mulai polling setelah load awal
    }).catch(error => {
        console.error('Error loading data:', error);
        showLoading(false);
        showAlert('error', 'Gagal memuat data: ' + error.message);
    });
});

    </script>
</body>
</html>