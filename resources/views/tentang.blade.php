<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Sistem Informasi Pertanahan</title>
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
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .news-item {
            background-color: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        .news-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }
        .news-image {
            width: 100%;
            height: 200px;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 1.2em;
        }
        .news-content {
            padding: 20px;
        }
        .news-title {
            font-size: 1.4em;
            font-weight: 600;
            color: #28a745;
            margin-bottom: 10px;
        }
        .news-meta {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 15px;
        }
        .news-summary {
            font-size: 1em;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        .news-read-more {
            color: #28a745;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .news-read-more:hover {
            text-decoration: underline;
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
            .news-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><i class="fas fa-newspaper"></i> Berita Sistem Informasi Pertanahan</h1>
        <p>Update Terbaru tentang Web App dan Teknologi Pertanahan</p>
    </header>
    <div class="container">
        <div class="filters">
            <input type="text" id="search" placeholder="Cari berita...">
            <select id="category">
                <option value="">Semua Kategori</option>
                <option value="Teknologi">Teknologi</option>
                <option value="Update">Update Sistem</option>
                <option value="Berita">Berita Umum</option>
                <option value="Tutorial">Tutorial</option>
                <option value="Tim">Tim Pengembang</option>
            </select>
            <button onclick="applyFilters()"><i class="fas fa-filter"></i> Terapkan Filter</button>
            <!-- Back Button -->
    <button class="back-btn" onclick="window.location.href='/'">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Dashboard
    </button>
        </div>
        <div class="news-grid" id="newsGrid">
            <!-- Berita dummy, bisa diganti dengan data dinamis -->
            <div class="news-item" data-category="Tim">
                <div class="news-image"><i class="fas fa-users"></i> Tim</div>
                <div class="news-content">
                    <div class="news-title">Perkenalan Tim Pengembang: Rizky sebagai Lead Developer</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-01 | <i class="fas fa-user"></i> Admin</div>
                    <div class="news-summary">Rizky, lead developer kami, telah memimpin pengembangan web app ini dengan fokus pada backend Laravel yang kuat dan UI responsif. Kontribusinya sangat penting untuk fitur lengkap seperti laporan dan berita.</div>
                    <a href="#" class="news-read-more" onclick="readMore(1)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Tim">
                <div class="news-image"><i class="fas fa-database"></i> Tim</div>
                <div class="news-content">
                    <div class="news-title">Fikri: Arsitek Database di Balik Sistem Pertanahan</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-02 | <i class="fas fa-user"></i> Developer</div>
                    <div class="news-summary">Fikri, sebagai pembuat database, telah merancang struktur MySQL yang scalable untuk menyimpan data tanah. Dengan keahliannya, sistem ini mendukung CRUD operations yang efisien dan aman.</div>
                    <a href="#" class="news-read-more" onclick="readMore(2)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Teknologi">
                <div class="news-image"><i class="fas fa-code"></i> Teknologi</div>
                <div class="news-content">
                    <div class="news-title">Pengembangan Web App oleh Rizky dengan Laravel</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-03 | <i class="fas fa-user"></i> Rizky</div>
                    <div class="news-summary">Rizky telah mengintegrasikan Laravel untuk backend, memastikan web app ini memiliki tema hijau yang konsisten dan fitur seperti filter pencarian yang canggih untuk data pertanahan.</div>
                    <a href="#" class="news-read-more" onclick="readMore(3)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Update">
                <div class="news-image"><i class="fas fa-sync-alt"></i> Update</div>
                <div class="news-content">
                    <div class="news-title">Update Fitur oleh Fikri: Optimasi Database</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-04 | <i class="fas fa-user"></i> Fikri</div>
                    <div class="news-summary">Fikri telah memperbarui struktur database untuk performa yang lebih baik, memungkinkan export data CSV yang cepat dan aman dalam sistem informasi pertanahan.</div>
                    <a href="#" class="news-read-more" onclick="readMore(4)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Berita">
                <div class="news-image"><i class="fas fa-globe"></i> Berita</div>
                <div class="news-content">
                    <div class="news-title">Kolaborasi Rizky dan Fikri dalam Proyek Pertanahan</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-05 | <i class="fas fa-user"></i> Editor</div>
                    <div class="news-summary">Rizky dan Fikri bekerja sama untuk mengembangkan web app ini, dengan Rizky fokus pada frontend dan Fikri pada backend database, menghasilkan sistem yang lengkap dan sesuai tema hijau.</div>
                    <a href="#" class="news-read-more" onclick="readMore(5)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Tutorial">
                <div class="news-image"><i class="fas fa-book"></i> Tutorial</div>
                <div class="news-content">
                    <div class="news-title">Tutorial oleh Rizky: Menggunakan Filter Pencarian</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-06 | <i class="fas fa-user"></i> Rizky</div>
                    <div class="news-summary">Pelajari cara menggunakan fitur filter yang dikembangkan oleh Rizky untuk mencari data tanah berdasarkan status dan lokasi dengan mudah.</div>
                    <a href="#" class="news-read-more" onclick="readMore(6)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Teknologi">
                <div class="news-image"><i class="fas fa-mobile-alt"></i> Teknologi</div>
                <div class="news-content">
                    <div class="news-title">Responsivitas Web App: Kontribusi Fikri pada Data</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-07 | <i class="fas fa-user"></i> Fikri</div>
                    <div class="news-summary">Fikri memastikan database mendukung responsivitas, sehingga web app ini optimal di mobile dan desktop dengan tema hijau yang menarik.</div>
                    <a href="#" class="news-read-more" onclick="readMore(7)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Update">
                <div class="news-image"><i class="fas fa-shield-alt"></i> Update</div>
                <div class="news-content">
                    <div class="news-title">Keamanan Sistem: Update oleh Tim Rizky dan Fikri</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-08 | <i class="fas fa-user"></i> Security Team</div>
                    <div class="news-summary">Rizky dan Fikri telah meningkatkan keamanan dengan enkripsi data dan autentikasi, melindungi informasi pertanahan dalam web app ini.</div>
                    <a href="#" class="news-read-more" onclick="readMore(8)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Berita">
                <div class="news-image"><i class="fas fa-chart-line"></i> Berita</div>
                <div class="news-content">
                    <div class="news-title">Statistik Penggunaan: Dampak Kontribusi Rizky</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-09 | <i class="fas fa-user"></i> Analyst</div>
                    <div class="news-summary">Pengguna aktif meningkat berkat UI yang dikembangkan Rizky, dengan fitur berita dan laporan yang sesuai tema pertanahan.</div>
                    <a href="#" class="news-read-more" onclick="readMore(9)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Tutorial">
                <div class="news-image"><i class="fas fa-search"></i> Tutorial</div>
                <div class="news-content">
                    <div class="news-title">Panduan Database oleh Fikri</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-10 | <i class="fas fa-user"></i> Fikri</div>
                    <div class="news-summary">Fikri berbagi tutorial tentang struktur database MySQL untuk pengelolaan data tanah yang efisien dalam web app.</div>
                    <a href="#" class="news-read-more" onclick="readMore(10)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Teknologi">
                <div class="news-image"><i class="fas fa-palette"></i> Teknologi</div>
                <div class="news-content">
                    <div class="news-title">Tema Hijau: Desain oleh Rizky</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-11 | <i class="fas fa-user"></i> Rizky</div>
                    <div class="news-summary">Rizky menerapkan tema hijau dengan gradient dan ikon untuk UI yang modern, sesuai dengan identitas sistem informasi pertanahan.</div>
                    <a href="#" class="news-read-more" onclick="readMore(11)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category="Update">
                <div class="news-image"><i class="fas fa-cogs"></i> Update</div>
                <div class="news-content">
                    <div class="news-title">Integrasi Fitur Baru oleh Fikri</div>
                    <div class="news-meta"><i class="fas fa-calendar-alt"></i> 2023-10-12 | <i class="fas fa-user"></i> Fikri</div>
                    <div class="news-summary">Fikri menambahkan integrasi database untuk fitur export, memungkinkan pengguna mengunduh data pertanahan dengan mudah.</div>
                    <a href="#" class="news-read-more" onclick="readMore(12)">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="news-item" data-category