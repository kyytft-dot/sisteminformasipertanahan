<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaturan Sistem Informasi Pertanahan</title>
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
            max-width: 800px;
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
        .form-section {
            margin-bottom: 30px;
        }
        .form-section h2 {
            color: #28a745;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-sizing: border-box;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #28a745;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.3);
            outline: none;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .checkbox-group, .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .checkbox-group label, .radio-group label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-weight: normal;
        }
        .checkbox-group input, .radio-group input {
            margin-right: 8px;
        }
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        .file-upload label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 15px;
            border: 2px dashed #28a745;
            border-radius: 8px;
            background-color: #f9f9f9;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .file-upload label:hover {
            background-color: #e8f5e8;
        }
        .file-upload label i {
            margin-right: 10px;
        }
        .buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-save {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        }
        .btn-reset {
            background-color: #6c757d;
            color: white;
        }
        .btn-reset:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
        }
        .btn-cancel {
            background-color: #dc3545;
            color: white;
        }
        .btn-cancel:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
        }
        .success-message, .error-message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px;
            }
            .buttons {
                flex-direction: column;
            }
            .checkbox-group, .radio-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><i class="fas fa-cogs"></i> Form Pengaturan</h1>
        <p>Atur Preferensi dan Profil Anda untuk Sistem Informasi Pertanahan</p>
    </header>

    <div class="container">
        <div id="successMessage" class="success-message">
            <i class="fas fa-check-circle"></i> Pengaturan berhasil disimpan!
        </div>
        <div id="errorMessage" class="error-message">
            <i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan. Silakan coba lagi.
        </div>
        <form id="settingsForm">
            <div class="form-section">
                <h2><i class="fas fa-user"></i> Profil Pengguna</h2>
                <div class="form-group">
                    <label for="fullName"><i class="fas fa-signature"></i> Nama Lengkap</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Masukkan nama lengkap Anda" required>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
                </div>
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" placeholder="Masukkan nomor telepon" required>
                </div>
                <div class="form-group">
                    <label for="bio"><i class="fas fa-info-circle"></i> Bio</label>
                    <textarea id="bio" name="bio" placeholder="Ceritakan sedikit tentang diri Anda"></textarea>
                </div>
                <div class="form-group">
                    <label for="profilePic"><i class="fas fa-camera"></i> Foto Profil</label>
                    <div class="file-upload">
                        <input type="file" id="profilePic" name="profilePic" accept="image/*">
                        <label for="profilePic"><i class="fas fa-upload"></i> Pilih File Gambar</label>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <h2><i class="fas fa-shield-alt"></i> Keamanan</h2>
                <div class="form-group">
                    <label for="currentPassword"><i class="fas fa-lock"></i> Kata Sandi Saat Ini</label>
                    <input type="password" id="currentPassword" name="currentPassword" placeholder="Masukkan kata sandi saat ini" required>
                </div>
                <div class="form-group">
                    <label for="newPassword"><i class="fas fa-key"></i> Kata Sandi Baru</label>
                    <input type="password" id="newPassword" name="newPassword" placeholder="Masukkan kata sandi baru">
                </div>
                <div class="form-group">
                    <label for="confirmPassword"><i class="fas fa-key"></i> Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Konfirmasi kata sandi baru">
                </div>
            </div>
            <div class="form-section">
                <h2><i class="fas fa-palette"></i> Preferensi Tampilan</h2>
                <div class="form-group">
                    <label for="theme"><i class="fas fa-paint-brush"></i> Tema</label>
                    <select id="theme" name="theme">
                        <option value="green">Hijau (Default)</option>
                        <option value="blue">Biru</option>
                        <option value="dark">Gelap</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-language"></i> Bahasa</label>
                    <div class="radio-group">
                        <label><input type="radio" name="language" value="id" checked> Indonesia</label>
                        <label><input type="radio" name="language" value="en"> English</label>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-bell"></i> Notifikasi</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="notifications" value="email" checked> Email</label>
                        <label><input type="checkbox" name="notifications" value="sms"> SMS</label>
                        <label><input type="checkbox" name="notifications" value="push"> Push Notification</label>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <h2><i class="fas fa-cogs"></i> Pengaturan Lainnya</h2>
                <div class="form-group">
                    <label for="timezone"><i class="fas fa-clock"></i> Zona Waktu</label>
                    <select id="timezone" name="timezone">
                        <option value="WIB">WIB (Waktu Indonesia Barat)</option>
                        <option value="WITA">WITA (Waktu Indonesia Tengah)</option>
                        <option value="WIT">WIT (Waktu Indonesia Timur)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-toggle-on"></i> Fitur Tambahan</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="features" value="autoSave" checked> Simpan Otomatis</label>
                        <label><input type="checkbox" name="features" value="darkMode"> Mode Gelap</label>
                        <label><input type="checkbox" name="features" value="analytics"> Analitik Penggunaan</label>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn btn-cancel" onclick="cancelForm()"><i class="fas fa-times"></i> Batal</button>
                <button type="button" class="btn btn-reset" onclick="resetForm()"><i class="fas fa-undo"></i> Reset</button>
                <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Simpan Pengaturan</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword && newPassword !== confirmPassword) {
                showError('Kata sandi baru dan konfirmasi tidak cocok.');
                return;
            }

            // Simulasi penyimpanan (di backend, kirim data ke server)
            showSuccess('Pengaturan berhasil disimpan!');
            // Reset form setelah sukses
            setTimeout(() => {
                document.getElementById('successMessage').style.display = 'none';
            }, 3000);
        });

        function resetForm() {
            document.getElementById('settingsForm').reset();
            hideMessages();
        }

        function cancelForm() {
            if (confirm('Apakah Anda yakin ingin membatalkan? Perubahan tidak akan disimpan.')) {
                resetForm();
            }
        }

        function showSuccess(message) {
            const successMsg = document.getElementById('successMessage');
            successMsg.textContent = message;
            successMsg.style.display = 'block';
            document.getElementById('errorMessage').style.display = 'none';
        }

        function showError(message) {
            const errorMsg = document.getElementById('errorMessage');
            errorMsg.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + message;
            errorMsg.style.display = 'block';
            document.getElementById('successMessage').style.display = 'none';
        }

        function hideMessages() {
            document.getElementById('successMessage').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
        }

        // Validasi real-time untuk password
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = this.value;
            if (newPassword && confirmPassword && newPassword !== confirmPassword) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '#ddd';
            }
        });
    </script>
</body>
</html>
