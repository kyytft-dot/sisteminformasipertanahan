<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Peta Pertanahan - Sistem Informasi Pertanahan</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            overflow: hidden;
            background: #f1f5f9;
        }

        #map {
            width: 100%;
            height: 100vh;
            z-index: 1;
        }

        /* Control Panel */
        .control-panel {
            position: absolute;
            top: 20px;
            left: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
            width: 320px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .panel-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }

        .panel-header h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .panel-header p {
            font-size: 13px;
            opacity: 0.9;
        }

        .panel-content {
            padding: 20px;
        }

        .tab-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-bottom: 20px;
        }

        .tab-btn {
            padding: 10px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .tab-btn:hover {
            border-color: #10b981;
            color: #10b981;
        }

        .tab-btn.active {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #10b981;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: #10b981;
            color: white;
        }

        .btn-primary:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .data-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .data-item {
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .data-item:hover {
            border-color: #10b981;
            transform: translateX(5px);
        }

        .data-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .data-item-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }

        .data-item-actions {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .btn-icon.edit {
            background: #3b82f6;
            color: white;
        }

        .btn-icon.edit:hover {
            background: #2563eb;
        }

        .btn-icon.delete {
            background: #ef4444;
            color: white;
        }

        .btn-icon.delete:hover {
            background: #dc2626;
        }

        .btn-icon.view {
            background: #10b981;
            color: white;
        }

        .btn-icon.view:hover {
            background: #059669;
        }

        .data-item-info {
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
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

        .draw-controls {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .draw-btn {
            padding: 12px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .draw-btn:hover {
            border-color: #10b981;
            color: #10b981;
            transform: translateY(-2px);
        }

        .draw-btn.active {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .draw-btn i {
            font-size: 20px;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            cursor: pointer;
            font-weight: 600;
            color: #334155;
            transition: all 0.3s;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            background: #10b981;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
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

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .info-box {
            background: #f0fdf4;
            border: 1px solid #86efac;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 12px;
            color: #166534;
        }
    </style>
</head>
<body>
    <!-- Map Container -->
    <div id="map"></div>

    <!-- Back Button -->
    <button class="back-btn" onclick="window.location.href='/'">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Dashboard
    </button>

    <!-- Control Panel -->
    <div class="control-panel">
        <div class="panel-header">
            <h2><i class="fas fa-map-marked-alt"></i> Peta Pertanahan</h2>
            <p>Kelola data spasial pertanahan</p>
        </div>

        <div class="panel-content">
            <!-- Tab Buttons -->
            <div class="tab-buttons">
                <button class="tab-btn active" data-tab="penduduk">
                    <i class="fas fa-users"></i> Penduduk
                </button>
                <button class="tab-btn" data-tab="polygon">
                    <i class="fas fa-draw-polygon"></i> Polygon
                </button>
                <button class="tab-btn" data-tab="polyline">
                    <i class="fas fa-route"></i> Jarak
                </button>
                <button class="tab-btn" data-tab="marker">
                    <i class="fas fa-map-marker-alt"></i> Marker
                </button>
            </div>

            <!-- Penduduk Tab -->
            <div class="tab-content active" id="penduduk-tab">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i> Klik pada peta untuk menambah lokasi penduduk
                </div>

                <form id="form-penduduk">
                    <input type="hidden" id="penduduk_id">
                    <input type="hidden" id="penduduk_lat">
                    <input type="hidden" id="penduduk_lng">

                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" id="nik" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" id="nama" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea id="alamat" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" id="telepon">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Penduduk
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm('penduduk')">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </form>

                <hr style="margin: 20px 0; border: none; border-top: 2px solid #e2e8f0;">

                <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 15px; color: #1e293b;">
                    <i class="fas fa-list"></i> Daftar Penduduk
                </h3>
                <div class="data-list" id="list-penduduk"></div>
            </div>

            <!-- Polygon Tab -->
            <div class="tab-content" id="polygon-tab">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i> Klik "Gambar Polygon" lalu klik pada peta untuk membuat bentuk
                </div>

                <div class="draw-controls">
                    <button class="draw-btn" onclick="startDrawing('polygon')">
                        <i class="fas fa-draw-polygon"></i>
                        <span>Gambar Polygon</span>
                    </button>
                    <button class="draw-btn" onclick="stopDrawing()">
                        <i class="fas fa-stop"></i>
                        <span>Batal</span>
                    </button>
                </div>

                <form id="form-polygon">
                    <input type="hidden" id="polygon_id">
                    <input type="hidden" id="polygon_coordinates">

                    <div class="form-group">
                        <label>Nama Lokasi</label>
                        <input type="text" id="polygon_nama" required>
                    </div>

                    <div class="form-group">
                        <label>Luas (m²)</label>
                        <input type="number" step="0.01" id="luas" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea id="polygon_keterangan"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Warna</label>
                        <input type="color" id="polygon_warna" value="#10b981">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Polygon
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm('polygon')">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </form>

                <hr style="margin: 20px 0; border: none; border-top: 2px solid #e2e8f0;">

                <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 15px; color: #1e293b;">
                    <i class="fas fa-list"></i> Daftar Polygon
                </h3>
                <div class="data-list" id="list-polygon"></div>
            </div>

            <!-- Polyline Tab -->
            <div class="tab-content" id="polyline-tab">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i> Klik "Gambar Garis" lalu klik pada peta untuk membuat rute
                </div>

                <div class="draw-controls">
                    <button class="draw-btn" onclick="startDrawing('polyline')">
                        <i class="fas fa-route"></i>
                        <span>Gambar Garis</span>
                    </button>
                    <button class="draw-btn" onclick="stopDrawing()">
                        <i class="fas fa-stop"></i>
                        <span>Batal</span>
                    </button>
                </div>

                <form id="form-polyline">
                    <input type="hidden" id="polyline_id">
                    <input type="hidden" id="polyline_coordinates">

                    <div class="form-group">
                        <label>Nama Rute</label>
                        <input type="text" id="polyline_nama" required>
                    </div>

                    <div class="form-group">
                        <label>Jarak (meter)</label>
                        <input type="number" step="0.01" id="jarak" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea id="polyline_keterangan"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Warna</label>
                        <input type="color" id="polyline_warna" value="#3b82f6">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Polyline
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm('polyline')">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </form>

                <hr style="margin: 20px 0; border: none; border-top: 2px solid #e2e8f0;">

                <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 15px; color: #1e293b;">
                    <i class="fas fa-list"></i> Daftar Polyline
                </h3>
                <div class="data-list" id="list-polyline"></div>
            </div>

            <!-- Marker Tab -->
            <div class="tab-content" id="marker-tab">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i> Klik pada peta untuk menambah marker
                </div>

                <form id="form-marker">
                    <input type="hidden" id="marker_id">
                    <input type="hidden" id="marker_lat">
                    <input type="hidden" id="marker_lng">

                    <div class="form-group">
                        <label>Nama Marker</label>
                        <input type="text" id="marker_nama" required>
                    </div>

                    <div class="form-group">
                        <label>Tipe</label>
                        <select id="marker_tipe" required>
                            <option value="">Pilih Tipe</option>
                            <option value="Kantor">Kantor</option>
                            <option value="Sekolah">Sekolah</option>
                            <option value="Rumah Sakit">Rumah Sakit</option>
                            <option value="Tempat Ibadah">Tempat Ibadah</option>
                            <option value="Fasilitas Umum">Fasilitas Umum</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="marker_deskripsi"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Marker
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm('marker')">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </form>

                <hr style="margin: 20px 0; border: none; border-top: 2px solid #e2e8f0;">

                <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 15px; color: #1e293b;">
                    <i class="fas fa-list"></i> Daftar Marker
                </h3>
                <div class="data-list" id="list-marker"></div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading">
        <div class="spinner"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>

    <script>
      // Initialize Map
const map = L.map('map').setView([-6.9175, 107.6191], 13); // Bandung coordinates

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 19
}).addTo(map);

// CSRF Token Setup
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Layer Groups
const pendudukLayer = L.layerGroup().addTo(map);
const polygonLayer = L.layerGroup().addTo(map);
const polylineLayer = L.layerGroup().addTo(map);
const markerLayer = L.layerGroup().addTo(map);

// Drawing variables
let currentDrawing = null;
let drawingMode = null;

// Tab Switching
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const tab = this.dataset.tab;
        
        // Update buttons
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Update content
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById(tab + '-tab').classList.add('active');
        
        // Stop drawing when switching tabs
        stopDrawing();
    });
});

// Map Click Handler
map.on('click', function(e) {
    const activeTab = document.querySelector('.tab-content.active').id;
    
    if (activeTab === 'penduduk-tab') {
        document.getElementById('penduduk_lat').value = e.latlng.lat;
        document.getElementById('penduduk_lng').value = e.latlng.lng;
        showAlert('success', 'Lokasi dipilih! Silakan isi form.');
    } else if (activeTab === 'marker-tab') {
        document.getElementById('marker_lat').value = e.latlng.lat;
        document.getElementById('marker_lng').value = e.latlng.lng;
        showAlert('success', 'Lokasi marker dipilih! Silakan isi form.');
    }
});

// Drawing Functions
function startDrawing(type) {
    stopDrawing();
    drawingMode = type;
    
    if (type === 'polygon') {
        currentDrawing = new L.Draw.Polygon(map);
    } else if (type === 'polyline') {
        currentDrawing = new L.Draw.Polyline(map);
    }
    
    currentDrawing.enable();
    showAlert('success', 'Mode gambar aktif. Klik pada peta untuk membuat titik.');
}

function stopDrawing() {
    if (currentDrawing) {
        currentDrawing.disable();
        currentDrawing = null;
    }
    drawingMode = null;
}

// Handle created shapes
map.on(L.Draw.Event.CREATED, function(e) {
    const layer = e.layer;
    const type = e.layerType;
    
    if (type === 'polygon') {
        const coordinates = JSON.stringify(layer.getLatLngs()[0].map(ll => [ll.lat, ll.lng]));
        document.getElementById('polygon_coordinates').value = coordinates;
        
        // Calculate area
        const area = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]);
        document.getElementById('luas').value = area.toFixed(2);
        
        showAlert('success', 'Polygon berhasil digambar! Silakan lengkapi form.');
    } else if (type === 'polyline') {
        const coordinates = JSON.stringify(layer.getLatLngs().map(ll => [ll.lat, ll.lng]));
        document.getElementById('polyline_coordinates').value = coordinates;
        
        // Calculate distance
        let distance = 0;
        const latlngs = layer.getLatLngs();
        for (let i = 0; i < latlngs.length - 1; i++) {
            distance += latlngs[i].distanceTo(latlngs[i + 1]);
        }
        document.getElementById('jarak').value = distance.toFixed(2);
        
        showAlert('success', 'Polyline berhasil digambar! Silakan lengkapi form.');
    }
    
    stopDrawing();
});

