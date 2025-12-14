<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Pertanahan</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0fdf4; /* Latar belakang hijau sangat muda untuk kesan segar */
        }
        .header {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary)); /* Gradien hijau sesuai warna yang diberikan */
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); /* Shadow dengan opacity rendah untuk profesional */
            position: relative;
            border-bottom: 3px solid var(--primary);
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Shadow halus untuk readability */
        }
        .header h1 i {
            margin-right: 15px;
            color: #ffffff;
        }
        .back-button {
            background-color: var(--primary-dark);
            color: white;
            border: 2px solid var(--primary);
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3);
        }
        .back-button i {
            margin-right: 10px;
        }
        .back-button:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 15px rgba(16, 185, 129, 0.4);
        }
        #map {
            height: calc(100vh - 100px); /* Adjust height to account for header */
            width: 100%;
            border-top: 4px solid var(--primary);
        }
        .footer {
            background: linear-gradient(135deg, var(--primary-dark), #0f766e); /* Gradien footer dengan variasi hijau */
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 16px;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -4px 12px rgba(16, 185, 129, 0.3);
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-map-marked-alt"></i> Lihat Peta Sistem Informasi Pertanahan</h1>
        <a href="/" class="back-button"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div id="map"></div>
    <div class="footer">
        <p>&copy; 2023 Sistem Informasi Pertanahan. Dibuat dengan Leaflet untuk pengalaman peta yang profesional.</p>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-6.914744, 107.609810], 13); // Koordinat Bandung

        // Tambahkan tile layer (background peta)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Nanti data marker, polygon, polyline diambil dari controller via JSON
    </script>
</body>
</html>
