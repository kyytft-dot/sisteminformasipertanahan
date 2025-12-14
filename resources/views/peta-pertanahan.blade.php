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
        .control-panel {
            position: absolute;
            top: 20px;
            left: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
            width: 380px;
            max-height: 90vh;
            overflow-y: auto;
            padding-bottom: 20px;
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
        /* Map search box in header */
        .map-search {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .search-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .map-search input {
            flex: 1;
            padding: 8px 10px;
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.15);
            background: white;
            color: black;
            font-size: 13px;
        }
        .map-search input::placeholder {
            color: black;
        }
        .map-search button {
            background: rgba(0,0,0,0.12);
            border: none;
            color: white;
            padding: 8px 10px;
            border-radius: 8px;
            cursor: pointer;
        }
        .nearby-places {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .nearby-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 11px;
            transition: all 0.3s;
        }
        .nearby-btn:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.3);
        }
        .nearby-btn.active {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }
        #map-search-results .result-item.selected {
            background: #e0e0e0 !important;
        }
        #map-search-results .result-item {
            cursor: pointer;
            padding: 8px 10px;
            border-bottom: 1px solid #eef2f7;
        }
        #map-search-results .result-item:hover,
        #map-search-results .result-item.selected {
            background: #f8fafc !important;
        }
        /* search results dropdown */
        #map-search-results {
            position: relative;
        }
        #map-search-results .results {
            position: absolute;
            left: 0;
            top: 8px;
            z-index: 1400;
            background: white;
            color: #0f172a;
            max-height: 260px;
            overflow-y: auto;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
            border-radius: 8px;
            width: 100%;
        }
        #map-search-results .result-item {
            padding: 8px 10px;
            border-bottom: 1px solid #eef2f7;
            cursor: pointer;
        }
        #map-search-results .result-item:hover { background:#f8fafc }
        .panel-content {
            padding: 20px;
        }

        /* Form Section - Hidden by default */
        .form-section {
            display: none;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .form-section.active {
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
        .form-group input[readonly] {
            background-color: #f1f5f9;
            cursor: not-allowed;
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
        }
        .btn-secondary {
            background: #64748b;
            color: white;
            margin-top: 10px;
        }
        .btn-secondary:hover {
            background: #475569;
        }
        .btn-new {
            background: #3b82f6;
            color: white;
            margin: 15px 0;
            font-size: 14px;
        }
        .btn-new:hover {
            background: #2563eb;
        }

        .draw-controls {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
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
        }
        .draw-btn.active {
            background: #10b981;
            color: white;
            border-color: #10b981;
        }
        .draw-btn i {
            font-size: 20px;
        }

        .file-upload-section {
            margin: 15px 0;
            padding: 12px;
            background: #f0fdf4;
            border-radius: 8px;
            border: 2px dashed #86efac;
        }
        .file-upload-section label {
            font-size: 12px;
            font-weight: 600;
            color: #166534;
            margin-bottom: 8px;
            display: block;
        }
        .file-input {
            font-size: 13px;
        }

        /* Daftar Section */
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 20px 0 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .search-box {
            position: relative;
            margin-bottom: 12px;
        }
        .search-input {
            width: 100%;
            padding: 10px 40px 10px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }
        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .data-list {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 15px;
        }
        .data-item {
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
            cursor: pointer;
        }
        .data-item:hover {
            border-color: #10b981;
            transform: translateX(4px);
        }
        .data-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .data-item-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }
        .data-item-actions {
            display: flex;
            gap: 6px;
        }
        .btn-icon {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }
        .btn-icon.edit {
            background: #3b82f6;
            color: white;
        }
        .btn-icon.delete {
            background: #ef4444;
            color: white;
        }
        .data-item-info {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }
        .data-count {
            font-size: 12px;
            color: #64748b;
            text-align: center;
            margin-bottom: 8px;
        }
        .load-more-section {
            text-align: center;
            margin-top: 10px;
        }
        .btn-load-more {
            padding: 8px 16px;
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            color: #334155;
            cursor: pointer;
        }
        .btn-load-more:hover {
            background: #10b981;
            color: white;
            border-color: #10b981;
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
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .back-btn:hover {
            background: #10b981;
            color: white;
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
            /* Legend on map (bottom-right) */
            .map-legend {
                position: absolute;
                right: 12px;
                bottom: 12px;
                background: white;
                padding: 10px 12px;
                border-radius: 8px;
                box-shadow: 0 6px 18px rgba(0,0,0,0.12);
                z-index: 1200;
                font-size: 13px;
                display: block; /* visible by default */
                min-width: 170px;
                max-height: 260px; /* limit height and allow scrolling */
                overflow-y: auto;
                padding-right: 8px; /* space for scrollbar */
            }
            .legend-toggle {
                position: absolute;
                right: 12px;
                bottom: 12px;
                transform: translateY(-54px);
                z-index: 1300;
                background: #111827;
                color: #fff;
                border: none;
                padding: 8px 10px;
                border-radius: 8px;
                cursor: pointer;
                box-shadow: 0 6px 18px rgba(0,0,0,0.12);
                font-size: 13px;
            }
            .legend-toggle i { margin-right:6px }
            .map-legend h4 { margin: 0 0 8px 0; font-size:14px }
            .legend-row { display:flex; align-items:center; gap:8px; margin:6px 0 }
            .legend-swatch { width:16px; height:16px; border-radius:3px; border:1px solid rgba(0,0,0,0.06) }
            /* legend marker visuals */
            .legend-marker { width:18px; height:28px; display:inline-block; vertical-align:middle; margin-right:8px }
            .legend-marker-leaflet { background-image: url('https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png'); background-size: contain; background-repeat: no-repeat; }
            .legend-marker-hospital { width:20px; height:20px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-size:11px; }
            .legend-poi { width:20px; height:20px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-size:11px; margin-right:8px }
            .legend-group { margin-top:8px }
            .legend-group-header { font-weight:700; font-size:13px; color:#0f172a; margin:8px 0 6px }

            /* center zoom control vertically on right */
            .leaflet-top.leaflet-right { top: 50% !important; transform: translateY(-50%); }
    </style>
</head>
<body>
    <!-- Map -->
    <div id="map"></div>

    <!-- Back Button -->
    <button class="back-btn" onclick="window.location.href='/'">
        <i class="fas fa-arrow-left"></i> Kembali
    </button>

    <!-- Control Panel -->
    <div class="control-panel">
        <div class="panel-header">
            <h2><i class="fas fa-map-marked-alt"></i> Peta Pertanahan</h2>
            <p>Kelola data tanah & fasilitas</p>
            <div class="map-search">
                <div class="search-row">
                    <input id="map-search-input" type="text" placeholder="Cari lokasi (mis. 'SMK TI Garuda Nusantara')...">
                    <div id="map-search-results"></div>
                    <button id="map-search-btn" title="Cari"><i class="fas fa-location-arrow"></i></button>
                    <button id="map-refresh-btn" title="Refresh Pencarian"><i class="fas fa-refresh"></i></button>
                </div>
                <div class="nearby-places" id="nearby-places" style="display:none;">
                    <button class="nearby-btn" data-type="restaurant"><i class="fas fa-utensils"></i> Restoran</button>
                    <button class="nearby-btn" data-type="hospital"><i class="fas fa-hospital"></i> Rumah Sakit</button>
                    <button class="nearby-btn" data-type="school"><i class="fas fa-school"></i> Sekolah</button>
                    <button class="nearby-btn" data-type="bank"><i class="fas fa-building-columns"></i> Bank</button>
                    <button class="nearby-btn" data-type="fuel"><i class="fas fa-gas-pump"></i> SPBU</button>
                </div>
            </div>
        </div>
        <div class="panel-content">

            <!-- ========== FORM GAMBAR AREA (HIDDEN DEFAULT) ========== -->
            <div class="form-section" id="form-area">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i> Klik "Gambar Area" lalu buat bentuk di peta
                </div>
                <div class="draw-controls">
                    <button class="draw-btn" onclick="startDrawing()">
                        <i class="fas fa-draw-polygon"></i>
                        <span>Gambar Area</span>
                    </button>
                </div>

                <form id="form-polygon">
                    <input type="hidden" id="polygon_id">
                    <input type="hidden" id="polygon_coordinates">

                    <div class="form-group">
                        <label>Cari Penduduk</label>
                        <input type="text" id="polygon_penduduk" list="penduduk-list" placeholder="NIK / Nama..." required onchange="fillPendudukData()">
                        <datalist id="penduduk-list"></datalist>
                        <input type="hidden" id="polygon_penduduk_id">
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" id="polygon_nik" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Pemilik</label>
                        <input type="text" id="polygon_nama" readonly>
                    </div>
                    <div class="form-group">
                        <label>Luas (m²)</label>
                        <input type="number" step="0.01" id="luas" readonly>
                    </div>
                    <div class="form-group">
                        <label>Luas Detail (m²) <small style="font-weight:600; font-size:12px; color:#64748b;">(Opsional)</small></label>
                        <input type="text" id="luas_detail" placeholder="Masukkan luas detail (opsional)">
                    </div>
                    <div class="form-group">
                        <label>Keperluan</label>
                        <select id="polygon_keperluan" required>
                            <option value="">-- Pilih --</option>
                            <option>Perumahan</option>
                            <option>Pertanian</option>
                            <option>Industri</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group" id="keperluan-manual-group" style="display:none;">
                        <label>Keperluan (Lainnya)</label>
                        <input type="text" id="polygon_keperluan_manual" placeholder="Masukkan keperluan lain...">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select id="polygon_keterangan" required onchange="updatePolygonPreview()">
                            <option value="">-- Pilih --</option>
                            <option>Tanah Permukiman</option>
                            <option>Tanah Pertanian</option>
                            <option>Tanah Perkebunan</option>
                            <option>Tanah Industri</option>
                            <option>Lahan Kosong</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <input type="hidden" id="polygon_warna">

                    <div class="file-upload-section">
                        <label><i class="fas fa-camera"></i> Foto Tanah (Opsional)</label>
                        <input type="file" id="polygon_file" class="file-input" accept=".jpg,.jpeg,.png">
                        <div style="font-size:11px;color:#64748b;margin-top:4px;">JPG/PNG, max 5MB</div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Area
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="hideForm()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </form>
            </div>

            <!-- ========== DAFTAR TANAH ========== -->
            <div class="section-title">
                <i class="fas fa-layer-group"></i> Daftar Tanah
            </div>
            <div class="search-box">
                <input type="text" class="search-input" id="search-polygon" placeholder="Cari NIK / Nama...">
                <i class="fas fa-search search-icon"></i>
            </div>
            <div class="data-count" id="count-polygon"></div>
            <div id="count-hint" style="font-size:12px;color:#64748b;text-align:center;margin-bottom:8px;">Tip: Gunakan kotak pencarian untuk menampilkan item lainnya.</div>
            <div class="data-list" id="list-polygon"></div>
            <button class="btn btn-new" onclick="showForm('create')">
                <i class="fas fa-plus"></i> Buat Area Baru
            </button>
            <div class="load-more-section" id="loadmore-polygon" style="display:none;">
                <button class="btn-load-more" onclick="toggleLoadMore('polygon', this)">
                    <i class="fas fa-chevron-down"></i> Muat Lebih Banyak
                </button>
            </div>

            <!-- Marker list removed (user requested) -->

        </div>
    </div>

    <!-- Loading -->
    <div class="loading-overlay" id="loading">
        <div class="spinner"></div>
    </div>

        <!-- Map Legend (overlay) -->
        <button id="toggle-legend-btn" class="legend-toggle" title="Sembunyikan Legenda">
            <i class="fas fa-book"></i>
        </button>
        <div id="map-legend" class="map-legend" aria-hidden="false">
            <h4>Legenda Peta/Tanda Tanah Peta</h4>
            <div class="legend-row"><div class="legend-swatch" style="background:#ef4444"></div> Tanah Permukiman</div>
            <div class="legend-row"><div class="legend-swatch" style="background:#10b981"></div> Tanah Pertanian</div>
            <div class="legend-row"><div class="legend-swatch" style="background:#1B5E20"></div> Tanah Perkebunan</div>
            <div class="legend-row"><div class="legend-swatch" style="background:#A0522D"></div> Tanah Industri</div>
            <div class="legend-row"><div class="legend-swatch" style="background:#94a3b8"></div> Lahan Kosong</div>
            <div class="legend-row"><div class="legend-swatch" style="background:#64748b"></div> Lainnya</div>

            <hr style="margin:8px 0;">
            <!-- POI legend (grouped, OSM-like categories) -->
            <div class="legend-group">
                <div class="legend-group-header">Kesehatan</div>
                <div class="legend-row"><span class="legend-poi" style="background:#ef4444"><i class="fas fa-hospital" style="font-size:11px"></i></span> Rumah Sakit</div>
                <div class="legend-row"><span class="legend-poi" style="background:#ef4444"><i class="fas fa-clinic-medical" style="font-size:11px"></i></span> Klinik / Puskesmas</div>
                <div class="legend-row"><span class="legend-poi" style="background:#ef4444"><i class="fas fa-prescription-bottle-medical" style="font-size:11px"></i></span> Apotek</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Makanan & Minuman</div>
                <div class="legend-row"><span class="legend-poi" style="background:#f97316"><i class="fas fa-utensils" style="font-size:11px"></i></span> Restoran</div>
                <div class="legend-row"><span class="legend-poi" style="background:#f97316"><i class="fas fa-coffee" style="font-size:11px"></i></span> Kafe</div>
                <div class="legend-row"><span class="legend-poi" style="background:#f97316"><i class="fas fa-bread-slice" style="font-size:11px"></i></span> Toko Roti / Bakery</div>
                <div class="legend-row"><span class="legend-poi" style="background:#fb923c"><i class="fas fa-wine-glass" style="font-size:11px"></i></span> Bar / Pub</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Akomodasi</div>
                <div class="legend-row"><span class="legend-poi" style="background:#7c3aed"><i class="fas fa-bed" style="font-size:11px"></i></span> Hotel / Penginapan</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Pendidikan & Budaya</div>
                <div class="legend-row"><span class="legend-poi" style="background:#2563eb"><i class="fas fa-school" style="font-size:11px"></i></span> Sekolah</div>
                <div class="legend-row"><span class="legend-poi" style="background:#0ea5a4"><i class="fas fa-book" style="font-size:11px"></i></span> Perpustakaan</div>
                <div class="legend-row"><span class="legend-poi" style="background:#ef4444"><i class="fas fa-landmark" style="font-size:11px"></i></span> Museum</div>
                <div class="legend-row"><span class="legend-poi" style="background:#ef4444"><i class="fas fa-film" style="font-size:11px"></i></span> Bioskop / Teater</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Transportasi</div>
                <div class="legend-row"><span class="legend-poi" style="background:#06b6d4"><i class="fas fa-bus" style="font-size:11px"></i></span> Halte Bus</div>
                <div class="legend-row"><span class="legend-poi" style="background:#06b6d4"><i class="fas fa-train" style="font-size:11px"></i></span> Stasiun Kereta</div>
                <div class="legend-row"><span class="legend-poi" style="background:#94a3b8"><i class="fas fa-parking" style="font-size:11px"></i></span> Parkir</div>
                <div class="legend-row"><span class="legend-poi" style="background:#f97316"><i class="fas fa-gas-pump" style="font-size:11px"></i></span> Pom Bensin</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Perdagangan & Layanan</div>
                <div class="legend-row"><span class="legend-poi" style="background:#16a34a"><i class="fas fa-shopping-bag" style="font-size:11px"></i></span> Toko</div>
                <div class="legend-row"><span class="legend-poi" style="background:#16a34a"><i class="fas fa-store" style="font-size:11px"></i></span> Supermarket</div>
                <div class="legend-row"><span class="legend-poi" style="background:#0f172a"><i class="fas fa-building-columns" style="font-size:11px"></i></span> Bank</div>
                <div class="legend-row"><span class="legend-poi" style="background:#f59e0b"><i class="fas fa-shop" style="font-size:11px"></i></span> Pasar / Bazaar</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Layanan Publik & Keamanan</div>
                <div class="legend-row"><span class="legend-poi" style="background:#0ea5a4"><i class="fas fa-shield-alt" style="font-size:11px"></i></span> Kepolisian</div>
                <div class="legend-row"><span class="legend-poi" style="background:#0ea5a4"><i class="fas fa-envelope" style="font-size:11px"></i></span> Kantor Pos</div>
                <div class="legend-row"><span class="legend-poi" style="background:#374151"><i class="fas fa-landmark" style="font-size:11px"></i></span> Gedung Pemerintah</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Tempat Ibadah</div>
                <div class="legend-row"><span class="legend-poi" style="background:#7f1d1d"><i class="fas fa-place-of-worship" style="font-size:11px"></i></span> Rumah Ibadah</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Rekreasi & Olahraga</div>
                <div class="legend-row"><span class="legend-poi" style="background:#059669"><i class="fas fa-football-ball" style="font-size:11px"></i></span> Stadion / Lapangan Olahraga</div>
                <div class="legend-row"><span class="legend-poi" style="background:#059669"><i class="fas fa-tree" style="font-size:11px"></i></span> Taman</div>
            </div>
            <div class="legend-group">
                <div class="legend-group-header">Lainnya</div>
                <div class="legend-row"><span style="display:inline-block;width:10px;height:10px;background:#94a3b8;margin-right:8px;border-radius:2px"></span> Lainnya (ikon sesuai OSM)</div>
            </div>
        </div>

 <!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<script>
    const kategoriColors = {
        "Tanah Permukiman": "#ef4444",
        "Tanah Pertanian": "#10b981",
        "Tanah Perkebunan": "#1B5E20",
        "Tanah Industri": "#A0522D",
        "Lahan Kosong": "#94a3b8",
        "Lainnya": "#64748b"
    };

    let dataStore = { penduduk: [], polygon: [], marker: [] };
    let displayState = {
        // default show 3 items in polygon list (per user request)
        polygon: { shown: 3, search: '', isSearching: false },
        marker: { shown: 5, search: '', isSearching: false }
    };

    // MAP dengan ZOOM di KANAN
    const map = L.map('map', {
        zoomControl: false
    }).setView([-6.9175, 107.6191], 15);
    
    // ✅ ZOOM CONTROL DI KANAN ATAS
    L.control.zoom({
        position: 'topright'
    }).addTo(map);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // center the zoom control vertically on the right side
    // We'll adjust CSS for the zoom control below (in style block)

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const polygonLayer = L.layerGroup().addTo(map);
    const markerLayer = L.layerGroup().addTo(map);

    let currentDrawing = null;
    let tempDrawLayer = null;
    let nearbyLayer = L.layerGroup().addTo(map);
    let currentNearbyType = null;

    // Init
    document.addEventListener('DOMContentLoaded', () => {
        console.log('🚀 Sistem dimulai...');
        loadPendudukList();
        setupSearchListeners();
        setupLuasInputs();
        setupNearbyPlaces();
        loadAllData();
        // show legend button initial state
    });

    // ✅ SETUP INPUT LUAS - ADA 2 FIELD SEKARANG!
    function setupLuasInputs() {
        // Field Luas Otomatis (readonly, dari gambar polygon)
        const luasAuto = document.getElementById('luas');
        if (luasAuto) {
            luasAuto.readOnly = true;
            luasAuto.style.backgroundColor = '#f3f4f6';
            luasAuto.placeholder = "Otomatis dari gambar polygon";
        }

        // Field Luas Detail Manual (opsional, user bisa ketik)
        const luasDetail = document.getElementById('luas_detail');
        if (luasDetail) {
            luasDetail.readOnly = false;
            luasDetail.placeholder = "Masukkan luas detail (opsional)";
            
            luasDetail.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9.,]/g, '');
            });

            // Tambah hint
            const parent = luasDetail.parentElement;
            let hint = parent.querySelector('.luas-hint');
            if (!hint) {
                hint = document.createElement('small');
                hint.className = 'luas-hint';
                hint.style.cssText = 'display:block; color:#94a3b8; margin-top:4px; font-size:12px;';
                hint.innerHTML = '💡 Isi manual jika ada pengukuran detail yang berbeda';
                parent.appendChild(hint);
            }
        }

        console.log('✅ Input luas sudah setup (otomatis + detail opsional)');
        // Setup manual keperluan input show/hide when user picks 'Lainnya'
        const keperluanSelect = document.getElementById('polygon_keperluan');
        const manualGroup = document.getElementById('keperluan-manual-group');
        const manualInput = document.getElementById('polygon_keperluan_manual');
        if (keperluanSelect) {
            const toggleManual = () => {
                if (keperluanSelect.value === 'Lainnya') {
                    if (manualGroup) manualGroup.style.display = 'block';
                } else {
                    if (manualGroup) manualGroup.style.display = 'none';
                    if (manualInput) manualInput.value = '';
                }
            };
            keperluanSelect.addEventListener('change', toggleManual);
            // initial state
            toggleManual();
        }
    }

    // Show/Hide Form
    function showForm(mode = 'create', item = null) {
        const form = document.getElementById('form-area');
        form.classList.add('active');
        resetForm('polygon');
        
        if (mode === 'edit' && item) {
            console.log('✏️ EDIT MODE - Item:', item);
            document.getElementById('polygon_id').value = item.id || '';
            document.getElementById('polygon_penduduk_id').value = item.penduduk_id || '';
            
            // Set input penduduk (autocomplete)
            const pendudukInput = document.getElementById('polygon_penduduk');
            if (pendudukInput && item.nama && item.nik) {
                pendudukInput.value = `${item.nama} (${item.nik})`;
            }
            
            document.getElementById('polygon_coordinates').value = item.coordinates || '';
            document.getElementById('luas').value = item.luas || '';
            document.getElementById('luas_detail').value = item.luas_detail || '';
            // handle keperluan + manual keperluan
            const keperluanSelect = document.getElementById('polygon_keperluan');
            const manualGroup = document.getElementById('keperluan-manual-group');
            const manualInput = document.getElementById('polygon_keperluan_manual');
            if (keperluanSelect) {
                // if the stored keperluan is not one of the select options, treat it as manual
                const opts = Array.from(keperluanSelect.options).map(o => o.value);
                if (item.keperluan && !opts.includes(item.keperluan)) {
                    keperluanSelect.value = 'Lainnya';
                    if (manualGroup) manualGroup.style.display = 'block';
                    if (manualInput) manualInput.value = item.keperluan;
                } else {
                    keperluanSelect.value = item.keperluan || '';
                    if (manualGroup) manualGroup.style.display = 'none';
                    if (manualInput) manualInput.value = '';
                }
            }
            document.getElementById('polygon_keterangan').value = item.keterangan || '';
            document.getElementById('polygon_warna').value = item.warna || '#94a3b8';
            
            // Tampilkan di peta
            if (item.coordinates) {
                try {
                    const coords = (typeof item.coordinates === 'string') ? JSON.parse(item.coordinates) : item.coordinates;
                    if (tempDrawLayer) map.removeLayer(tempDrawLayer);
                    tempDrawLayer = L.polygon(coords, { 
                        color: item.warna || '#94a3b8', 
                        fillOpacity: 0.4, 
                        dashArray: '10,10',
                        weight: 3
                    }).addTo(map);
                    map.fitBounds(tempDrawLayer.getBounds());
                } catch (e) {
                    console.error('Error parsing coordinates:', e);
                }
            }
        }
        
        document.getElementById('form-polygon')?.scrollIntoView({ behavior: 'smooth' });
    }

    function hideForm() {
        document.getElementById('form-area')?.classList.remove('active');
        resetForm('polygon');
    }

    // Search
    function setupSearchListeners() {
        ['polygon', 'marker'].forEach(type => {
            const input = document.getElementById(`search-${type}`);
            if (input) {
                input.addEventListener('input', (e) => {
                    const val = e.target.value.trim().toLowerCase();
                    displayState[type].search = val;
                    displayState[type].isSearching = val.length > 0;
                    // when searching, reset shown to a small default (3 for polygon)
                    displayState[type].shown = (type === 'polygon') ? 3 : 5;
                    renderList(type);
                });
            }
        });
    }

    // Render List
    function renderList(type) {
        const list = document.getElementById(`list-${type}`);
        const count = document.getElementById(`count-${type}`);
        const loadmore = document.getElementById(`loadmore-${type}`);
        
        if (!list) return;
        
        const filtered = filterData(type);
        const shown = displayState[type].shown;

        list.innerHTML = '';
        if (filtered.length === 0) {
            list.innerHTML = `<div class="no-data">📂 Belum ada data polygon</div>`;
            if (count) count.textContent = '';
            if (loadmore) loadmore.style.display = 'none';
            return;
        }

        const toShow = filtered.slice(0, shown);
        if (count) count.textContent = `Menampilkan ${toShow.length} dari ${filtered.length}`;
        toShow.forEach(item => list.appendChild(createListItem(type, item)));
        if (loadmore) {
            const moreBtn = loadmore.querySelector('.btn-load-more');
            if (toShow.length < filtered.length) {
                loadmore.style.display = 'block';
                if (moreBtn) moreBtn.innerHTML = `<i class="fas fa-chevron-down"></i> Muat Lebih Banyak`;
            } else if (filtered.length > ((type === 'polygon') ? 3 : 5)) {
                // if showing all, offer "Sembunyikan"
                loadmore.style.display = 'block';
                if (moreBtn) moreBtn.innerHTML = `<i class="fas fa-chevron-up"></i> Sembunyikan`;
            } else {
                loadmore.style.display = 'none';
            }
        }
    }

    // Toggle load more / hide for lists
    function toggleLoadMore(type, btn) {
        const filtered = filterData(type);
        if (!filtered || filtered.length === 0) return;
        const currentShown = displayState[type].shown;
        const defaultShown = (type === 'polygon') ? 3 : 5;
        if (currentShown < filtered.length) {
            // show all
            displayState[type].shown = filtered.length;
            if (btn) btn.innerHTML = `<i class="fas fa-chevron-up"></i> Sembunyikan`;
        } else {
            // hide back to default
            displayState[type].shown = defaultShown;
            if (btn) btn.innerHTML = `<i class="fas fa-chevron-down"></i> Muat Lebih Banyak`;
            // ensure scroll to top of list
            const list = document.getElementById(`list-${type}`);
            if (list) list.scrollTop = 0;
        }
        renderList(type);
    }

    function filterData(type) {
        const search = displayState[type].search;
        if (!search) return dataStore[type];
        return dataStore[type].filter(item => {
            if (type === 'polygon') {
                const nama = (item.nama || '').toLowerCase();
                const nik = (item.nik || '').toLowerCase();
                const keperluan = (item.keperluan || '').toLowerCase();
                return nama.includes(search) || nik.includes(search) || keperluan.includes(search);
            }
            return (item.nama || '').toLowerCase().includes(search);
        });
    }

    function createListItem(type, item) {
        const div = document.createElement('div');
        div.className = 'data-item';
        
        if (type === 'polygon') {
            div.onclick = () => viewPolygon(item.id);
            
            // Store item in global scope untuk onclick
            window[`polygonItem${item.id}`] = item;
            
            const luasDisplay = item.luas_detail ? `${item.luas_detail} m² (detail)` : `${item.luas} m²`;
            
            div.innerHTML = `
                <div class="data-item-header">
                    <div class="data-item-title">${item.nama || item.keperluan || 'Tanah'}</div>
                    <div class="data-item-actions">
                        <button class="btn-icon edit" onclick="event.stopPropagation(); showForm('edit', window.polygonItem${item.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon delete" onclick="event.stopPropagation(); deletePolygon(${item.id})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="data-item-info">
                    <strong>NIK:</strong> ${item.nik || '-'} | 
                    <strong>Luas:</strong> ${luasDisplay} | 
                    <strong>Kategori:</strong> ${item.keterangan || '-'}
                </div>
            `;
        }
        return div;
    }

    function loadMoreData(type) {
        displayState[type].shown += 5;
        renderList(type);
    }

    // Drawing
    function startDrawing() {
        if (tempDrawLayer) { map.removeLayer(tempDrawLayer); tempDrawLayer = null; }
        if (currentDrawing) currentDrawing.disable();

        currentDrawing = new L.Draw.Polygon(map, { 
            shapeOptions: { color: '#3b82f6', fillOpacity: 0.3, weight: 3 }, 
            showArea: true 
        });
        currentDrawing.enable();
        
        console.log('🖊️ Mode gambar aktif');
    }

    function stopDrawing() {
        if (currentDrawing) {
            currentDrawing.disable();
            currentDrawing = null;
        }
    }

    map.on(L.Draw.Event.CREATED, function(e) {
        const layer = e.layer;
        if (tempDrawLayer) map.removeLayer(tempDrawLayer);
        
        const coords = layer.getLatLngs()[0].map(ll => [ll.lat, ll.lng]);
        const coordsStr = JSON.stringify(coords);
        document.getElementById('polygon_coordinates').value = coordsStr;
        
        // Hitung luas otomatis
        const area = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]).toFixed(2);
        document.getElementById('luas').value = area;
        
        console.log('✅ Polygon digambar! Luas otomatis:', area, 'm²');

        const color = document.getElementById('polygon_warna')?.value || '#94a3b8';
        tempDrawLayer = L.polygon(coords, { 
            color: color, 
            fillOpacity: 0.4, 
            dashArray: '10,10',
            weight: 3
        }).addTo(map);
        
        tempDrawLayer.bindPopup(`
            <strong>Preview Polygon</strong><br>
            Luas Otomatis: ${area} m²<br>
            <small>Anda bisa isi Luas Detail secara manual di form</small>
        `).openPopup();
        
        stopDrawing();
    });

    // 🔥 FORM SUBMIT - FIXED UNTUK DATABASE (TANPA FILE)
    const formPolygon = document.getElementById('form-polygon');
    if (formPolygon) {
        formPolygon.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            console.log('');
            console.log('='.repeat(60));
            console.log('🚀 MULAI PROSES SUBMIT POLYGON');
            console.log('='.repeat(60));
            
            const id = document.getElementById('polygon_id')?.value.trim() || '';
            const coords = document.getElementById('polygon_coordinates')?.value.trim() || '';
            const pendudukId = document.getElementById('polygon_penduduk_id')?.value.trim() || '';
            const nik = document.getElementById('polygon_nik')?.value.trim() || '';
            const luasAuto = document.getElementById('luas')?.value.trim() || '';
            const luasDetail = document.getElementById('luas_detail')?.value.trim() || '';
            // keperluan: prefer manual input when 'Lainnya' is selected
            const _keperluanSelect = document.getElementById('polygon_keperluan')?.value.trim() || '';
            const _keperluanManual = document.getElementById('polygon_keperluan_manual')?.value.trim() || '';
            const keperluan = (_keperluanSelect === 'Lainnya' && _keperluanManual) ? _keperluanManual : (_keperluanSelect || 'Tidak disebutkan');
            const keterangan = document.getElementById('polygon_keterangan')?.value.trim() || '';
            const warna = document.getElementById('polygon_warna')?.value.trim() || '#94a3b8';
            const nama = document.getElementById('polygon_nama')?.value.trim() || '';
            
            // VALIDASI
            if (!coords) {
                alert('⚠️ Gambar polygon dulu di peta!');
                return;
            }
            if (!pendudukId) {
                alert('⚠️ Pilih penduduk terlebih dahulu!');
                return;
            }
            if (!nama) {
                alert('⚠️ Nama pemilik belum terisi! Pilih penduduk dulu.');
                return;
            }
            if (!luasAuto || parseFloat(luasAuto) <= 0) {
                alert('⚠️ Luas otomatis belum terisi! Gambar polygon dulu.');
                return;
            }

            // ✅ KIRIM DATA PAKAI JSON (BUKAN FormData)
                const payload = {
                    nama: nama,
                    penduduk_id: parseInt(pendudukId),
                    nik: nik,
                    coordinates: coords,
                    luas: parseFloat(luasAuto.replace(',', '.')),
                    luas_detail: luasDetail ? parseFloat(luasDetail.replace(',', '.')) : null,
                    keperluan: keperluan || 'Tidak disebutkan',
                    keterangan: keterangan || 'Lainnya',
                    warna: warna
                };

            console.log('📦 Data yang dikirim:');
            console.log('   Mode:', id ? 'UPDATE (ID: ' + id + ')' : 'CREATE (NEW)');
            console.log('   Penduduk ID:', payload.penduduk_id);
            console.log('   Luas Otomatis:', payload.luas, 'm²');
            console.log('   Luas Detail:', payload.luas_detail || '(tidak diisi)');
            console.log('   Keperluan:', payload.keperluan);
            console.log('   Kategori:', payload.keterangan);
            console.log('   Warna:', payload.warna);

            try {
                showLoading(true);

                // URL dan Method (default)
                const url = id ? `/polygon/polygon/${id}` : '/polygon/polygon';
                const method = id ? 'PUT' : 'POST';

                // Jika user memilih file, kirim sebagai FormData (multipart)
                const fileInput = document.getElementById('polygon_file');
                const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;

                let fetchUrl = url;
                let fetchMethod = method;
                let fetchOptions = {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                };

                if (hasFile) {
                    // Untuk upload file kita gunakan FormData. Beberapa server/PHP tidak
                    // mem-parsing file pada PUT, jadi gunakan POST + _method=PUT untuk update.
                    const form = new FormData();
                    // include required 'nama' for Laravel validation
                    form.append('nama', payload.nama);
                    form.append('penduduk_id', payload.penduduk_id);
                    form.append('nik', payload.nik);
                    // Pastikan coordinates dikirim sebagai JSON string
                    try {
                        const coordsArr = typeof coords === 'string' ? JSON.parse(coords) : coords;
                        form.append('coordinates', JSON.stringify(coordsArr));
                    } catch (e) {
                        form.append('coordinates', coords);
                    }
                    form.append('luas', payload.luas);
                    if (payload.luas_detail !== null) form.append('luas_detail', payload.luas_detail);
                    form.append('keperluan', payload.keperluan);
                    form.append('keterangan', payload.keterangan);
                    form.append('warna', payload.warna);
                    form.append('file', fileInput.files[0]);

                    if (id) {
                        // override method for Laravel when updating with multipart
                        form.append('_method', 'PUT');
                        fetchMethod = 'POST';
                    } else {
                        fetchMethod = 'POST';
                    }

                    fetchOptions.method = fetchMethod;
                    fetchOptions.body = form;

                    console.log('');
                    console.log('📡 Request Details:');
                    console.log('   URL:', fetchUrl);
                    console.log('   Method:', fetchMethod, hasFile ? '(multipart/form-data)' : '');
                } else {
                    // Kirim JSON biasa
                    fetchOptions.method = method;
                    fetchOptions.headers['Content-Type'] = 'application/json';
                    fetchOptions.body = JSON.stringify(payload);

                    console.log('');
                    console.log('📡 Request Details:');
                    console.log('   URL:', fetchUrl);
                    console.log('   Method:', fetchOptions.method);
                    console.log('   Content-Type: application/json');
                }

                const response = await fetch(fetchUrl, fetchOptions);

                console.log('');
                console.log('📥 Response:', response.status, response.statusText);

                if (response.ok) {
                    const result = await response.json().catch(() => ({}));
                    console.log('✅ Response Data:', result);
                    console.log('');
                    console.log('🎉 BERHASIL! Data', id ? 'diupdate' : 'disimpan', 'ke database!');
                    console.log('='.repeat(60));
                    
                    const luasDetailText = payload.luas_detail ? `\nLuas Detail: ${payload.luas_detail} m² (manual)` : '';
                    const successMsg = `✅ BERHASIL ${id ? 'UPDATE' : 'SIMPAN'}!\n\n` +
                        `Keperluan: ${keperluan}\n` +
                        `Luas Otomatis: ${payload.luas} m²${luasDetailText}\n` +
                        `Kategori: ${keterangan}`;
                    
                    alert(successMsg);
                    
                    hideForm();
                    await loadPolygon();
                    
                } else {
                    const errorText = await response.text();
                    console.error('❌ Response Error:', errorText);
                    console.log('='.repeat(60));
                    
                    let errorMsg = `Gagal ${id ? 'update' : 'menyimpan'} data`;
                    try {
                        const errorJson = JSON.parse(errorText);
                        if (errorJson.message) {
                            errorMsg = errorJson.message;
                        }
                        if (errorJson.errors) {
                            const errors = Object.entries(errorJson.errors)
                                .map(([field, msgs]) => `${field}: ${Array.isArray(msgs) ? msgs.join(', ') : msgs}`)
                                .join('\n');
                            errorMsg += '\n\nDetail error:\n' + errors;
                        }
                    } catch (e) {
                        if (errorText.includes('required') || errorText.includes('validation')) {
                            errorMsg += '\n\nKemungkinan ada field yang belum diisi dengan benar.';
                        }
                        errorMsg += '\n\nResponse: ' + errorText.substring(0, 300);
                    }
                    
                    alert('❌ ' + errorMsg);
                }

            } catch (err) { 
                console.error('💥 FATAL ERROR:', err);
                console.log('='.repeat(60));
                alert('⚠️ Error koneksi ke server!\n\nDetail: ' + err.message + '\n\nCek console untuk info lengkap.');
            } finally { 
                showLoading(false); 
            }
        });
    }

    // Load Polygon dari Database
    async function loadPolygon() {
        console.log('');
        console.log('📥 Loading data polygon dari database...');
        
        try {
            const response = await fetch('/polygon/polygon', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            console.log('✅ Berhasil load', data.length, 'polygon dari database');
            
            // Simpan ke store
            dataStore.polygon = Array.isArray(data) ? data : [];
            
            // Clear layer lama
            polygonLayer.clearLayers();
            
            // Render setiap polygon ke peta
            dataStore.polygon.forEach((item, idx) => {
                try {
                    const coords = (typeof item.coordinates === 'string') ? JSON.parse(item.coordinates) : item.coordinates;
                    const poly = L.polygon(coords, { 
                        color: item.warna || '#94a3b8', 
                        fillOpacity: 0.5,
                        weight: 2
                    }).addTo(polygonLayer);
                    
                    const luasDisplay = item.luas_detail 
                        ? `${item.luas_detail} m² (detail)` 
                        : `${item.luas} m²`;

                    // bind popup only if area info display is enabled
                    if (window.showAreaInfo === undefined || window.showAreaInfo === true) {
                        poly.bindPopup(`
                            <div style="min-width:200px;">
                                <strong style="font-size:14px;">${item.nama || item.keperluan || 'Tanah'}</strong><br>
                                <hr style="margin:5px 0;">
                                <strong>NIK:</strong> ${item.nik || '-'}<br>
                                <strong>Keperluan:</strong> ${item.keperluan || '-'}<br>
                                <strong>Kategori:</strong> ${item.keterangan || '-'}<br>
                                <strong>Luas Otomatis:</strong> ${item.luas} m²<br>
                                ${item.luas_detail ? `<strong>Luas Detail:</strong> ${item.luas_detail} m² (manual)<br>` : ''}
                            </div>
                        `);
                    }
                    
                    console.log(`   ✓ Polygon #${idx + 1}: ${item.nama || item.keperluan}`);
                } catch (e) {
                    console.error(`   ✗ Error render polygon #${idx + 1}:`, e);
                }
            });
            
            // Render list sidebar
            renderList('polygon');
            
            console.log('✅ Semua polygon berhasil ditampilkan');
            
        } catch (err) {
            console.error('❌ Load polygon error:', err);
            dataStore.polygon = [];
            renderList('polygon');
        }
    }

    function viewPolygon(id) {
        const item = dataStore.polygon.find(p => p.id == id);
        if (item && item.coordinates) {
            try {
                const coords = (typeof item.coordinates === 'string') ? JSON.parse(item.coordinates) : item.coordinates;
                map.fitBounds(L.latLngBounds(coords));
                
                // Buka popup
                polygonLayer.eachLayer(layer => {
                    if (layer.getLatLngs) {
                        const layerCoords = JSON.stringify(layer.getLatLngs()[0].map(ll => [ll.lat, ll.lng]));
                        const itemCoordsStr = (typeof item.coordinates === 'string') ? item.coordinates : JSON.stringify(item.coordinates);
                        if (layerCoords === itemCoordsStr) {
                            layer.openPopup();
                        }
                    }
                });
            } catch (e) {
                console.error('View polygon error:', e);
            }
        }
    }

    async function deletePolygon(id) {
        if (!confirm('⚠️ Yakin hapus polygon ini?\n\nData yang dihapus tidak bisa dikembalikan!')) return;
        
        console.log('🗑️ Menghapus polygon ID:', id);
        
        try {
            showLoading(true);
            
            const response = await fetch(`/polygon/polygon/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                console.log('✅ Delete berhasil!');
                alert('✅ Polygon berhasil dihapus dari database!');
                await loadPolygon();
            } else {
                const errorText = await response.text();
                console.error('❌ Delete gagal:', errorText);
                alert('❌ Gagal menghapus polygon\n\n' + errorText.substring(0, 200));
            }
        } catch (err) {
            console.error('💥 Delete error:', err);
            alert('⚠️ Error: ' + err.message);
        } finally {
            showLoading(false);
        }
    }

    function updatePolygonPreview() {
        const kat = document.getElementById('polygon_keterangan')?.value;
        const color = kategoriColors[kat] || '#94a3b8';
        const warnaInput = document.getElementById('polygon_warna');
        if (warnaInput) warnaInput.value = color;
        if (tempDrawLayer) {
            tempDrawLayer.setStyle({ color, fillColor: color });
        }
    }

    function resetForm(type) {
        const form = document.getElementById(`form-${type}`);
        if (form) form.reset();
        
        const idField = document.getElementById(`${type}_id`);
        if (idField) idField.value = '';
        
        if (type === 'polygon') {
            const coordsField = document.getElementById('polygon_coordinates');
            const pendudukIdField = document.getElementById('polygon_penduduk_id');
            const pendudukInput = document.getElementById('polygon_penduduk');
            const luasField = document.getElementById('luas');
            const luasDetailField = document.getElementById('luas_detail');
            
            if (coordsField) coordsField.value = '';
            if (pendudukIdField) pendudukIdField.value = '';
            if (pendudukInput) pendudukInput.value = '';
            if (luasField) luasField.value = '';
            if (luasDetailField) luasDetailField.value = '';
            // clear manual keperluan
            const manualGroup = document.getElementById('keperluan-manual-group');
            const manualInput = document.getElementById('polygon_keperluan_manual');
            const keperluanSelect = document.getElementById('polygon_keperluan');
            if (manualGroup) manualGroup.style.display = 'none';
            if (manualInput) manualInput.value = '';
            if (keperluanSelect) keperluanSelect.value = '';
            
            if (tempDrawLayer) { 
                map.removeLayer(tempDrawLayer); 
                tempDrawLayer = null; 
            }
        }
        stopDrawing();
    }

    function showLoading(show) {
        const loading = document.getElementById('loading');
        if (loading) {
            loading.classList.toggle('active', show);
        }
    }

    // Geometry Util
    L.GeometryUtil = L.extend(L.GeometryUtil || {}, {
        geodesicArea: function (latLngs) {
            let area = 0;
            const len = latLngs.length;
            if (len > 2) {
                for (let i = 0; i < len; i++) {
                    const p1 = latLngs[i], p2 = latLngs[(i + 1) % len];
                    area += (p2.lng - p1.lng) * (2 + Math.sin(p1.lat * Math.PI / 180) + Math.sin(p2.lat * Math.PI / 180));
                }
                area = area * 6378137 * 6378137 / 2;
            }
            return Math.abs(area);
        }
    });

    async function loadAllData() {
        await loadPolygon();
    }

    async function loadPendudukList() {
        console.log('👥 Loading daftar penduduk...');
        try {
            const res = await fetch('/penduduk/penduduk', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!res.ok) throw new Error('HTTP ' + res.status);
            
            const data = await res.json();
            dataStore.penduduk = data;
            console.log('✅ Berhasil load', data.length, 'penduduk');
            
            const dl = document.getElementById('penduduk-list');
            if (dl) {
                dl.innerHTML = '';
                data.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = `${p.nama} (${p.nik})`;
                    dl.appendChild(opt);
                });
            }
        } catch (err) {
            console.error('❌ Load penduduk error:', err);
        }
    }

    // -----------------------------
    // Map Geocoding Search (Nominatim)
    // -----------------------------
    let searchMarker = null;
    async function geocodeQuery(q) {
        if (!q || q.trim().length === 0) return [];
        try {
            const url = `https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&limit=8&q=${encodeURIComponent(q)}`;
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return [];
            const data = await res.json();
            return data;
        } catch (e) {
            console.error('Geocode error:', e);
            return [];
        }
    }

    function renderMapSearchResults(results) {
        const container = document.getElementById('map-search-results');
        container.innerHTML = '';
        if (!results || results.length === 0) return;
        const box = document.createElement('div');
        box.className = 'results';
        results.forEach(r => {
            const item = document.createElement('div');
            item.className = 'result-item';
            item.innerHTML = `<strong>${r.display_name.split(',')[0]}</strong><br><small style="color:#64748b">${r.display_name}</small>`;
            item.onclick = () => {
                // zoom to location and show marker
                const lat = parseFloat(r.lat);
                const lon = parseFloat(r.lon);
                map.setView([lat, lon], 18);
                if (searchMarker) map.removeLayer(searchMarker);
                searchMarker = L.marker([lat, lon]).addTo(map);
                searchMarker.bindPopup(`<strong>${r.display_name}</strong>`).openPopup();
                container.innerHTML = '';
            };
            box.appendChild(item);
        });
        container.appendChild(box);
    }

    function clearMapSearchResults() {
        const container = document.getElementById('map-search-results');
        if (container) container.innerHTML = '';
    }

    // hook search input
    (function setupMapSearch() {
        const input = document.getElementById('map-search-input');
        const btn = document.getElementById('map-search-btn');
        const refreshBtn = document.getElementById('map-refresh-btn');
        const legendBtn = document.getElementById('toggle-legend-btn');
        const legend = document.getElementById('map-legend');
        const container = document.getElementById('map-search-results');

        if (legendBtn && legend) {
            // initialize legend visible state
            legend.style.display = 'block';
            legendBtn.title = 'Sembunyikan Legenda';
            legendBtn.addEventListener('click', () => {
                if (legend.style.display === 'none') {
                    legend.style.display = 'block';
                    legendBtn.title = 'Sembunyikan Legenda';
                } else {
                    legend.style.display = 'none';
                    legendBtn.title = 'Tampilkan Legenda';
                }
            });
        }

        if (!input) return;
        let debounceTimer = null;
        let currentResults = [];
        let selectedIndex = -1;

        input.addEventListener('keydown', (e) => {
            if (currentResults.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, currentResults.length - 1);
                updateSelection();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, -1);
                updateSelection();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (selectedIndex >= 0 && selectedIndex < currentResults.length) {
                    chooseResult(currentResults[selectedIndex]);
                } else if (currentResults.length > 0) {
                    chooseResult(currentResults[0]);
                }
            }
        });

        input.addEventListener('input', (e) => {
            const q = e.target.value.trim();
            selectedIndex = -1;
            if (debounceTimer) clearTimeout(debounceTimer);
            debounceTimer = setTimeout(async () => {
                if (q.length < 2) { clearMapSearchResults(); currentResults = []; return; }
                const res = await geocodeQuery(q);
                currentResults = res;
                renderMapSearchResults(res);
            }, 300); // Faster response
        });

        btn.addEventListener('click', async () => {
            const q = input.value.trim();
            if (!q) return alert('Masukkan kata kunci pencarian terlebih dahulu');
            const res = await geocodeQuery(q);
            currentResults = res;
            if (!res || res.length === 0) return alert('Lokasi tidak ditemukan');
            chooseResult(res[0]);
            renderMapSearchResults(res);
        });

        refreshBtn.addEventListener('click', () => {
            // Clear search input
            input.value = '';
            // Clear results
            container.innerHTML = '';
            // Remove search marker
            if (searchMarker) {
                map.removeLayer(searchMarker);
                searchMarker = null;
            }
            // Hide nearby places
            const nearbyDiv = document.getElementById('nearby-places');
            if (nearbyDiv) nearbyDiv.style.display = 'none';
            // Clear nearby layer
            nearbyLayer.clearLayers();
            currentNearbyType = null;
            // Reset nearby buttons
            const buttons = document.querySelectorAll('.nearby-btn');
            buttons.forEach(b => b.classList.remove('active'));
            // Reset map view to initial
            map.setView([-6.9175, 107.6191], 15);
        });

        // click outside to clear
        document.addEventListener('click', (ev) => {
            const container = document.getElementById('map-search-results');
            const target = ev.target;
            if (!container) return;
            if (!container.contains(target) && target !== input && target !== btn) {
                container.innerHTML = '';
            }
        });

        function updateSelection() {
            const items = container.querySelectorAll('.result-item');
            items.forEach((item, idx) => {
                if (idx === selectedIndex) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });
        }

        function chooseResult(r) {
            autoZoomTo(r);
            container.innerHTML = '';
            currentResults = [];
            selectedIndex = -1;
            // Show nearby places after search
            const nearbyDiv = document.getElementById('nearby-places');
            if (nearbyDiv) nearbyDiv.style.display = 'flex';
        }

        function autoZoomTo(r) {
            if (!r) return;
            try {
                const lat = parseFloat(r.lat);
                const lon = parseFloat(r.lon);
                map.setView([lat, lon], 18);
                if (searchMarker) map.removeLayer(searchMarker);
                searchMarker = L.marker([lat, lon]).addTo(map);
                searchMarker.bindPopup(`<strong>${r.display_name}</strong>`).openPopup();
            } catch (e) { console.error('Auto zoom error', e); }
        }
    })();

    function fillPendudukData() {
        const val = document.getElementById('polygon_penduduk')?.value;
        const p = dataStore.penduduk.find(x => `${x.nama} (${x.nik})` === val);
        
        if (p) {
            const pendudukIdField = document.getElementById('polygon_penduduk_id');
            if (pendudukIdField) pendudukIdField.value = p.id;
            console.log('✓ Penduduk dipilih:', p.nama, '(ID:', p.id, ')');
            
            const nikField = document.getElementById('polygon_nik');
            const namaField = document.getElementById('polygon_nama');
            
            if (nikField) nikField.value = p.nik;
            if (namaField) namaField.value = p.nama;
        }
    }

    // Event listeners
    const keteranganSelect = document.getElementById('polygon_keterangan');
    if (keteranganSelect) {
        keteranganSelect.addEventListener('change', updatePolygonPreview);
    }

    console.log('');
    console.log('='.repeat(60));
    console.log('🗺️ POLYGON MAP SYSTEM READY!');
    console.log('='.repeat(60));
    console.log('✅ Fitur Aktif:');
    console.log('   📍 Zoom control: Kanan atas');
    console.log('   📏 Luas otomatis: Dari polygon');
    console.log('   ✏️  Luas detail: Manual opsional');
    console.log('   💾 Database: Save/Update/Delete');
    console.log('   🔍 Search: Nama, NIK, Keperluan');
    console.log('='.repeat(60));

    // Nearby places functionality
    function setupNearbyPlaces() {
        const buttons = document.querySelectorAll('.nearby-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                if (currentNearbyType === type) {
                    // Toggle off if same type
                    nearbyLayer.clearLayers();
                    currentNearbyType = null;
                    buttons.forEach(b => b.classList.remove('active'));
                } else {
                    // Switch to new type
                    currentNearbyType = type;
                    buttons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    fetchNearbyPlaces(type);
                }
            });
        });
    }

    async function fetchNearbyPlaces(type) {
        const center = map.getCenter();
        const radius = 1000; // 1km radius

        const overpassQuery = `
            [out:json][timeout:25];
            (
                node["amenity"="${type}"](around:${radius},${center.lat},${center.lng});
                way["amenity"="${type}"](around:${radius},${center.lat},${center.lng});
                relation["amenity"="${type}"](around:${radius},${center.lat},${center.lng});
            );
            out center;
        `;

        try {
            const response = await fetch('https://overpass-api.de/api/interpreter', {
                method: 'POST',
                body: overpassQuery
            });

            if (!response.ok) throw new Error('Overpass API error');

            const data = await response.json();
            displayNearbyPlaces(data.elements, type);
        } catch (error) {
            console.error('Error fetching nearby places:', error);
            alert('Gagal memuat tempat terdekat. Coba lagi nanti.');
        }
    }

    function displayNearbyPlaces(elements, type) {
        nearbyLayer.clearLayers();

        elements.forEach(element => {
            let lat, lon, name;

            if (element.type === 'node') {
                lat = element.lat;
                lon = element.lon;
                name = element.tags?.name || `${type.charAt(0).toUpperCase() + type.slice(1)}`;
            } else if (element.type === 'way' || element.type === 'relation') {
                if (element.center) {
                    lat = element.center.lat;
                    lon = element.center.lon;
                    name = element.tags?.name || `${type.charAt(0).toUpperCase() + type.slice(1)}`;
                } else {
                    return; // Skip if no center
                }
            }

            if (lat && lon) {
                const marker = L.marker([lat, lon]).addTo(nearbyLayer);
                marker.bindPopup(`
                    <strong>${name}</strong><br>
                    <small>Jenis: ${getTypeLabel(type)}</small>
                `);
            }
        });

        if (elements.length === 0) {
            alert(`Tidak ada ${getTypeLabel(type)} ditemukan di sekitar lokasi ini.`);
        }
    }

    function getTypeLabel(type) {
        const labels = {
            restaurant: 'Restoran',
            hospital: 'Rumah Sakit',
            school: 'Sekolah',
            bank: 'Bank',
            fuel: 'SPBU'
        };
        return labels[type] || type;
    }

    // Expose functions to global scope so inline onclick handlers can find them reliably
    window.showForm = showForm;
    window.hideForm = hideForm;
    window.startDrawing = startDrawing;
    window.stopDrawing = stopDrawing;
</script>
</body>
</html>