// Helper function untuk handle response dengan error checking yang lebih baik
async function handleResponse(response) {
    const contentType = response.headers.get('content-type');
    
    // Check if response is JSON
    if (contentType && contentType.includes('application/json')) {
        return await response.json();
    } else {
        // If not JSON, get text to see what the server actually returned
        const text = await response.text();
        console.error('Server returned non-JSON response:', text);
        throw new Error('Server mengembalikan response yang tidak valid. Periksa koneksi ke server.');
    }
}

// CRUD Functions - Penduduk
document.getElementById('form-penduduk').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const id = document.getElementById('penduduk_id').value;
    const data = {
        nik: document.getElementById('nik').value,
        nama: document.getElementById('nama').value,
        alamat: document.getElementById('alamat').value,
        telepon: document.getElementById('telepon').value,
        latitude: document.getElementById('penduduk_lat').value,
        longitude: document.getElementById('penduduk_lng').value
    };
    
    // Validasi data
    if (!data.latitude || !data.longitude) {
        showAlert('error', 'Silakan pilih lokasi pada peta terlebih dahulu!');
        return;
    }
    
    const url = id ? `/penduduk/penduduk/${id}` : '/penduduk/penduduk';
    const method = id ? 'PUT' : 'POST';
    
    try {
        showLoading(true);
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await handleResponse(response);
        
        if (response.ok) {
            showAlert('success', id ? 'Data penduduk berhasil diupdate!' : 'Data penduduk berhasil disimpan!');
            resetForm('penduduk');
            loadPenduduk();
        } else {
            showAlert('error', result.message || 'Terjadi kesalahan saat menyimpan data!');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', 'Gagal menyimpan data: ' + error.message);
    } finally {
        showLoading(false);
    }
});

