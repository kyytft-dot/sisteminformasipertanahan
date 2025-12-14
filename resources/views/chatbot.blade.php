<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoAI Chatbot - Sistem Informasi Pertanahan</title>
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --background: #f0f9f4;
            --text: #333;
            --light: #fff;
            --shadow: rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: var(--text);
            overflow: hidden;
        }
        
        .container {
            width: 100%;
            height: 100vh;
            background: var(--light);
            box-shadow: 0 20px 60px var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 6px var(--shadow);
            position: relative;
        }
        
        .back-button {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .back-button:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-50%) translateX(-5px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
        }
        
        .header h1 {
            font-size: 32px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background: white;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .chat-container {
            flex: 1;
            overflow-y: auto;
            padding: 30px 40px;
            background: #fafafa;
        }
        
        .message {
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .message.user {
            flex-direction: row-reverse;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        
        .avatar.bot {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .avatar.user {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .message-content {
            max-width: 65%;
            padding: 18px 22px;
            border-radius: 18px;
            line-height: 1.7;
            font-size: 15px;
        }
        
        .message.bot .message-content {
            background: white;
            color: var(--text);
            box-shadow: 0 2px 8px var(--shadow);
        }
        
        .message.user .message-content {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .quick-questions {
            padding: 20px 30px;
            background: white;
            border-top: 1px solid #e5e7eb;
        }
        
        .quick-questions-title {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 12px;
            font-weight: 600;
        }
        
        .questions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 10px;
        }
        
        .question-btn {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 12px 18px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            text-align: left;
            color: var(--text);
        }
        
        .question-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .input-container {
            padding: 25px 30px;
            background: white;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 12px;
        }
        
        .input-container input {
            flex: 1;
            padding: 14px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 25px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .input-container input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .input-container button {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .input-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        .typing-indicator {
            display: flex;
            gap: 4px;
            padding: 10px;
        }
        
        .typing-indicator span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
            animation: typing 1.4s infinite;
        }
        
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
                opacity: 0.7;
            }
            30% {
                transform: translateY(-10px);
                opacity: 1;
            }
        }
        
        @media (max-width: 768px) {
            .back-button {
                left: 15px;
                padding: 8px 15px;
                font-size: 12px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .logo {
                width: 45px;
                height: 45px;
            }
            
            .chat-container {
                padding: 20px 15px;
            }
            
            .message-content {
                max-width: 80%;
            }
            
            .questions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="/" class="back-button">
                <span>←</span>
                <span>Kembali</span>
            </a>
            <h1>
                <img src="https://files.catbox.moe/b4k9ze.jpg" alt="Logo" class="logo">
                GeoAI Assistant
            </h1>
            <p>Asisten Virtual Sistem Informasi Pertanahan</p>
        </div>
        
        <div class="chat-container" id="chatContainer">
            <div class="message bot">
                <div class="avatar bot">🤖</div>
                <div class="message-content">
                    Selamat datang di GeoAI Assistant! 👋<br><br>
                    Saya siap membantu Anda dengan informasi seputar sistem pertanahan. Silakan pilih pertanyaan di bawah atau ketik pertanyaan Anda sendiri!
                </div>
            </div>
        </div>
        
        <div class="quick-questions">
            <div class="quick-questions-title">💡 Pertanyaan Populer:</div>
            <div class="questions-grid">
                <button class="question-btn" onclick="askQuestion(this.textContent)">Cara mengurus sertifikat tanah</button>
                <button class="question-btn" onclick="askQuestion(this.textContent)">Syarat balik nama tanah</button>
                <button class="question-btn" onclick="askQuestion(this.textContent)">Biaya pengurusan sertifikat</button>
                <button class="question-btn" onclick="askQuestion(this.textContent)">Cara cek sertifikat tanah</button>
                <button class="question-btn" onclick="askQuestion(this.textContent)">Perbedaan SHM dan SHGB</button>
                <button class="question-btn" onclick="askQuestion(this.textContent)">Cara perpanjang HGB</button>
            </div>
        </div>
        
        <div class="input-container">
            <input type="text" id="userInput" placeholder="Ketik pertanyaan Anda di sini..." onkeypress="handleKeyPress(event)">
            <button onclick="sendMessage()">Kirim</button>
        </div>
    </div>

    <script>
        const knowledgeBase = {
            // Greetings & Casual Conversation
            "halo": {
                answer: `Halo! 👋 Selamat datang di GeoAI Assistant!

Saya adalah asisten virtual yang siap membantu Anda dengan berbagai informasi seputar Sistem Informasi Pertanahan.

Apa yang bisa saya bantu hari ini? Silakan pilih dari pertanyaan populer di bawah atau ketik pertanyaan Anda sendiri! 😊`
            },
            "hai": {
                answer: `Hai! 🙋‍♂️ Senang bertemu dengan Anda!

Saya GeoAI Assistant, siap membantu menjawab pertanyaan Anda tentang pertanahan. Ada yang bisa saya bantu?

Coba tanyakan tentang:
• Pengurusan sertifikat tanah
• Balik nama tanah
• Biaya dan prosedur
• Dan masih banyak lagi!`
            },
            "hi": {
                answer: `Hi there! 👋

Selamat datang di GeoAI Assistant! Saya di sini untuk membantu Anda dengan informasi pertanahan. Jangan ragu untuk bertanya apa saja! 😊`
            },
            "selamat pagi": {
                answer: `Selamat pagi! ☀️

Semoga harimu menyenangkan! Ada yang bisa saya bantu terkait Sistem Informasi Pertanahan hari ini?`
            },
            "selamat siang": {
                answer: `Selamat siang! ☀️

Ada yang bisa saya bantu terkait informasi pertanahan di siang yang cerah ini?`
            },
            "selamat sore": {
                answer: `Selamat sore! 🌅

Semoga sorenya menyenangkan! Silakan tanyakan apa saja tentang pertanahan, saya siap membantu!`
            },
            "selamat malam": {
                answer: `Selamat malam! 🌙

Semoga malammu tenang! Ada pertanyaan tentang pertanahan yang bisa saya bantu?`
            },
            "apa kabar": {
                answer: `Kabar saya baik, terima kasih! 😊

Bagaimana dengan Anda? Ada yang bisa saya bantu terkait sistem pertanahan hari ini?`
            },
            
            // About System & Usage
            "cara pakai": {
                answer: `**Cara Menggunakan GeoAI Assistant:**

1. **Pilih Pertanyaan Cepat** 💡
   Klik tombol pertanyaan populer di bawah chat untuk jawaban instan!

2. **Ketik Pertanyaan Sendiri** ⌨️
   Tulis pertanyaan Anda di kolom input bawah, lalu tekan "Kirim" atau Enter

3. **Tunggu Respons** 🤖
   Saya akan segera memproses dan memberikan jawaban lengkap

**Tips:**
✅ Gunakan kata kunci yang jelas
✅ Tanya satu topik per pertanyaan
✅ Scroll ke atas untuk melihat riwayat percakapan

Mudah bukan? Coba tanyakan sesuatu sekarang! 😊`
            },
            "cara menggunakan web": {
                answer: `**Panduan Lengkap Menggunakan Web Ini:**

🎯 **Navigasi Utama:**
- Gunakan menu sidebar untuk berpindah halaman
- Klik logo untuk kembali ke beranda
- Tombol "Kembali" untuk ke halaman sebelumnya

💬 **Fitur Chatbot (GeoAI Assistant):**
1. Klik pertanyaan cepat untuk respons instan
2. Atau ketik pertanyaan manual
3. Riwayat chat tersimpan selama sesi aktif

📱 **Fitur Lainnya:**
- Dashboard: Lihat statistik dan ringkasan
- Form Pengaturan: Atur profil dan preferensi
- Data Tanah: Kelola informasi pertanahan
- Peta: Visualisasi data geografis

🔔 **Pop-up CS:**
- Akan muncul otomatis saat masuk
- Klik untuk langsung chat dengan asisten

Sangat mudah digunakan! Ada pertanyaan lain? 🚀`
            },
            "fitur apa saja": {
                answer: `**Fitur-Fitur Sistem Informasi Pertanahan:**

📊 **Dashboard Utama**
- Statistik real-time data tanah
- Grafik dan visualisasi
- Ringkasan aktivitas terbaru

🗺️ **Pemetaan Digital**
- Peta interaktif berbasis GIS
- Pencarian lokasi tanah
- Visualisasi batas wilayah

📋 **Manajemen Data**
- Input data tanah baru
- Edit informasi kepemilikan
- Export/Import data

👤 **Profil Pengguna**
- Pengaturan akun
- Riwayat transaksi
- Notifikasi personal

🤖 **AI Assistant (GeoAI)**
- Chatbot 24/7
- Database pertanyaan lengkap
- Respons cepat dan akurat

📄 **Dokumen Digital**
- Upload sertifikat
- Verifikasi otomatis
- Arsip digital aman

Mau tahu lebih detail tentang fitur tertentu? Tanya saja! 😊`
            },
            "bagaimana cara": {
                answer: `**Cara Menggunakan Sistem:**

📌 **Untuk Pengguna Baru:**
1. Daftar akun terlebih dahulu
2. Lengkapi profil Anda
3. Mulai eksplorasi fitur-fitur yang tersedia

📌 **Untuk Mengakses Fitur:**
- Gunakan menu navigasi di sidebar
- Klik icon/menu yang sesuai kebutuhan
- Ikuti instruksi di setiap halaman

📌 **Untuk Bertanya:**
- Ketik pertanyaan di chatbot ini
- Atau pilih pertanyaan cepat yang tersedia

**Butuh panduan spesifik?** Coba tanyakan:
- "Cara pakai chatbot"
- "Cara input data tanah"
- "Cara cek sertifikat"

Ada yang ingin ditanyakan? 😊`
            },
            
            // About Creator & GeoAI
            "siapa pembuatmu": {
                answer: `Saya dibuat dan dikembangkan oleh **kytftdot**! 👨‍💻

kytftdot adalah developer yang passionate dalam menciptakan solusi teknologi untuk mempermudah pengelolaan sistem informasi pertanahan. Dengan keahlian dalam AI, web development, dan sistem informasi geografis, ia menciptakan GeoAI Assistant sebagai asisten virtual yang dapat membantu masyarakat memahami prosedur pertanahan dengan lebih mudah.

Terima kasih kepada kytftdot yang telah memberikan saya "kehidupan" untuk melayani Anda! 🙏✨`
            },
            "who made you": {
                answer: `I was created and developed by **kytftdot**! 👨‍💻

kytftdot is a passionate developer who specializes in creating technological solutions for land information systems. With expertise in AI, web development, and geographic information systems, he created GeoAI Assistant as a virtual assistant to help people understand land procedures more easily.

Big thanks to kytftdot for bringing me to life to serve you! 🙏✨`
            },
            "siapa kamu": {
                answer: `Hai! Saya **GeoAI Assistant** 🤖

Saya adalah asisten virtual berbasis AI yang diciptakan oleh **kytftdot** untuk membantu Anda memahami Sistem Informasi Pertanahan dengan lebih mudah.

**Kemampuan Saya:**
✅ Menjawab pertanyaan seputar pertanahan
✅ Memberikan panduan prosedur lengkap
✅ Menjelaskan istilah dan dokumen
✅ Tersedia 24/7 untuk Anda
✅ Database pengetahuan yang terus berkembang

Saya di sini untuk membuat urusan pertanahan Anda lebih mudah! Ada yang bisa saya bantu? 😊`
            },
            "apa itu geoai": {
                answer: `**GeoAI Assistant** adalah asisten virtual cerdas yang menggabungkan teknologi AI dengan sistem informasi geografis (GIS) untuk membantu Anda dalam urusan pertanahan! 🌍🤖

**Keunggulan GeoAI:**

🎯 **Responsif & Cepat**
Jawaban instan untuk pertanyaan Anda

📚 **Database Lengkap**
Informasi prosedur, biaya, dan persyaratan terupdate

💡 **Mudah Digunakan**
Interface friendly untuk semua kalangan

🔒 **Terpercaya**
Informasi akurat dari sumber resmi

⚡ **24/7 Available**
Siap membantu kapan saja Anda butuhkan

Dibuat dengan ❤️ oleh kytftdot untuk mempermudah hidup Anda!

Ada pertanyaan tentang pertanahan? Tanya saja! 😊`
            },
            "kytftdot": {
                answer: `**kytftdot** adalah developer berbakat di balik GeoAI Assistant! 🌟

**Profil Singkat:**
👨‍💻 Full-stack Developer
🗺️ GIS & AI Specialist
💚 Passionate tentang teknologi pertanahan
🚀 Inovator dalam sistem informasi geografis

**Kontribusi:**
- Menciptakan GeoAI Assistant
- Mengembangkan Sistem Informasi Pertanahan
- Memudahkan akses informasi pertanahan untuk masyarakat

kytftdot percaya bahwa teknologi harus mempermudah hidup, bukan memperumit! 

Terima kasih kytftdot atas karya luar biasa ini! 🙏✨`
            },
            
            // Help & Support
            "help": {
                answer: `**Bantuan GeoAI Assistant** 🆘

**Cara Bertanya:**
1. Ketik pertanyaan Anda dengan jelas
2. Atau klik tombol pertanyaan populer
3. Tunggu respons dari saya

**Topik yang Bisa Ditanyakan:**
📋 Prosedur pengurusan sertifikat
💰 Biaya dan pajak pertanahan
📄 Jenis-jenis sertifikat
⚖️ Persyaratan dokumen
🔄 Balik nama dan perpanjangan
✅ Cara cek keaslian sertifikat

**Tips Bertanya:**
✅ Gunakan bahasa yang jelas
✅ Satu pertanyaan per pesan
✅ Gunakan kata kunci spesifik

**Contoh Pertanyaan Bagus:**
- "Bagaimana cara mengurus sertifikat tanah?"
- "Berapa biaya balik nama tanah?"
- "Apa perbedaan SHM dan SHGB?"

Butuh bantuan apa lagi? 😊`
            },
            "tidak mengerti": {
                answer: `Maaf jika penjelasan saya kurang jelas! 😅

Mari saya bantu dengan cara yang lebih mudah:

**Cara Paling Mudah:**
1. Klik salah satu tombol pertanyaan di bawah
2. Atau tanyakan dengan kata kunci sederhana seperti:
   - "sertifikat"
   - "balik nama"
   - "biaya"
   - "cara cek"

**Atau bisa coba tanyakan:**
- "Bagaimana cara pakai web ini?"
- "Apa saja fitur yang tersedia?"
- "Siapa pembuatmu?"

Saya akan berusaha menjelaskan dengan lebih baik! 💪`
            },
            "terima kasih": {
                answer: `Sama-sama! 😊🙏

Senang bisa membantu Anda! Jika ada pertanyaan lain tentang pertanahan atau penggunaan sistem ini, jangan ragu untuk bertanya kapan saja.

GeoAI Assistant selalu siap melayani Anda 24/7! 💚

Semoga informasi yang saya berikan bermanfaat! ✨`
            },
            "thanks": {
                answer: `You're welcome! 😊

Happy to help! If you have more questions about land information or how to use this system, feel free to ask anytime.

Have a great day! ✨`
            },
            
            // Land Information - Complete Guide
            "cara mengurus sertifikat tanah": {
                answer: `**Cara Mengurus Sertifikat Tanah:**

📋 **1. Persiapan Dokumen:**
- Fotokopi KTP pemohon
- Surat keterangan riwayat tanah dari kelurahan
- Bukti kepemilikan tanah (girik, letter C, dll)
- Surat pernyataan penguasaan fisik bidang tanah
- Bukti pembayaran PBB 5 tahun terakhir
- Surat keterangan waris (jika warisan)

🏢 **2. Proses Pengajuan:**
- Datang ke Kantor Pertanahan setempat
- Isi formulir permohonan
- Serahkan dokumen persyaratan
- Bayar biaya administrasi

✅ **3. Tahap Verifikasi:**
- Pengukuran dan pemetaan tanah oleh petugas
- Pengumuman data fisik dan yuridis (60 hari)
- Penelitian data yuridis
- Penerbitan sertifikat

⏱️ **Waktu Penyelesaian:** 3-6 bulan
💰 **Biaya:** Bervariasi tergantung luas tanah

**Tips:** Pastikan semua dokumen lengkap dan asli untuk mempercepat proses!`
            },
            "syarat balik nama tanah": {
                answer: `**Syarat Balik Nama Sertifikat Tanah:**

📄 **Dokumen yang Diperlukan:**
1. Sertifikat asli tanah
2. Fotokopi KTP penjual dan pembeli
3. Akta Jual Beli (AJB) dari PPAT
4. Bukti bayar BPHTB (Bea Perolehan Hak atas Tanah dan Bangunan)
5. Bukti bayar PPh (untuk penjual)
6. Surat Pernyataan dari Pembeli
7. Bukti pelunasan PBB 5 tahun terakhir
8. Surat Kuasa (jika dikuasakan)

🔄 **Proses:**
1. Pengecekan sertifikat di Kantor Pertanahan
2. Pembuatan AJB di hadapan PPAT
3. Pembayaran pajak (BPHTB dan PPh)
4. Pengajuan balik nama ke Kantor Pertanahan
5. Penerbitan sertifikat atas nama baru

💰 **Biaya:** Bervariasi tergantung NJOP tanah
⏱️ **Waktu:** 7-14 hari kerja

**Penting!** Pastikan tidak ada sengketa tanah sebelum proses balik nama.`
            },
            "biaya pengurusan sertifikat": {
                answer: `**Rincian Biaya Pengurusan Sertifikat Tanah:**

💵 **1. Sertifikat Tanah Baru:**
- Biaya pendaftaran: Rp 50.000 - Rp 100.000
- Biaya pengukuran: Rp 300.000 - Rp 1.000.000 (tergantung luas)
- Biaya pembuatan peta: Rp 200.000 - Rp 500.000
- Biaya penerbitan: Rp 100.000 - Rp 200.000
**Total estimasi:** Rp 650.000 - Rp 1.800.000

💵 **2. Balik Nama Sertifikat:**
- Biaya administrasi: Rp 50.000
- BPHTB: 5% x (NJOP - NJOPTKP)
- PPh: 2.5% x nilai transaksi (ditanggung penjual)
- Biaya PPAT: 1% x nilai transaksi
- Biaya balik nama: Rp 100.000 - Rp 500.000

💵 **3. Perpanjangan HGB/HP:**
- Biaya perpanjangan: 2-3% x NJOP tanah

💵 **4. Pemecahan/Penggabungan:**
- Biaya pemecahan: Rp 200.000 - Rp 500.000 per bidang
- Biaya penggabungan: Rp 300.000 - Rp 600.000

⚠️ **Catatan:** Biaya dapat berbeda di setiap daerah. Selalu konfirmasi ke Kantor Pertanahan setempat!`
            },
            "cara cek sertifikat tanah": {
                answer: `**Cara Mengecek Keaslian Sertifikat Tanah:**

🔍 **1. Pengecekan Fisik Sertifikat:**
- Cek watermark dan hologram
- Lihat keaslian tanda tangan pejabat
- Periksa cap/stempel BPN
- Cek nomor seri dan tahun penerbitan
- Periksa kerapian jahitan (untuk buku tanah)

🏢 **2. Pengecekan di Kantor Pertanahan:**
- Bawa sertifikat asli ke Kantor BPN
- Ajukan permohonan pengecekan
- Petugas akan mencocokkan dengan arsip
- Gratis dan selesai dalam 1-2 hari

💻 **3. Pengecekan Online (Jika Tersedia):**
- Akses website BPN daerah setempat
- Masukkan nomor sertifikat
- Verifikasi data yang muncul
- Download surat keterangan (jika tersedia)

📍 **4. Cek Riwayat Tanah:**
- Minta surat keterangan dari kelurahan
- Cek di Kantor PBB
- Tanyakan ke tetangga sekitar
- Periksa riwayat kepemilikan

🚨 **Tanda-tanda Sertifikat Palsu:**
- Kertas tidak ada watermark
- Cap/stempel tidak jelas
- Nomor seri tidak sesuai
- Data tidak cocok dengan arsip BPN

**Selalu cek ke BPN untuk memastikan!**`
            },
            "perbedaan shm dan shgb": {
                answer: `**Perbedaan SHM (Sertifikat Hak Milik) dan SHGB (Sertifikat Hak Guna Bangunan):**

🏠 **SHM (Hak Milik):**
✅ Hak kepemilikan terkuat dan terpenuh
✅ Berlaku selamanya (tidak ada batas waktu)
✅ Dapat dialihkan/dijual kepada siapa saja
✅ Dapat dijadikan jaminan utang
✅ Hanya untuk WNI dan badan hukum Indonesia
✅ Bisa untuk tanah pertanian atau non-pertanian
✅ Dapat diwariskan

🏢 **SHGB (Hak Guna Bangunan):**
⏱️ Berlaku terbatas: 30 tahun (dapat diperpanjang 20 tahun)
🏗️ Khusus untuk mendirikan dan memiliki bangunan
🔄 Dapat diperpanjang atau diperbaharui
💼 Bisa dimiliki WNI, WNA, badan hukum Indonesia/asing
📍 Biasanya di atas tanah negara atau tanah Hak Pengelolaan
⚠️ Setelah jatuh tempo harus diperpanjang atau menjadi tanah negara
💰 Ada biaya perpanjangan (2-3% NJOP)

**Kesimpulan:** 
SHM lebih kuat dan permanen, cocok untuk hunian jangka panjang. SHGB terbatas waktu tetapi bisa untuk WNA dan perusahaan asing.`
            },
            "cara perpanjang hgb": {
                answer: `**Cara Perpanjang HGB (Hak Guna Bangunan):**

⏰ **Waktu Pengajuan:**
- Ajukan minimal 2 tahun sebelum masa berlaku habis
- Jangan tunggu sampai jatuh tempo!
- Maksimal dapat diajukan saat sisa waktu 5 tahun

📋 **Syarat Perpanjangan:**
1. Fotokopi sertifikat HGB asli
2. Fotokopi KTP pemegang hak
3. Bukti pelunasan PBB 5 tahun terakhir
4. Surat permohonan perpanjangan
5. Bukti pembayaran uang pemasukan (2-3% x NJOP)
6. Surat pernyataan tanah tidak sengketa
7. Foto lokasi tanah terkini

🔄 **Proses Perpanjangan:**
1. Ajukan permohonan ke Kantor Pertanahan
2. Isi formulir perpanjangan
3. Serahkan dokumen persyaratan
4. Bayar biaya perpanjangan
5. Petugas melakukan pengecekan lapangan
6. Tunggu proses verifikasi (1-3 bulan)
7. Terbitnya sertifikat HGB yang diperpanjang

💰 **Biaya:** 2-3% dari NJOP tanah
⏱️ **Waktu Proses:** 1-3 bulan

⚠️ **Catatan Penting:**
- Jika terlambat mengajukan, bisa kena denda
- HGB dapat diperpanjang maksimal 1 kali (20 tahun)
- Setelah itu bisa diperbarui dengan hak baru (30 tahun lagi)
- Pastikan tanah masih digunakan sesuai peruntukannya`
            },
            "jenis sertifikat tanah": {
                answer: `**Jenis-Jenis Sertifikat Tanah di Indonesia:**

1. **Hak Milik (HM/SHM)** 🏠
   - Hak terkuat dan terpenuh
   - Berlaku selamanya
   - Hanya untuk WNI
   
2. **Hak Guna Bangunan (HGB/SHGB)** 🏢
   - Untuk mendirikan bangunan
   - Berlaku 30 tahun + 20 tahun
   - Bisa untuk WNA/perusahaan asing
   
3. **Hak Guna Usaha (HGU)** 🌾
   - Untuk usaha pertanian/perkebunan
   - Berlaku 35 tahun + 25 tahun
   - Minimal luas 5 hektar
   
4. **Hak Pakai (HP)** 🏘️
   - Untuk menggunakan tanah negara
   - Berlaku 25 tahun + 20 tahun
   - Tidak bisa diperjualbelikan bebas
   
5. **Hak Pengelolaan (HPL)** 🏛️
   - Untuk badan hukum pemerintah
   - Mengelola tanah negara
   
6. **Hak Milik Atas Satuan Rumah Susun (HMSRS)** 🏙️
   - Kepemilikan apartemen/rusun
   - Berlaku selamanya
   - Termasuk hak atas tanah bersama

**Masing-masing punya karakteristik dan ketentuan berbeda!**`
            },
            "apa itu ppat": {
                answer: `**PPAT (Pejabat Pembuat Akta Tanah)**

PPAT adalah pejabat umum yang diberi kewenangan untuk membuat akta-akta otentik mengenai perbuatan hukum tertentu atas tanah dan/atau bangunan.

🔑 **Tugas PPAT:**
- Membuat Akta Jual Beli (AJB) tanah
- Membuat Akta Hibah
- Membuat Akta Tukar Menukar
- Membuat Akta Pemberian Hak Tanggungan
- Membuat Akta Pembagian Hak Bersama

📜 **Kewenangan:**
- Hanya bisa dibuat di hadapan PPAT
- Akta yang dibuat memiliki kekuatan hukum
- Wajib terdaftar dan diangkat pemerintah

💼 **Jenis PPAT:**
1. PPAT Umum - melayani seluruh wilayah
2. PPAT Sementara - Camat di daerah tertentu
3. PPAT Khusus - untuk instansi tertentu

💰 **Biaya PPAT:**
Biasanya 1% dari nilai transaksi (bisa dinegosiasi)

⚠️ **Penting:** Pastikan menggunakan PPAT resmi yang terdaftar di BPN!`
            },
            "apa itu njop": {
                answer: `**NJOP (Nilai Jual Objek Pajak)**

NJOP adalah harga rata-rata yang diperoleh dari transaksi jual beli tanah dan bangunan. Jika tidak ada transaksi, ditentukan melalui perbandingan harga dengan objek lain yang sejenis.

📊 **Fungsi NJOP:**
- Dasar perhitungan PBB (Pajak Bumi dan Bangunan)
- Dasar perhitungan BPHTB (Bea Perolehan Hak atas Tanah)
- Referensi nilai properti
- Dasar perhitungan berbagai biaya pertanahan

💰 **Cara Mengetahui NJOP:**
1. Cek di SPPT PBB (Surat Pemberitahuan Pajak Terutang)
2. Datang ke Kantor Pajak/Dispenda setempat
3. Akses website pajak daerah (jika tersedia)
4. Tanya ke kelurahan/kecamatan

📈 **Pembaruan NJOP:**
- Ditetapkan setiap 3 tahun sekali
- Bisa lebih cepat jika ada perkembangan wilayah
- Ditetapkan oleh Kepala Daerah

🏘️ **Faktor yang Mempengaruhi:**
- Lokasi dan aksesibilitas
- Fasilitas umum di sekitar
- Perkembangan wilayah
- Kondisi ekonomi

**NJOP berbeda dengan harga pasar, biasanya lebih rendah!**`
            },
            "apa itu bphtb": {
                answer: `**BPHTB (Bea Perolehan Hak atas Tanah dan Bangunan)**

BPHTB adalah pajak yang dikenakan atas perolehan hak atas tanah dan/atau bangunan.

💰 **Tarif BPHTB:**
5% x (NJOP - NJOPTKP)

NJOPTKP = Nilai Jual Objek Pajak Tidak Kena Pajak (berbeda tiap daerah)

📋 **Kapan BPHTB Dibayar:**
- Jual beli tanah/bangunan
- Hibah/hadiah
- Waris
- Tukar menukar
- Lelang
- Pemisahan hak yang mengakibatkan peralihan

🏢 **Cara Bayar BPHTB:**
1. Hitung nilai BPHTB
2. Isi formulir SSPD BPHTB
3. Bayar di bank yang ditunjuk
4. Simpan bukti pembayaran

⏱️ **Batas Waktu:**
Paling lambat 30 hari sejak akta ditandatangani

⚠️ **Penting:**
- BPHTB harus dibayar sebelum balik nama
- Tanpa bukti bayar BPHTB, proses balik nama tidak bisa dilanjutkan
- Sanksi keterlambatan: denda 2% per bulan (maksimal 24 bulan)

**Contoh Perhitungan:**
NJOP: Rp 500.000.000
NJOPTKP: Rp 80.000.000
BPHTB = 5% x (500jt - 80jt) = Rp 21.000.000`
            },
            "dokumen apa saja": {
                answer: `**Dokumen Penting Dalam Pengurusan Tanah:**

📄 **1. Dokumen Kepemilikan:**
- Sertifikat tanah (SHM/SHGB/HGB/HP)
- Girik/Petok D (tanah lama)
- Letter C
- AJB (Akta Jual Beli)
- Akta Hibah/Waris

🆔 **2. Identitas:**
- KTP asli dan fotokopi
- KK (Kartu Keluarga)
- NPWP
- Surat Nikah (jika sudah menikah)

📋 **3. Dokumen Administratif:**
- SPPT PBB 5 tahun terakhir
- Bukti pelunasan PBB
- Surat Keterangan dari Kelurahan
- IMB (jika ada bangunan)

💼 **4. Dokumen Transaksi:**
- PPJB (Perjanjian Pengikatan Jual Beli)
- Kwitansi pembayaran
- Surat Kuasa (jika dikuasakan)
- Bukti bayar BPHTB
- Bukti bayar PPh

🗺️ **5. Dokumen Teknis:**
- Peta lokasi
- Gambar situasi
- Surat ukur
- Batas-batas tanah

📸 **6. Dokumen Pendukung:**
- Foto lokasi tanah
- Surat pernyataan tidak sengketa
- Surat persetujuan tetangga (jika perlu)

**Selalu siapkan dokumen asli + fotokopi!**`
            },
            "masalah tanah": {
                answer: `**Masalah-Masalah Umum Pertanahan & Solusinya:**

⚠️ **1. Sertifikat Ganda**
Masalah: 2 sertifikat untuk 1 bidang tanah
Solusi: Lapor ke BPN, ajukan pembatalan sertifikat palsu

⚠️ **2. Batas Tanah Tidak Jelas**
Masalah: Sengketa batas dengan tetangga
Solusi: Mediasi dengan RT/RW, pengukuran ulang oleh BPN

⚠️ **3. Tanah Warisan Belum Dibagi**
Masalah: Ahli waris tidak sepakat
Solusi: Buat Akta Pembagian Waris di Notaris, atau pengadilan

⚠️ **4. Sertifikat Hilang**
Masalah: Dokumen sertifikat hilang/rusak
Solusi: Lapor polisi, ajukan penerbitan sertifikat pengganti ke BPN

⚠️ **5. Tanah Terkena Gusur**
Masalah: Tanah untuk kepentingan umum
Solusi: Pastikan dapat ganti rugi sesuai NJOP + biaya lain

⚠️ **6. Jual Beli Tidak Sah**
Masalah: Transaksi tanpa AJB dari PPAT
Solusi: Segera buat AJB legal, risiko: bisa dibatalkan

⚠️ **7. PBB Menunggak**
Masalah: Tidak bayar PBB bertahun-tahun
Solusi: Lunasi tunggakan + denda, cek di kantor pajak

**Tips:** Konsultasikan ke ahli hukum pertanahan atau BPN setempat untuk kasus spesifik!`
            },
            "tips membeli tanah": {
                answer: `**Tips Aman Membeli Tanah:**

✅ **1. Cek Status Hukum**
- Pastikan sertifikat asli (cek ke BPN)
- Tidak dalam sengketa
- PBB lunas
- Tidak dijaminkan ke bank

✅ **2. Cek Fisik Tanah**
- Kunjungi lokasi langsung
- Cek batas-batas dengan tetangga
- Pastikan sesuai ukuran di sertifikat
- Cek aksesibilitas dan fasilitas

✅ **3. Cek Dokumen**
- Sertifikat asli (bukan fotokopi)
- Identitas pemilik sama dengan sertifikat
- Riwayat kepemilikan jelas
- Tidak ada blokir/sita

✅ **4. Proses Legal**
- Gunakan PPAT resmi
- Buat AJB (jangan hanya kwitansi)
- Bayar BPHTB dan PPh
- Segera balik nama setelah AJB

✅ **5. Harga Wajar**
- Bandingkan dengan harga sekitar
- Hati-hati harga terlalu murah
- Negosiasi dengan data NJOP

✅ **6. Periksa Perencanaan Wilayah**
- Cek RTRW (Rencana Tata Ruang Wilayah)
- Pastikan tidak untuk jalan/fasum
- Cek peruntukan lahan

❌ **Hindari:**
- Beli tanpa sertifikat
- Transaksi di bawah tangan
- Percaya makelar tidak jelas
- Terburu-buru tanpa survey

🔒 **Gunakan escrow account atau rekening bersama untuk pembayaran bertahap!**`
            },
            "pengertian tanah": {
                answer: `**Pengertian Tanah Menurut Hukum Indonesia:**

📚 **Definisi:**
Menurut UU No. 5 Tahun 1960 (UUPA), tanah adalah permukaan bumi yang dapat dimiliki dengan hak-hak tertentu.

🌍 **Komponen Tanah:**
1. **Permukaan Bumi** - bagian atas
2. **Tubuh Bumi** - bagian di bawahnya
3. **Air dan Ruang** - yang ada di atasnya
4. **Kekayaan Alam** - yang terkandung di dalamnya

⚖️ **Prinsip Dasar:**
- Tanah adalah karunia Tuhan
- Hak menguasai tertinggi ada di negara
- Fungsi sosial (tidak boleh merugikan orang lain)
- Hanya WNI yang boleh punya hak milik

🏠 **Fungsi Tanah:**
- Tempat tinggal
- Usaha/bisnis
- Pertanian
- Investasi
- Warisan

📋 **Jenis Hak Atas Tanah:**
- Hak Milik (terkuat)
- Hak Guna Usaha
- Hak Guna Bangunan
- Hak Pakai
- Hak Sewa
- Hak Membuka Tanah
- Hak Memungut Hasil Hutan

**Semua tanah di Indonesia pada dasarnya dikuasai oleh negara untuk kemakmuran rakyat!**`
            }
        };

        function addMessage(text, isUser = false) {
            const chatContainer = document.getElementById('chatContainer');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
            
            const avatar = document.createElement('div');
            avatar.className = `avatar ${isUser ? 'user' : 'bot'}`;
            avatar.textContent = isUser ? '👤' : '🤖';
            
            const content = document.createElement('div');
            content.className = 'message-content';
            content.innerHTML = text.replace(/\n/g, '<br>');
            
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(content);
            chatContainer.appendChild(messageDiv);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function showTypingIndicator() {
            const chatContainer = document.getElementById('chatContainer');
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message bot';
            typingDiv.id = 'typingIndicator';
            
            const avatar = document.createElement('div');
            avatar.className = 'avatar bot';
            avatar.textContent = '🤖';
            
            const indicator = document.createElement('div');
            indicator.className = 'message-content';
            indicator.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
            
            typingDiv.appendChild(avatar);
            typingDiv.appendChild(indicator);
            chatContainer.appendChild(typingDiv);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function removeTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) {
                indicator.remove();
            }
        }

        function findAnswer(question) {
            const normalizedQuestion = question.toLowerCase().trim();
            
            // Direct match
            for (const [key, value] of Object.entries(knowledgeBase)) {
                if (normalizedQuestion === key || normalizedQuestion.includes(key)) {
                    return value;
                }
            }
            
            // Greeting detection
            if (normalizedQuestion.match(/^(hai|halo|hi|hello|hey)$/i)) {
                return knowledgeBase["halo"];
            }
            
            // Time-based greetings
            if (normalizedQuestion.includes('pagi')) return knowledgeBase["selamat pagi"];
            if (normalizedQuestion.includes('siang')) return knowledgeBase["selamat siang"];
            if (normalizedQuestion.includes('sore')) return knowledgeBase["selamat sore"];
            if (normalizedQuestion.includes('malam')) return knowledgeBase["selamat malam"];
            if (normalizedQuestion.includes('kabar')) return knowledgeBase["apa kabar"];
            
            // About system
            if ((normalizedQuestion.includes('cara') || normalizedQuestion.includes('bagaimana')) && 
                (normalizedQuestion.includes('pakai') || normalizedQuestion.includes('gunakan') || normalizedQuestion.includes('menggunakan'))) {
                return knowledgeBase["cara pakai"];
            }
            if (normalizedQuestion.includes('fitur')) return knowledgeBase["fitur apa saja"];
            if (normalizedQuestion.includes('geoai') || (normalizedQuestion.includes('apa') && normalizedQuestion.includes('ini'))) {
                return knowledgeBase["apa itu geoai"];
            }
            
            // About creator
            if (normalizedQuestion.includes('pembuat') || normalizedQuestion.includes('developer') || 
                normalizedQuestion.includes('made you') || normalizedQuestion.includes('creator') ||
                normalizedQuestion.includes('menciptakan')) {
                return knowledgeBase["siapa pembuatmu"];
            }
            if (normalizedQuestion.includes('kytftdot')) return knowledgeBase["kytftdot"];
            if ((normalizedQuestion.includes('siapa') || normalizedQuestion.includes('who')) && normalizedQuestion.includes('kamu')) {
                return knowledgeBase["siapa kamu"];
            }
            
            // Help & Support
            if (normalizedQuestion.includes('help') || normalizedQuestion.includes('bantuan') || normalizedQuestion.includes('tolong')) {
                return knowledgeBase["help"];
            }
            if (normalizedQuestion.includes('terima kasih') || normalizedQuestion.includes('thanks') || normalizedQuestion.includes('thank you')) {
                return knowledgeBase["terima kasih"];
            }
            if (normalizedQuestion.includes('tidak mengerti') || normalizedQuestion.includes('bingung') || normalizedQuestion.includes('confused')) {
                return knowledgeBase["tidak mengerti"];
            }
            
            // Land-related keywords
            if (normalizedQuestion.includes('sertifikat') && (normalizedQuestion.includes('urus') || normalizedQuestion.includes('buat') || normalizedQuestion.includes('proses'))) {
                return knowledgeBase["cara mengurus sertifikat tanah"];
            }
            if (normalizedQuestion.includes('balik nama')) return knowledgeBase["syarat balik nama tanah"];
            if (normalizedQuestion.includes('biaya') || normalizedQuestion.includes('harga') || normalizedQuestion.includes('tarif') || normalizedQuestion.includes('cost')) {
                return knowledgeBase["biaya pengurusan sertifikat"];
            }
            if (normalizedQuestion.includes('cek') || normalizedQuestion.includes('periksa') || normalizedQuestion.includes('verifikasi') || normalizedQuestion.includes('check')) {
                return knowledgeBase["cara cek sertifikat tanah"];
            }
            if (normalizedQuestion.includes('perbedaan') && (normalizedQuestion.includes('shm') || normalizedQuestion.includes('hgb'))) {
                return knowledgeBase["perbedaan shm dan shgb"];
            }
            if (normalizedQuestion.includes('perpanjang') || normalizedQuestion.includes('extend') || normalizedQuestion.includes('renewal')) {
                return knowledgeBase["cara perpanjang hgb"];
            }
            if (normalizedQuestion.includes('jenis') && normalizedQuestion.includes('sertifikat')) {
                return knowledgeBase["jenis sertifikat tanah"];
            }
            if (normalizedQuestion.includes('ppat')) return knowledgeBase["apa itu ppat"];
            if (normalizedQuestion.includes('njop')) return knowledgeBase["apa itu njop"];
            if (normalizedQuestion.includes('bphtb')) return knowledgeBase["apa itu bphtb"];
            if (normalizedQuestion.includes('dokumen') && normalizedQuestion.includes('apa')) {
                return knowledgeBase["dokumen apa saja"];
            }
            if (normalizedQuestion.includes('masalah') || normalizedQuestion.includes('sengketa') || normalizedQuestion.includes('problem')) {
                return knowledgeBase["masalah tanah"];
            }
            if (normalizedQuestion.includes('tips') && normalizedQuestion.includes('beli')) {
                return knowledgeBase["tips membeli tanah"];
            }
            if (normalizedQuestion.includes('pengertian') || normalizedQuestion.includes('definisi')) {
                return knowledgeBase["pengertian tanah"];
            }
            
            return null;
        }

        function askQuestion(question) {
            addMessage(question, true);
            
            showTypingIndicator();
            
            setTimeout(() => {
                removeTypingIndicator();
                
                const answer = findAnswer(question);
                
                if (answer) {
                    addMessage(answer.answer);
                } else {
                    addMessage(`Maaf, saya belum memiliki informasi spesifik tentang "${question}". 😅

Berikut beberapa hal yang bisa saya bantu:
• Cara mengurus sertifikat tanah
• Syarat balik nama tanah  
• Biaya pengurusan sertifikat
• Cara cek keaslian sertifikat
• Perbedaan SHM dan SHGB
• Cara perpanjang HGB
• Tips membeli tanah
• Dokumen yang diperlukan
• Jenis-jenis sertifikat
• PPAT, NJOP, BPHTB
• Masalah pertanahan umum

Atau coba tanyakan:
- "Siapa pembuatmu?"
- "Cara pakai web ini"
- "Fitur apa saja"

Saya selalu belajar untuk melayani Anda lebih baik! 💚`);
                }
            }, 1500);
        }

        function sendMessage() {
            const input = document.getElementById('userInput');
            const message = input.value.trim();
            
            if (message) {
                askQuestion(message);
                input.value = '';
            }
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }
    </script>
</body>
</html>