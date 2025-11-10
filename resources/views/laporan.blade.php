<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sistem Informasi Pertanahan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Untuk ikon -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            color: #333;
            line-height: 1.6;
        }
        header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 300;
        }
        header p {
            margin: 10px 0 0;
            font-size: 1.2em;
            opacity: 0.9;
        }
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            align-items: center;
        }
        .filters input, .filters select {
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            flex: 1;
            min-width: 200px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .filters input:focus, .filters select:focus {
            border-color: #28a745;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.3);
            outline: none;
        }
        .filters button {
            padding: 12px 20px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .filters button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        }
        .export-btn {
            padding: 12px 20px;
            background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 25px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.4);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        table th {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #e8f5e8;
            transition: background-color 0.3s;
        }
        .actions {
            display: flex;
            gap: 8px;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .btn-view {
            background-color: #17a2b8;
            color: white;
        }
        .btn-view:hover {
            background-color: #138496;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(23, 162, 184, 0.3);
        }
        .btn-edit {
            background-color: #ffc107;
            color: black;
        }
        .btn-edit:hover {
            background-color: #e0a800;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(255, 193, 7, 0.3);
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);
        }
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            gap: 10px;
        }
        .pagination button {
            padding: 10px 15px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .pagination button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        }
        .pagination button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .pagination span {
            font-size: 16px;
            font-weight: 500;
            color: #666;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px;
            }
            .filters {
                flex-direction: column;
                align-items: stretch;
            }
            .filters input, .filters select, .filters button {
                min-width: auto;
            }
            table {
                font-size: 14px;
            }
            table th, table td {
                padding: 10px;
            }
            .actions {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><i class="fas fa-map-marked-alt"></i> Laporan Sistem Informasi Pertanahan</h1>
        <p>Data Tanah dan Pemilik Terbaru</p>
    </header>
    <div class="container">
        <div class="filters">
            <input type="text" id="search" placeholder="Cari berdasarkan nama pemilik atau lokasi...">
            <select id="status">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
                <option value="Dalam Proses">Dalam Proses</option>
            </select>
            <select id="lokasi">
                <option value="">Semua Lokasi</option>
                <option value="Jakarta">Jakarta</option>
                <option value="Bandung">Bandung</option>
                <option value="Surabaya">Surabaya</option>
            </select>
            <button onclick="applyFilters()"><i class="fas fa-filter"></i> Terapkan Filter</button>
            <!-- Back Button -->
    <button class="back-btn" onclick="window.location.href='/'">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Dashboard
    </button>
        </div>
        <button class="export-btn" onclick="exportData()"><i class="fas fa-download"></i> Export ke CSV</button>
        <table id="reportTable">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag"></i> ID Tanah</th>
                    <th><i class="fas fa-user"></i> Nama Pemilik</th>
                    <th><i class="fas fa-map-marker-alt"></i> Lokasi</th>
                    <th><i class="fas fa-ruler-combined"></i> Luas (m²)</th>
                    <th><i class="fas fa-info-circle"></i> Status</th>
                    <th><i class="fas fa-calendar-alt"></i> Tanggal Dibuat</th>
                    <th><i class="fas fa-cogs"></i> Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data dummy, bisa diganti dengan data dinamis dari backend -->
                <tr>
                    <td>001</td>
                    <td>Ahmad Surya</td>
                    <td>Jakarta</td>
                    <td>500</td>
                    <td><span style="color: green; font-weight: bold;">Aktif</span></td>
                    <td>2023-01-15</td>
                    <td class="actions">
                        <button class="btn btn-view" onclick="viewDetail(1)"><i class="fas fa-eye"></i> Lihat</button>
                        <button class="btn btn-edit" onclick="editRecord(1)"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn btn-delete" onclick="deleteRecord(1)"><i class="fas fa-trash"></i> Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>Siti Aminah</td>
                    <td>Bandung</td>
                    <td>750</td>
                    <td><span style="color: orange; font-weight: bold;">Dalam Proses</span></td>
                    <td>2023-02-20</td>
                    <td class="actions">
                        <button class="btn btn-view" onclick="viewDetail(2)"><i class="fas fa-eye"></i> Lihat</button>
                        <button class="btn btn-edit" onclick="editRecord(2)"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn btn-delete" onclick="deleteRecord(2)"><i class="fas fa-trash"></i> Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>003</td>
                    <td>Budi Santoso</td>
                    <td>Surabaya</td>
                    <td>600</td>
                    <td><span style="color: red; font-weight: bold;">Tidak Aktif</span></td>
                    <td>2023-03-10</td>
                    <td class="actions">
                        <button class="btn btn-view" onclick="viewDetail(3)"><i class="fas fa-eye"></i> Lihat</button>
                        <button class="btn btn-edit" onclick="editRecord(3)"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn btn-delete" onclick="deleteRecord(3)"><i class="fas fa-trash"></i> Hapus</button>
                    </td>
                </tr>
                <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
            </tbody>
        </table>
        <div class="pagination">
            <button id="prevBtn" onclick="changePage(-1)" disabled><i class="fas fa-chevron-left"></i> Sebelumnya</button>
            <span id="pageInfo">Halaman 1 dari 3</span>
            <button id="nextBtn" onclick="changePage(1)"><i class="fas fa-chevron-right"></i> Selanjutnya</button>
        </div>
    </div>

    <script>
        let currentPage = 1;
        const totalPages = 3; // Simulasi total halaman

        function applyFilters() {
            const search = document.getElementById('search').value.toLowerCase();
            const status = document.getElementById('status').value;
            const lokasi = document.getElementById('lokasi').value;
            const rows = document.querySelectorAll('#reportTable tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const name = cells[1].textContent.toLowerCase();
                const location = cells[2].textContent;
                const stat = cells[4].textContent;

                const matchesSearch = name.includes(search) || location.toLowerCase().includes(search);
                const matchesStatus = !status || stat.includes(status);
                const matchesLocation = !lokasi || location === lokasi;

                row.style.display = (matchesSearch && matchesStatus && matchesLocation) ? '' : 'none';
            });
        }

        function viewDetail(id) {
            alert('Melihat detail untuk ID: ' + id);
            // Di sini bisa redirect ke halaman detail atau modal
        }

        function editRecord(id) {
            alert('Mengedit record ID: ' + id);
            // Bisa buka form edit
        }

        function deleteRecord(id) {
            if (confirm('Apakah Anda yakin ingin menghapus record ID: ' + id + '?')) {
                // Simulasi penghapusan
                alert('Record ID: ' + id + ' telah dihapus.');
            }
        }

        function exportData() {
            alert('Data diekspor ke CSV. (Simulasi)');
            // Di sini bisa implementasi export sebenarnya dengan library seperti PapaParse
        }

        function changePage(direction) {
            currentPage += direction;
            if (currentPage < 1) currentPage = 1;
            if (currentPage > totalPages) currentPage = totalPages;

            document.getElementById('pageInfo').textContent = `Halaman ${currentPage} dari ${totalPages}`;
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages;

            // Simulasi load data halaman baru (di backend, fetch data berdasarkan page)
            alert('Memuat halaman ' + currentPage);
        }

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', () => {
            applyFilters(); // Terapkan filter awal jika ada
        });
    </script>
</body>
</html>