async function loadPenduduk() {
    try {
        const response = await fetch('/penduduk/penduduk', {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        
        pendudukLayer.clearLayers();
        const listContainer = document.getElementById('list-penduduk');
        listContainer.innerHTML = '';
        
        if (!Array.isArray(data)) {
            console.error('Data is not an array:', data);
            return;
        }
        
        data.forEach(item => {
            // Add marker to map
            const marker = L.marker([item.latitude, item.longitude], {
                icon: L.divIcon({
                    html: '<i class="fas fa-user" style="color: #10b981; font-size: 24px;"></i>',
                    className: 'custom-div-icon',
                    iconSize: [30, 30],
                    iconAnchor: [15, 30]
                })
            }).addTo(pendudukLayer);
            
            marker.bindPopup(`
                <strong>${item.nama}</strong><br>
                NIK: ${item.nik}<br>
                ${item.alamat}<br>
                Telp: ${item.telepon || '-'}
            `);
            
            // Add to list
            listContainer.innerHTML += `
                <div class="data-item">
                    <div class="data-item-header">
                        <div class="data-item-title">${item.nama}</div>
                        <div class="data-item-actions">
                            <button class="btn-icon view" onclick="viewOnMap(${item.latitude}, ${item.longitude})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon edit" onclick="editPenduduk(${item.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePenduduk(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="data-item-info">
                        NIK: ${item.nik}<br>
                        Alamat: ${item.alamat}
                    </div>
                </div>
            `;
        });
    } catch (error) {
        console.error('Error loading penduduk:', error);
        showAlert('error', 'Gagal memuat data penduduk: ' + error.message);
    }
}

async function editPenduduk(id) {
    try {
        const response = await fetch(`/penduduk/penduduk/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        
        document.getElementById('penduduk_id').value = data.id;
        document.getElementById('nik').value = data.nik;
        document.getElementById('nama').value = data.nama;
        document.getElementById('alamat').value = data.alamat;
        document.getElementById('telepon').value = data.telepon || '';
        document.getElementById('penduduk_lat').value = data.latitude;
        document.getElementById('penduduk_lng').value = data.longitude;
        
        viewOnMap(data.latitude, data.longitude);
    } catch (error) {
        console.error('Error editing penduduk:', error);
        showAlert('error', 'Gagal memuat data: ' + error.message);
    }
}

async function deletePenduduk(id) {
    if (!confirm('Yakin ingin menghapus data ini?')) return;
    
    try {
        showLoading(true);
        const response = await fetch(`/penduduk/penduduk/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            showAlert('success', 'Data berhasil dihapus!');
            loadPenduduk();
        } else {
            const result = await handleResponse(response);
            showAlert('error', result.message || 'Gagal menghapus data');
        }
    } catch (error) {
        console.error('Error deleting penduduk:', error);
        showAlert('error', 'Terjadi kesalahan: ' + error.message);
    } finally {
        showLoading(false);
    }
}

// CRUD Functions - Polygon
document.getElementById('form-polygon').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const id = document.getElementById('polygon_id').value;
    const coordinatesValue = document.getElementById('polygon_coordinates').value;
    
    // Validasi coordinates
    if (!coordinatesValue) {
        showAlert('error', 'Silakan gambar polygon pada peta terlebih dahulu!');
        return;
    }
    
    const data = {
        nama: document.getElementById('polygon_nama').value,
        luas: document.getElementById('luas').value,
        keterangan: document.getElementById('polygon_keterangan').value,
        warna: document.getElementById('polygon_warna').value,
        coordinates: coordinatesValue
    };
    
    const url = id ? `/polygon/polygon/${id}` : '/polygon/polygon';
    const method = id ? 'PUT' : 'POST';
    
    try {
        showLoading(true);
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await handleResponse(response);
        
        if (response.ok) {
            showAlert('success', id ? 'Polygon berhasil diupdate!' : 'Polygon berhasil disimpan!');
            resetForm('polygon');
            loadPolygon();
        } else {
            showAlert('error', result.message || 'Terjadi kesalahan saat menyimpan polygon!');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', 'Gagal menyimpan data: ' + error.message);
    } finally {
        showLoading(false);
    }
});

async function loadPolygon() {
    try {
        const response = await fetch('/polygon/polygon', {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        
        polygonLayer.clearLayers();
        const listContainer = document.getElementById('list-polygon');
        listContainer.innerHTML = '';
        
        if (!Array.isArray(data)) {
            console.error('Data is not an array:', data);
            return;
        }
        
        data.forEach(item => {
            const coordinates = JSON.parse(item.coordinates);
            const polygon = L.polygon(coordinates, {
                color: item.warna,
                fillColor: item.warna,
                fillOpacity: 0.4
            }).addTo(polygonLayer);
            
            polygon.bindPopup(`
                <strong>${item.nama}</strong><br>
                Luas: ${item.luas} m²<br>
                ${item.keterangan || ''}
            `);
            
            listContainer.innerHTML += `
                <div class="data-item">
                    <div class="data-item-header">
                        <div class="data-item-title">${item.nama}</div>
                        <div class="data-item-actions">
                            <button class="btn-icon view" onclick="viewPolygon(${item.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon edit" onclick="editPolygon(${item.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePolygon(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="data-item-info">
                        Luas: ${item.luas} m²<br>
                        ${item.keterangan || '-'}
                    </div>
                </div>
            `;
        });
    } catch (error) {
        console.error('Error loading polygon:', error);
        showAlert('error', 'Gagal memuat data polygon: ' + error.message);
    }
}

async function editPolygon(id) {
    try {
        const response = await fetch(`/polygon/polygon/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        
        document.getElementById('polygon_id').value = data.id;
        document.getElementById('polygon_nama').value = data.nama;
        document.getElementById('luas').value = data.luas;
        document.getElementById('polygon_keterangan').value = data.keterangan || '';
        document.getElementById('polygon_warna').value = data.warna;
        document.getElementById('polygon_coordinates').value = data.coordinates;
        
        // Switch to polygon tab
        document.querySelector('[data-tab="polygon"]').click();
        viewPolygon(id);
    } catch (error) {
        console.error('Error editing polygon:', error);
        showAlert('error', 'Gagal memuat data: ' + error.message);
    }
}

async function viewPolygon(id) {
    try {
        const response = await fetch(`/polygon/polygon/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        const coordinates = JSON.parse(data.coordinates);
        
        if (coordinates.length > 0) {
            const bounds = L.latLngBounds(coordinates);
            map.fitBounds(bounds);
        }
    } catch (error) {
        console.error('Error viewing polygon:', error);
        showAlert('error', 'Gagal menampilkan polygon: ' + error.message);
    }
}

async function deletePolygon(id) {
    if (!confirm('Yakin ingin menghapus polygon ini?')) return;
    
    try {
        showLoading(true);
        const response = await fetch(`/polygon/polygon/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            showAlert('success', 'Polygon berhasil dihapus!');
            loadPolygon();
        } else {
            const result = await handleResponse(response);
            showAlert('error', result.message || 'Gagal menghapus polygon');
        }
    } catch (error) {
        console.error('Error deleting polygon:', error);
        showAlert('error', 'Terjadi kesalahan: ' + error.message);
    } finally {
        showLoading(false);
    }
}

// CRUD Functions - Polyline
document.getElementById('form-polyline').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const id = document.getElementById('polyline_id').value;
    const coordinatesValue = document.getElementById('polyline_coordinates').value;
    
    // Validasi coordinates
    if (!coordinatesValue) {
        showAlert('error', 'Silakan gambar polyline pada peta terlebih dahulu!');
        return;
    }
    
    const data = {
        nama: document.getElementById('polyline_nama').value,
        jarak: document.getElementById('jarak').value,
        keterangan: document.getElementById('polyline_keterangan').value,
        warna: document.getElementById('polyline_warna').value,
        coordinates: coordinatesValue
    };
    
    const url = id ? `/polyline/polyline/${id}` : '/polyline/polyline';
    const method = id ? 'PUT' : 'POST';
    
    try {
        showLoading(true);
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await handleResponse(response);
        
        if (response.ok) {
            showAlert('success', id ? 'Polyline berhasil diupdate!' : 'Polyline berhasil disimpan!');
            resetForm('polyline');
            loadPolyline();
        } else {
            showAlert('error', result.message || 'Terjadi kesalahan saat menyimpan polyline!');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', 'Gagal menyimpan data: ' + error.message);
    } finally {
        showLoading(false);
    }
});

async function loadPolyline() {
    try {
        const response = await fetch('/polyline/polyline', {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        
        polylineLayer.clearLayers();
        const listContainer = document.getElementById('list-polyline');
        listContainer.innerHTML = '';
        
        if (!Array.isArray(data)) {
            console.error('Data is not an array:', data);
            return;
        }
        
        data.forEach(item => {
            const coordinates = JSON.parse(item.coordinates);
            const polyline = L.polyline(coordinates, {
                color: item.warna,
                weight: 4
            }).addTo(polylineLayer);
            
            polyline.bindPopup(`
                <strong>${item.nama}</strong><br>
                Jarak: ${item.jarak} meter<br>
                ${item.keterangan || ''}
            `);
            
            listContainer.innerHTML += `
                <div class="data-item">
                    <div class="data-item-header">
                        <div class="data-item-title">${item.nama}</div>
                        <div class="data-item-actions">
                            <button class="btn-icon view" onclick="viewPolyline(${item.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon edit" onclick="editPolyline(${item.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePolyline(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="data-item-info">
                        Jarak: ${item.jarak} meter<br>
                        ${item.keterangan || '-'}
                    </div>
                </div>
            `;
        });
    } catch (error) {
        console.error('Error loading polyline:', error);
        showAlert('error', 'Gagal memuat data polyline: ' + error.message);
    }
}

async function editPolyline(id) {
    try {
        const response = await fetch(`/polyline/polyline/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        
        document.getElementById('polyline_id').value = data.id;
        document.getElementById('polyline_nama').value = data.nama;
        document.getElementById('jarak').value = data.jarak;
        document.getElementById('polyline_keterangan').value = data.keterangan || '';
        document.getElementById('polyline_warna').value = data.warna;
        document.getElementById('polyline_coordinates').value = data.coordinates;
        
        document.querySelector('[data-tab="polyline"]').click();
        viewPolyline(id);
    } catch (error) {
        console.error('Error editing polyline:', error);
        showAlert('error', 'Gagal memuat data: ' + error.message);
    }
}

async function viewPolyline(id) {
    try {
        const response = await fetch(`/polyline/polyline/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        const coordinates = JSON.parse(data.coordinates);
        
        if (coordinates.length > 0) {
            const bounds = L.latLngBounds(coordinates);
            map.fitBounds(bounds);
        }
    } catch (error) {
        console.error('Error viewing polyline:', error);
        showAlert('error', 'Gagal menampilkan polyline: ' + error.message);
    }
}

async function deletePolyline(id) {
    if (!confirm('Yakin ingin menghapus polyline ini?')) return;
    
    try {
        showLoading(true);
        const response = await fetch(`/polyline/polyline/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            showAlert('success', 'Polyline berhasil dihapus!');
            loadPolyline();
        } else {
            const result = await handleResponse(response);
            showAlert('error', result.message || 'Gagal menghapus polyline');
        }
    } catch (error) {
        console.error('Error deleting polyline:', error);
        showAlert('error', 'Terjadi kesalahan: ' + error.message);
    } finally {
        showLoading(false);
    }
}

// CRUD Functions - Marker
document.getElementById('form-marker').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const id = document.getElementById('marker_id').value;
    const data = {
        nama: document.getElementById('marker_nama').value,
        tipe: document.getElementById('marker_tipe').value,
        deskripsi: document.getElementById('marker_deskripsi').value,
        latitude: document.getElementById('marker_lat').value,
        longitude: document.getElementById('marker_lng').value
    };
    
    // Validasi data
    if (!data.latitude || !data.longitude) {
        showAlert('error', 'Silakan pilih lokasi pada peta terlebih dahulu!');
        return;
    }
    
    const url = id ? `/marker/marker/${id}` : '/marker/marker';
    const method = id ? 'PUT' : 'POST';
    
    try {
        showLoading(true);
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await handleResponse(response);
        
        if (response.ok) {
            showAlert('success', id ? 'Marker berhasil diupdate!' : 'Marker berhasil disimpan!');
            resetForm('marker');
            loadMarker();
        } else {
            showAlert('error', result.message || 'Terjadi kesalahan saat menyimpan marker!');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', 'Gagal menyimpan data: ' + error.message);
    } finally {
        showLoading(false);
    }
});

async function loadMarker() {
    try {
        const response = await fetch('/marker/marker', {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        
        markerLayer.clearLayers();
        const listContainer = document.getElementById('list-marker');
        listContainer.innerHTML = '';
        
        if (!Array.isArray(data)) {
            console.error('Data is not an array:', data);
            return;
        }
        
        const markerIcons = {
            'Kantor': 'fa-building',
            'Sekolah': 'fa-school',
            'Rumah Sakit': 'fa-hospital',
            'Tempat Ibadah': 'fa-place-of-worship',
            'Fasilitas Umum': 'fa-landmark',
            'Lainnya': 'fa-map-pin'
        };
        
        data.forEach(item => {
            const iconClass = markerIcons[item.tipe] || 'fa-map-pin';
            const marker = L.marker([item.latitude, item.longitude], {
                icon: L.divIcon({
                    html: `<i class="fas ${iconClass}" style="color: #ef4444; font-size: 24px;"></i>`,
                    className: 'custom-div-icon',
                    iconSize: [30, 30],
                    iconAnchor: [15, 30]
                })
            }).addTo(markerLayer);
            
            marker.bindPopup(`
                <strong>${item.nama}</strong><br>
                Tipe: ${item.tipe}<br>
                ${item.deskripsi || ''}
            `);
            
            listContainer.innerHTML += `
                <div class="data-item">
                    <div class="data-item-header">
                        <div class="data-item-title">${item.nama}</div>
                        <div class="data-item-actions">
                            <button class="btn-icon view" onclick="viewOnMap(${item.latitude}, ${item.longitude})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon edit" onclick="editMarker(${item.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deleteMarker(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="data-item-info">
                        Tipe: ${item.tipe}<br>
                        ${item.deskripsi || '-'}
                    </div>
                </div>
            `;
        });
    } catch (error) {
        console.error('Error loading marker:', error);
        showAlert('error', 'Gagal memuat data marker: ' + error.message);
    }
}

async function editMarker(id) {
    try {
        const response = await fetch(`/marker/marker/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await handleResponse(response);
        
        document.getElementById('marker_id').value = data.id;
        document.getElementById('marker_nama').value = data.nama;
        document.getElementById('marker_tipe').value = data.tipe;
        document.getElementById('marker_deskripsi').value = data.deskripsi || '';
        document.getElementById('marker_lat').value = data.latitude;
        document.getElementById('marker_lng').value = data.longitude;
        
        viewOnMap(data.latitude, data.longitude);
    } catch (error) {
        console.error('Error editing marker:', error);
        showAlert('error', 'Gagal memuat data: ' + error.message);
    }
}

async function deleteMarker(id) {
    if (!confirm('Yakin ingin menghapus marker ini?')) return;
    
    try {
        showLoading(true);
        const response = await fetch(`/marker/marker/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            showAlert('success', 'Marker berhasil dihapus!');
            loadMarker();
        } else {
            const result = await handleResponse(response);
            showAlert('error', result.message || 'Gagal menghapus marker');
        }
    } catch (error) {
        console.error('Error deleting marker:', error);
        showAlert('error', 'Terjadi kesalahan: ' + error.message);
    } finally {
        showLoading(false);
    }
}

// Helper Functions
function viewOnMap(lat, lng) {
    map.setView([lat, lng], 16);
}

function resetForm(type) {
    document.getElementById(`form-${type}`).reset();
    document.getElementById(`${type}_id`).value = '';
    
    if (type === 'polygon') {
        document.getElementById('polygon_coordinates').value = '';
    } else if (type === 'polyline') {
        document.getElementById('polyline_coordinates').value = '';
    }
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${alertClass}`;
    alertDiv.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
    
    const activeTab = document.querySelector('.tab-content.active');
    if (activeTab) {
        activeTab.insertBefore(alertDiv, activeTab.firstChild);
        
        setTimeout(() => alertDiv.remove(), 5000);
    }
}

function showLoading(show) {
    const loadingElement = document.getElementById('loading');
    if (loadingElement) {
        loadingElement.classList.toggle('active', show);
    }
}

// Load all data on page load
window.addEventListener('load', function() {
    loadPenduduk();
    loadPolygon();
    loadPolyline();
    loadMarker();
});

// Leaflet GeometryUtil for area calculation
L.GeometryUtil = L.extend(L.GeometryUtil || {}, {
    geodesicArea: function (latLngs) {
        var pointsCount = latLngs.length,
            area = 0.0,
            d2r = Math.PI / 180,
            p1, p2;

        if (pointsCount > 2) {
            for (var i = 0; i < pointsCount; i++) {
                p1 = latLngs[i];
                p2 = latLngs[(i + 1) % pointsCount];
                area += ((p2.lng - p1.lng) * d2r) *
                        (2 + Math.sin(p1.lat * d2r) + Math.sin(p2.lat * d2r));
            }
            area = area * 6378137.0 * 6378137.0 / 2.0;
        }

        return Math.abs(area);
    }
});
    </script>
</body>
</html>