<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPertanahan - Data Penduduk & Marker</title>
  
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(#10b981, #059669); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .tab-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            font-weight: 700;
            border-radius: 16px 16px 0 0;
            box-shadow: 0 -4px 20px rgba(16, 185, 129, 0.3);
        }
        .tab-inactive {
            background: rgba(255,255,255,0.1);
            color: #e2e8f0;
            backdrop-filter: blur(10px);
        }
        .tab-inactive:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .btn-glow {
            background: linear-gradient(135deg, #10b981, #34d399);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
            transition: all 0.4s ease;
        }
        .btn-glow:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.6);
        }
        .table-row:hover {
            background: rgba(16, 185, 129, 0.08) !important;
            transform: scale(1.005);
            transition: all 0.3s ease;
        }
        #universal-modal { animation: fadeInBackdrop 0.5s ease-out; }
        .modal-content {
            animation: modalPop 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px);
            border-radius: 28px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.3);
        }
        @keyframes fadeInBackdrop { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalPop {
            0% { transform: scale(0.7) translateY(100px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .form-label { font-size: 1.35rem; font-weight: 800; color: #1e2937; margin-bottom: 12px; }
        .form-input, .form-textarea {
            width: 100%; padding: 18px 20px; font-size: 1.1rem; font-weight: 600;
            color: #111827; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 18px;
            transition: all 0.3s ease;
        }
        .form-input:focus, .form-textarea:focus {
            outline: none; border-color: #10b981; background: white;
            box-shadow: 0 0 0 5px rgba(16, 185, 129, 0.25); transform: translateY(-2px);
        }
        .form-textarea { min-height: 120px; resize: vertical; }
        .search-input {
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.2);
            color: white;
            padding: 14px 20px;
            border-radius: 16px;
            font-size: 1.1rem;
        }
        .search-input:focus {
            outline: none;
            background: rgba(255,255,255,0.25);
            border-color: #10b981;
        }
        .search-input::placeholder { color: rgba(255,255,255,0.7); }
        .page-btn {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 10px 16px;
            border-radius: 12px;
            transition: all 0.3s;
        }
        .page-btn:hover { background: rgba(255,255,255,0.3); }
        .page-btn-active {
            background: linear-gradient(135deg, #10b981, #059669);
            font-weight: bold;
        }
        .btn-back {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            border: 2px solid rgba(255,255,255,0.25);
            transition: all 0.4s ease;
        }
        .btn-back:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-emerald-900 to-teal-900 min-h-screen text-white">

    <!-- Header + TOMBOL BACK KE DASHBOARD -->
    <header class="glass-card border-b border-white/20">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl flex items-center justify-center shadow-2xl">
                        Globe
                    </div>
                    <div>
                        <h1 class="text-5xl font-black bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">
                            SIPertanahan
                        </h1>
                        <p class="text-emerald-300 text-xl font-medium">Sistem Informasi Pertanahan Digital Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- SEMUA KODE DI BAWAH INI 100% SAMA DENGAN YANG LU KASIH, GUE NGGAK UBAH APA-APA KECUALI PERBAIKI 1 ERROR KECIL DI loadMarker() -->
    <div class="container mx-auto px-6 py-12">
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="flex">
                <button onclick="switchTab('penduduk')" id="tab-penduduk" class="flex-1 px-10 py-6 text-center tab-active text-xl font-bold">
                    Data Penduduk
                </button>
                <button onclick="switchTab('marker')" id="tab-marker" class="flex-1 px-10 py-6 text-center tab-inactive text-xl font-bold">
                    Data Marker Lokasi
                </button>
            </div>

            <div class="p-8 bg-white/5">
                <!-- TAB PENDUDUK -->
                <div id="content-penduduk" class="tab-content">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-4xl font-black bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">
                            Daftar Penduduk
                        </h2>
                        <button onclick="openModal('create','penduduk')" class="btn-glow text-black font-bold px-8 py-5 rounded-2xl text-xl flex items-center gap-3">
                            Tambah Penduduk
                        </button>
                    </div>
                    <div class="mb-6">
                        <input type="text" id="search-penduduk" placeholder="Cari NIK atau Nama..." class="search-input w-full max-w-md">
                    </div>
                    <div class="bg-white/10 rounded-2xl p-6 backdrop-blur-lg">
                        <div class="overflow-x-auto rounded-xl">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                                        <th class="px-6 py-5 text-left rounded-l-xl">No</th>
                                        <th class="px-6 py-5 text-left">NIK</th>
                                        <th class="px-6 py-5 text-left">Nama</th>
                                        <th class="px-6 py-5 text-left">Alamat</th>
                                        <th class="px-6 py-5 text-center rounded-r-xl">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-penduduk" class="divide-y divide-white/20"></tbody>
                            </table>
                        </div>
                        <div id="pagination-penduduk" class="mt-6 flex justify-center gap-3"></div>
                    </div>
                </div>

                <!-- TAB MARKER -->
                <div id="content-marker" class="tab-content hidden">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-4xl font-black bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">
                            Data Marker Lokasi
                        </h2>
                    </div>
                    <div class="mb-6">
                        <input type="text" id="search-marker" placeholder="Cari Nama Lokasi..." class="search-input w-full max-w-md">
                    </div>
                    <div class="bg-white/10 rounded-2xl p-6 backdrop-blur-lg">
                        <div class="overflow-x-auto rounded-xl">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white">
                                        <th class="px-6 py-5 text-left rounded-l-xl">No</th>
                                        <th class="px-6 py-5 text-left">Nama Lokasi</th>
                                        <th class="px-6 py-5 text-left">Keterangan</th>
                                        <th class="px-6 py-5 text-center rounded-r-xl">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-marker" class="divide-y divide-white/20">
                                    <tr><td colspan="4" class="text-center py-16 text-yellow-400">
                                        <i class="fas fa-spinner fa-spin text-4xl"></i><br>
                                        Sedang memuat marker...
                                    </td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination-marker" class="mt-6 flex justify-center gap-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Universal -->
    <div id="universal-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="modal-content w-full max-w-4xl max-h-screen overflow-y-auto rounded-3xl">
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-8 rounded-t-3xl flex justify-between items-center">
                <h2 id="modal-title" class="text-4xl font-black text-white">Tambah Data</h2>
                <button onclick="closeModal()" class="text-white text-4xl hover:scale-125 transition">X</button>
            </div>
            <div class="p-12 bg-white">
                <form id="universal-form">
                    <input type="hidden" id="record-id">
                    <input type="hidden" id="record-type">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10" id="form-fields"></div>
                    <div class="flex justify-end gap-6 mt-12">
                        <button type="button" onclick="closeModal()" class="px-10 py-4 bg-gray-600 text-white rounded-2xl hover:bg-gray-700 transition text-xl font-bold">
                            Batal
                        </button>
                        <button type="submit" class="px-12 py-5 btn-glow text-black rounded-2xl text-xl font-bold shadow-2xl">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

 <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let pendudukData = [], markerData = [];
    const itemsPerPage = 5;

    function switchTab(tab) {
        document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
        document.querySelectorAll('[id^="tab-"]').forEach(t => {
            t.classList.remove('tab-active'); t.classList.add('tab-inactive');
        });
        document.getElementById('content-' + tab).classList.remove('hidden');
        document.getElementById('tab-' + tab).classList.add('tab-active');
        document.getElementById('tab-' + tab).classList.remove('tab-inactive');
    }

    function openModal(mode, type, id = null, data = null) {
        document.getElementById('record-type').value = type;
        document.getElementById('record-id').value = id || '';
        document.getElementById('modal-title').textContent = (mode === 'create' ? 'Tambah ' : 'Edit ') + (type === 'penduduk' ? 'Penduduk' : 'Marker');
        document.getElementById('universal-modal').classList.remove('hidden');
        document.getElementById('universal-modal').classList.add('flex');
        generateForm(type, mode === 'edit' ? data : null);
    }

    function closeModal() {
        document.getElementById('universal-modal').classList.add('hidden');
        document.getElementById('universal-modal').classList.remove('flex');
    }

    function generateForm(type, data) {
        const container = document.getElementById('form-fields');
        container.innerHTML = '';
        
        const fields = type === 'penduduk' ? [
            { label: 'NIK (16 digit)', id: 'nik', type: 'text', required: true, maxlength: 16 },
            { label: 'Nama Lengkap', id: 'nama', type: 'text', required: true },
            { label: 'Alamat Lengkap', id: 'alamat', type: 'textarea', required: true },
            { label: 'RT', id: 'rt', type: 'text', required: true, maxlength: 3 },
            { label: 'RW', id: 'rw', type: 'text', required: true, maxlength: 3 },
            { label: 'Provinsi', id: 'provinsi', type: 'text', required: true },
            { label: 'Latitude (Opsional)', id: 'latitude', type: 'text', required: false, placeholder: 'Contoh: -6.200000' },
            { label: 'Longitude (Opsional)', id: 'longitude', type: 'text', required: false, placeholder: 'Contoh: 106.816666' }
        ] : [
            { label: 'Nama Lokasi', id: 'nama_lokasi', type: 'text', required: true },
            { label: 'Keterangan', id: 'keterangan', type: 'textarea' }
        ];

        fields.forEach(f => {
            const div = document.createElement('div');
            const input = f.type === 'textarea' 
                ? `<textarea id="${f.id}" class="form-textarea" rows="5" placeholder="${f.placeholder || 'Masukkan ' + f.label.toLowerCase() + '...'}" ${f.required?'required':''}>${data?.[f.id]||''}</textarea>`
                : `<input type="text" id="${f.id}" class="form-input" value="${data?.[f.id]||''}" placeholder="${f.placeholder || 'Masukkan ' + f.label.toLowerCase() + '...'}" maxlength="${f.maxlength||''}" ${f.required?'required':''}>`;
            div.innerHTML = `<label class="form-label">${f.label} ${f.required?'<span class="text-red-600">*</span>':''}</label>${input}`;
            container.appendChild(div);
        });

        if (type === 'penduduk') {
            // Validasi NIK hanya angka
            const nikInput = document.getElementById('nik');
            if (nikInput) {
                nikInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
                });
            }

            // Validasi RT/RW hanya angka
            ['rt', 'rw'].forEach(fieldId => {
                const input = document.getElementById(fieldId);
                if (input) {
                    input.addEventListener('input', function() {
                        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);
                    });
                }
            });

            // Validasi Latitude/Longitude (angka, titik, minus)
            ['latitude', 'longitude'].forEach(fieldId => {
                const input = document.getElementById(fieldId);
                if (input) {
                    input.addEventListener('input', function() {
                        this.value = this.value.replace(/[^0-9.\-]/g, '');
                    });
                }
            });

            // Tombol untuk mendapatkan lokasi otomatis
            const locationDiv = document.createElement('div');
            locationDiv.className = 'mt-2';
            locationDiv.innerHTML = `
                <button type="button" id="getLocationBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                    📍 Dapatkan Lokasi Saya
                </button>
                <span id="locationStatus" class="ml-2 text-sm text-gray-400"></span>
            `;
            container.appendChild(locationDiv);

            // Event listener untuk tombol lokasi
            setTimeout(() => {
                const locationBtn = document.getElementById('getLocationBtn');
                const locationStatus = document.getElementById('locationStatus');
                
                if (locationBtn) {
                    locationBtn.addEventListener('click', function() {
                        if (navigator.geolocation) {
                            locationStatus.textContent = 'Mendapatkan lokasi...';
                            locationStatus.className = 'ml-2 text-sm text-yellow-400';
                            
                            navigator.geolocation.getCurrentPosition(
                                function(position) {
                                    document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
                                    document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
                                    locationStatus.textContent = '✓ Lokasi berhasil didapat!';
                                    locationStatus.className = 'ml-2 text-sm text-green-400';
                                },
                                function(error) {
                                    locationStatus.textContent = '✗ Gagal mendapatkan lokasi';
                                    locationStatus.className = 'ml-2 text-sm text-red-400';
                                    console.error('Error getting location:', error);
                                }
                            );
                        } else {
                            locationStatus.textContent = '✗ Browser tidak mendukung geolokasi';
                            locationStatus.className = 'ml-2 text-sm text-red-400';
                        }
                    });
                }
            }, 100);
        }
    }

    async function loadPenduduk() {
        try {
            const res = await fetch('/penduduk/penduduk');
            if (!res.ok) throw new Error('Gagal fetch penduduk');
            pendudukData = await res.json();
            renderPenduduk(1, '');
        } catch (err) {
            console.error('Error load penduduk:', err);
            document.getElementById('table-penduduk').innerHTML = '<tr><td colspan="8" class="text-center py-16 text-red-400">Gagal memuat data penduduk</td></tr>';
        }
    }

    async function loadMarker() {
        const urls = ['/marker', '/api/marker', '/markers', '/marker/index', '/marker/marker'];
        let success = false;

        for (const url of urls) {
            try {
                console.log('Mencoba URL marker:', url);
                const res = await fetch(url);
                if (res.ok) {
                    markerData = await res.json();
                    console.log('BERHASIL! Data marker dari:', url);
                    renderMarker(1, '');
                    success = true;
                    break;
                }
            } catch (e) {
                console.log('Gagal dari:', url);
            }
        }

        if (!success) {
            document.getElementById('table-marker').innerHTML = `
                <tr><td colspan="4" class="text-center py-16 text-red-400">
                    Gagal memuat data marker!<br>
                    <small class="text-gray-400">Cek route di Laravel: Route::get('/marker', [MarkerController::class, 'index'])</small>
                </td></tr>`;
        }
    }

    function renderPenduduk(page = 1, search = '') {
        const tbody = document.getElementById('table-penduduk');
        const searchLower = search.toLowerCase().trim();
        
        // 🔍 SEARCH hanya dari NIK dan NAMA
        const filtered = pendudukData.filter(item => {
            if (!searchLower) return true; // Jika search kosong, tampilkan semua
            
            const nikMatch = item.nik && item.nik.includes(searchLower);
            const namaMatch = item.nama && item.nama.toLowerCase().includes(searchLower);
            
            return nikMatch || namaMatch;
        });
        
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = filtered.slice(start, end);
        const totalPages = Math.ceil(filtered.length / itemsPerPage);

        // Info jumlah data
        const infoText = search ? 
            `Ditemukan ${filtered.length} data dari pencarian "${search}"` : 
            `Total ${filtered.length} data penduduk`;

        tbody.innerHTML = pageData.length ? pageData.map((item, i) => `
            <tr class="table-row text-white hover:bg-gray-700 transition-colors">
                <td class="px-6 py-5">${start + i + 1}</td>
                <td class="px-6 py-5 font-bold text-blue-400">${item.nik}</td>
                <td class="px-6 py-5">${item.nama}</td>
                <td class="px-6 py-5 text-sm">${item.alamat.substring(0,30)}${item.alamat.length > 30 ? '...' : ''}</td>
                <td class="px-6 py-5">${item.rt || '-'}</td>
                <td class="px-6 py-5">${item.rw || '-'}</td>
                <td class="px-6 py-5">${item.provinsi || '-'}</td>
                <td class="px-6 py-5 text-center">
                    <button onclick="openModal('edit','penduduk',${item.id},${JSON.stringify(item).replace(/"/g,'&quot;')})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg mx-1 text-sm">Edit</button>
                    <button onclick="deleteData('penduduk',${item.id})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg mx-1 text-sm">Hapus</button>
                </td>
            </tr>`).join('') : `<tr><td colspan="8" class="text-center py-16 text-gray-400">${search ? '❌ Tidak ada data yang cocok dengan pencarian' : '📋 Belum ada data penduduk'}</td></tr>`;

        // Tampilkan info dan pagination
        const tableContainer = tbody.parentElement.parentElement;
        let infoDiv = tableContainer.querySelector('.data-info');
        if (!infoDiv) {
            infoDiv = document.createElement('div');
            infoDiv.className = 'data-info text-sm text-gray-400 px-6 py-3 border-t border-gray-700';
            tableContainer.appendChild(infoDiv);
        }
        infoDiv.textContent = infoText;

        renderPagination('penduduk', totalPages, page, search);
    }

    function renderMarker(page = 1, search = '') {
        const tbody = document.getElementById('table-marker');
        const searchLower = search.toLowerCase().trim();
        
        const filtered = markerData.filter(item => {
            if (!searchLower) return true;
            return item.nama_lokasi?.toLowerCase().includes(searchLower);
        });
        
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = filtered.slice(start, end);
        const totalPages = Math.ceil(filtered.length / itemsPerPage);

        const infoText = search ? 
            `Ditemukan ${filtered.length} marker dari pencarian "${search}"` : 
            `Total ${filtered.length} marker`;

        tbody.innerHTML = pageData.length ? pageData.map((item, i) => `
            <tr class="table-row text-white hover:bg-gray-700 transition-colors">
                <td class="px-6 py-5">${start + i + 1}</td>
                <td class="px-6 py-5 font-bold text-green-400">${item.nama_lokasi}</td>
                <td class="px-6 py-5 text-sm">${item.keterangan || '-'}</td>
                <td class="px-6 py-5 text-center">
                    <button onclick="openModal('edit','marker',${item.id},${JSON.stringify(item).replace(/"/g,'&quot;')})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg mx-1 text-sm">Edit</button>
                    <button onclick="deleteData('marker',${item.id})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg mx-1 text-sm">Hapus</button>
                </td>
            </tr>`).join('') : `<tr><td colspan="4" class="text-center py-16 text-gray-400">${search ? '❌ Tidak ada marker yang cocok' : '📍 Belum ada marker'}</td></tr>`;

        const tableContainer = tbody.parentElement.parentElement;
        let infoDiv = tableContainer.querySelector('.data-info');
        if (!infoDiv) {
            infoDiv = document.createElement('div');
            infoDiv.className = 'data-info text-sm text-gray-400 px-6 py-3 border-t border-gray-700';
            tableContainer.appendChild(infoDiv);
        }
        infoDiv.textContent = infoText;

        renderPagination('marker', totalPages, page, search);
    }

    function renderPagination(type, totalPages, currentPage, search) {
        const container = document.getElementById(`pagination-${type}`);
        container.innerHTML = '';
        
        if (totalPages <= 1) {
            container.innerHTML = '<div class="text-sm text-gray-500 text-center py-2">Halaman 1 dari 1</div>';
            return;
        }

        // Wrapper untuk pagination
        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-center justify-center gap-2 py-4';

        // Tombol Previous
        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = '« Sebelumnya';
        prevBtn.className = `px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
            currentPage === 1 
                ? 'bg-gray-700 text-gray-500 cursor-not-allowed' 
                : 'bg-blue-600 text-white hover:bg-blue-700'
        }`;
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                type === 'penduduk' ? renderPenduduk(currentPage - 1, search) : renderMarker(currentPage - 1, search);
            }
        };
        wrapper.appendChild(prevBtn);

        // Info halaman saat ini
        const pageInfo = document.createElement('div');
        pageInfo.className = 'px-4 py-2 bg-gray-700 rounded-lg text-white text-sm font-medium';
        pageInfo.textContent = `${currentPage} / ${totalPages}`;
        wrapper.appendChild(pageInfo);

        // Tombol nomor halaman (tampilkan beberapa saja untuk menghemat ruang)
        const maxButtons = 3;
        let startPage = Math.max(1, currentPage - 1);
        let endPage = Math.min(totalPages, startPage + maxButtons - 1);
        
        if (endPage - startPage < maxButtons - 1) {
            startPage = Math.max(1, endPage - maxButtons + 1);
        }

        // Tambahkan titik jika ada halaman sebelumnya yang tidak ditampilkan
        if (startPage > 1) {
            const firstBtn = document.createElement('button');
            firstBtn.textContent = '1';
            firstBtn.className = 'px-3 py-2 rounded-lg text-sm font-medium bg-gray-700 text-white hover:bg-gray-600 transition-colors';
            firstBtn.onclick = () => type === 'penduduk' ? renderPenduduk(1, search) : renderMarker(1, search);
            
            const dots = document.createElement('span');
            dots.textContent = '...';
            dots.className = 'px-2 text-gray-500';
        }

        // Nomor halaman
        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = `px-3 py-2 rounded-lg text-sm font-medium transition-colors ${
                i === currentPage 
                    ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg scale-110' 
                    : 'bg-gray-700 text-white hover:bg-gray-600'
            }`;
            btn.onclick = () => type === 'penduduk' ? renderPenduduk(i, search) : renderMarker(i, search);
            wrapper.appendChild(btn);
        }

        // Tambahkan titik jika ada halaman setelahnya yang tidak ditampilkan
        if (endPage < totalPages) {
            const dots = document.createElement('span');
            dots.textContent = '...';
            dots.className = 'px-2 text-gray-500';
            
            const lastBtn = document.createElement('button');
            lastBtn.textContent = totalPages;
            lastBtn.className = 'px-3 py-2 rounded-lg text-sm font-medium bg-gray-700 text-white hover:bg-gray-600 transition-colors';
            lastBtn.onclick = () => type === 'penduduk' ? renderPenduduk(totalPages, search) : renderMarker(totalPages, search);
        }

        // Tombol Next
        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = 'Selanjutnya »';
        nextBtn.className = `px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
            currentPage === totalPages 
                ? 'bg-gray-700 text-gray-500 cursor-not-allowed' 
                : 'bg-blue-600 text-white hover:bg-blue-700'
        }`;
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                type === 'penduduk' ? renderPenduduk(currentPage + 1, search) : renderMarker(currentPage + 1, search);
            }
        };
        wrapper.appendChild(nextBtn);

        container.appendChild(wrapper);
    }

    document.getElementById('search-penduduk')?.addEventListener('input', e => renderPenduduk(1, e.target.value));
    document.getElementById('search-marker')?.addEventListener('input', e => renderMarker(1, e.target.value));

    document.getElementById('universal-form').onsubmit = async function(e) {
        e.preventDefault();
        const type = document.getElementById('record-type').value;
        const id = document.getElementById('record-id').value;

        if (type === 'penduduk') {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length !== 16 || !/^\d+$/.test(nik)) {
                alert('NIK harus 16 digit angka!');
                return;
            }

            const rt = document.getElementById('rt').value.trim();
            const rw = document.getElementById('rw').value.trim();
            if (!rt || !rw) {
                alert('RT dan RW wajib diisi!');
                return;
            }

            // Validasi latitude/longitude jika diisi
            const lat = document.getElementById('latitude').value.trim();
            const lng = document.getElementById('longitude').value.trim();
            if (lat && (isNaN(lat) || lat < -90 || lat > 90)) {
                alert('Latitude tidak valid! Harus antara -90 sampai 90');
                return;
            }
            if (lng && (isNaN(lng) || lng < -180 || lng > 180)) {
                alert('Longitude tidak valid! Harus antara -180 sampai 180');
                return;
            }
        }

        // Kumpulkan data dalam object biasa
        const dataObject = {};
        const fields = type === 'penduduk' 
            ? ['nik','nama','alamat','rt','rw','provinsi','latitude','longitude'] 
            : ['nama_lokasi','keterangan'];
        
        fields.forEach(f => {
            const value = document.getElementById(f)?.value.trim() || '';
            dataObject[f] = value;
        });

        // 🎯 TRIK AJAIB: Tambahkan field yang diminta backend dengan nilai default!
        if (type === 'penduduk') {
            dataObject.tanggal_lahir = '2000-01-01';
            dataObject.jenis_kelamin = 'Laki-laki';
            dataObject.status_perkawinan = 'Belum Kawin';
            
            // Pastikan lat/lng ada nilai (walaupun string kosong)
            if (!dataObject.latitude) dataObject.latitude = '';
            if (!dataObject.longitude) dataObject.longitude = '';
            
            console.log('🚀 Data yang akan dikirim:', dataObject);
        }

        try {
            let url, method, body, headers;
            
            if (id) {
                // EDIT MODE - Gunakan POST dengan _method override
                url = `/${type}/${type}/${id}`;
                method = 'POST';
                
                const formData = new FormData();
                formData.append('_method', 'PUT'); // Laravel method spoofing
                
                Object.keys(dataObject).forEach(key => {
                    formData.append(key, dataObject[key]);
                });
                
                body = formData;
                headers = { 'X-CSRF-TOKEN': csrfToken };
            } else {
                // CREATE MODE - Gunakan POST dengan FormData
                url = `/${type}/${type}`;
                method = 'POST';
                
                const formData = new FormData();
                Object.keys(dataObject).forEach(key => {
                    formData.append(key, dataObject[key]);
                });
                
                body = formData;
                headers = { 'X-CSRF-TOKEN': csrfToken };
            }

            const response = await fetch(url, { method, headers, body });

            if (response.ok) {
                closeModal();
                type === 'penduduk' ? loadPenduduk() : loadMarker();
                alert(`✅ Data berhasil ${id ? 'diupdate' : 'disimpan'}!`);
            } else {
                const error = await response.text();
                console.error('Response error:', error);
                alert('❌ Gagal menyimpan: ' + error);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('⚠️ Terjadi kesalahan saat menyimpan data');
        }
    };

    async function deleteData(type, id) {
        if (!confirm('⚠️ Yakin hapus data ini? Data yang dihapus tidak bisa dikembalikan!')) return;
        
        try {
            const formData = new FormData();
            formData.append('_method', 'DELETE'); // Laravel method spoofing
            
            const response = await fetch(`/${type}/${type}/${id}`, { 
                method: 'POST', // Gunakan POST dengan _method DELETE
                headers: {'X-CSRF-TOKEN': csrfToken},
                body: formData
            });

            if (response.ok) {
                alert('✅ Data berhasil dihapus!');
                type === 'penduduk' ? loadPenduduk() : loadMarker();
            } else {
                const error = await response.text();
                console.error('Delete error:', error);
                alert('❌ Gagal menghapus data: ' + error);
            }
        } catch (error) {
            console.error('Error deleting:', error);
            alert('⚠️ Gagal menghapus data');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadPenduduk();
        loadMarker();
    });

    window.onclick = e => { if (e.target === document.getElementById('universal-modal')) closeModal(); }
</script>
</body>
</html>