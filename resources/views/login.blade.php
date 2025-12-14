<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOTERRAID - Login Dashboard SIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <style>
        body, html { margin:0; padding:0; height:100%; font-family:'Inter',sans-serif; }
        input[type="password"]::-webkit-reveal-button { display: none; }
        input[type="password"]::-ms-reveal { display: none; }
    </style>
</head>
<body class="h-full bg-gray-50">

<div class="h-full flex flex-col lg:flex-row">

    <!-- ================== KIRI: BACKGROUND GEDUNG SUPER LUAS ================== -->
    <!-- GANTI LINK INI: Foto gedung kantor ATR/BPN atau gedung pertanahan resmi -->
    <div class="relative hidden lg:block flex-[2.4] bg-cover bg-center"
         style="background-image: url('https://files.catbox.moe/enfj07.jpg');">
        
        <div class="absolute inset-0 flex flex-col justify-between p-16 text-white">
<br>
<br>

            <div class="max-w-5xl">
                <h1 class="text-6xl font-black">Selamat Datang di</h1>
                <h2 class="text-9xl font-black text-blue-400 mt-2 leading-none">GEOTERRAID</h2>
                <p class="text-3xl font-light mt-6">Sistem Informasi Pertanahan Terintegrasi</p>
                <p class="text-lg mt-2 opacity-90">Kementerian Agraria dan Tata Ruang / Badan Pertanahan Nasional</p>
                <div class="mt-12">
                    <p class="text-sm opacity-80">Developed by</p>
                    <p class="text-4xl font-bold">Kementrian ATR/BPN</p>
                </div>
            </div>

            <!-- GANTI LINK INI: Logo resmi Kementerian ATR/BPN (PNG transparan) -->
            <div class="text-center">
                <img src="https://files.catbox.moe/9dwk35.png" alt="ATR/BPN" class="h-24" height="96">
            </div>
        </div>
    </div>

    <!-- ================== KANAN: FORM LEBIH RAMMING + BISA SCROLL ================== -->
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 relative">
        <div class="absolute top-4 left-4 text-white text-lg font-bold opacity-70">devmochrzkyy</div>
        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-10 lg:p-12 max-h-screen overflow-y-auto">

            <!-- GANTI LINK INI: Logo instansi / universitas / proyek (logo di atas form) -->
            <div class="flex justify-center mb-10">
                <img src="https://files.catbox.moe/k9gqiy.png" alt="Logo Instansi 1" class="h-40" height="160">
            </div>

            <h2 class="text-center text-4xl lg:text-5xl font-black text-gray-800 mb-3">
                LOGIN DASHBOARD SIP
            </h2>
            <p class="text-center text-gray-600 text-lg mb-10">
                Sistem Informasi Pertanahan
            </p>

            <form method="POST" action="/login" class="space-y-7">
                @csrf
                @if(session('error'))
                    <div class="bg-red-50 border border-red-300 text-red-700 p-4 rounded-xl text-center font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <input type="text" name="email" required
                       class="w-full px-6 py-5 border-2 border-gray-300 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none text-lg"
                       placeholder="Email atau Username">

                <div class="relative">
                    <input type="password" name="password" required id="password"
                           class="w-full px-6 py-5 pr-16 border-2 border-gray-300 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none text-lg"
                           placeholder="Password">
                    <span onclick="togglePass()" class="absolute right-5 top-6 cursor-pointer text-gray-500 hover:text-blue-600 text-xl">
                        <i class="fas fa-eye" id="eye"></i>
                    </span>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-black text-2xl py-6 rounded-2xl shadow-xl transform hover:scale-105 transition">
                    Login
                </button>
            </form>

            <!-- PERINGATAN RESMI (SEPERTI YANG KAMU MAU) -->
            <div class="mt-10 text-center text-gray-600 space-y-4 text-sm lg:text-base">
                <p>
                    <a href="#" class="text-blue-600 hover:underline font-medium">Lupa Password?</a>
                </p>
                <p class="text-xs lg:text-sm text-gray-500">
                    Belum memiliki akun? 
                    <a href="#" class="font-bold text-blue-600 hover:underline">Hubungi Administrator</a>
                </p>

                <div class="mt-8 p-5 bg-amber-50 border border-amber-300 rounded-xl text-amber-800">
                    <p class="font-bold text-sm lg:text-base">PERINGATAN</p>
                    <p class="text-xs lg:text-sm mt-2 leading-relaxed">
                        Sistem ini hanya diperuntukkan bagi <strong>petugas resmi Kementerian ATR/BPN</strong> dan pihak yang telah mendapat izin akses.<br>
                        Penggunaan tanpa izin dapat dikenai sanksi sesuai peraturan perundang-undangan yang berlaku.
                    </p>
                </div>
            </div>

            <!-- Logo ATR/BPN di HP -->
            <div class="mt-10 text-center lg:hidden">
                <img src="https://via.placeholder.com/500x200?text=LOGO+ATR+BPN" alt="ATR/BPN" class="h-20 mx-auto">
            </div>
        </div>
    </div>
</div>

<script>
    function togglePass() {
        const p = document.getElementById('password');
        p.type = p.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>