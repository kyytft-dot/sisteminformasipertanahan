<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - SIPertanahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #0a1a2f; color: white; margin: 0; overflow-x: hidden; }
        .bg-indonesia { position: fixed; inset: 0; background: radial-gradient(circle at 20% 80%, #031b16 0%, #0a1a2f 70%); z-index: -2; }
        .svg-map { position: fixed; top: 50%; left: 50%; width: 1500px; height: 1500px; transform: translate(-50%, -50%) rotate(-6deg) scale(1.3); opacity: 0.08; filter: drop-shadow(0 0 50px #064e3b); animation: float 45s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform: translate(-50%,-50%) rotate(-6deg) scale(1.3)} 50%{transform: translate(-50%,-52%) rotate(-8deg) scale(1.33)} }

        .card { background: rgba(255,255,255,0.08); backdrop-filter: blur(28px); border-radius: 2.5rem; border: 1.5px solid rgba(16,185,129,0.35); box-shadow: 0 35px 90px rgba(0,0,0,0.7), inset 0 0 60px rgba(16,185,129,0.1); transition: all 0.5s; }
        .card:hover { transform: translateY(-10px); }

        .input { @apply w-full px-6 py-4 bg-white/10 border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/30 transition-all; }
        .btn-emerald { @apply bg-gradient-to-r from-emerald-500 to-emerald-600 text-black font-black px-8 py-4 rounded-2xl shadow-xl hover:scale-105 transition-all; }
        .btn-cyan { @apply bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-black px-8 py-4 rounded-2xl shadow-xl hover:scale-105 transition-all; }
    </style>
</head>
<body class="relative min-h-screen">

    <!-- Background Peta Indonesia -->
    <div class="bg-indonesia"></div>
    <svg class="svg-map" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
        <path fill="#064e3b" d="M300,100 Q500,50 700,100 T700,300 Q650,500 500,520 Q350,500 300,300 T300,100 M400,200 Q500,180 600,200 T600,350 Q550,450 500,460 Q450,450 400,350 T400,200"/>
        <path fill="#065f46" d="M350,150 Q500,130 650,150 T650,280 Q610,380 500,395 Q390,380 350,280 T350,150"/>
        <path fill="#10b981" opacity="0.3" d="M420,220 Q500,210 580,220 T580,310 Q550,380 500,390 Q450,380 420,310 T420,220"/>
    </svg>

    <div class="max-w-7xl mx-auto p-6 pt-20">

        <div class="text-center mb-12">
            <h1 class="text-6xl font-black text-white">User Management</h1>
            <p class="text-emerald-300 text-xl mt-2">Kelola pengguna sistem pertanahan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- TABEL USERS -->
            <div class="lg:col-span-8">
                <div class="card p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-black flex items-center gap-3">
                            <i class="fas fa-users text-emerald-400"></i> Daftar Pengguna
                        </h2>
                        <button onclick="loadUsers()" class="btn-emerald">
                            <i class="fas fa-sync-alt mr-2"></i> Refresh
                        </button>
                    </div>

                    <div class="bg-white/5 rounded-2xl overflow-hidden border border-white/10">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-emerald-600/30 text-emerald-200 font-bold">
                                    <th class="px-6 py-5 text-left">#</th>
                                    <th class="px-6 py-5 text-left">Nama</th>
                                    <th class="px-６ py-5 text-left">Email</th>
                                    <th class="px-6 py-5 text-left">Role</th>
                                    <th class="px-6 py-5 text-left">Dibuat</th>
                                    <th class="px-6 py-5 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="users-table" class="divide-y divide-white/10">
                                <!-- Data dari DB masuk sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- FORM TAMBAH USER -->
            <div class="lg:col-span-4">
                <div class="card p-8">
                    <h3 class="text-2xl font-black mb-6 flex items-center gap-3">
                        <i class="fas fa-user-plus text-emerald-400"></i> Tambah Pengguna
                    </h3>
                    <form id="userForm">
                        <input type="text" id="name" class="input mb-4" placeholder="Nama Lengkap" required>
                        <input type="email" id="email" class="input mb-4" placeholder="Email" required>
                        <select id="role" class="input mb-4">
                            <option value="user">Pengguna (Masyarakat)</option>
                            <option value="staff">Petugas</option>
                            <option value="admin">Administrator</option>
                        </select>
                        <input type="password" id="password" class="input mb-4" placeholder="Password (kosongkan = undang)">
                        <div class="flex gap-3">
                            <button type="submit" class="btn-emerald flex-1">Buat Akun</button>
                            <button type="button" onclick="sendInvite()" class="btn-cyan flex-1">Undang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // GANTI INI SESUAI DOMAIN LARAVEL KAMU
        const API_URL = 'http://localhost:8000'; // atau https://sippertanahan.com

        async function loadUsers() {
            try {
                const res = await fetch(`${API_URL}/api/users`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('Gagal koneksi');
                const users = await res.json();

                const tbody = document.getElementById('users-table');
                if (users.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="6" class="text-center py-12 text-gray-400">Belum ada pengguna terdaftar</td></tr>`;
                    return;
                }

                tbody.innerHTML = users.map((u, i) => `
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-5">${i + 1}</td>
                        <td class="px-6 py-5 font-medium">${u.name || '-'}</td>
                        <td class="px-6 py-5">${u.email}</td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-full text-xs font-bold ${
                                u.role === 'admin' ? 'bg-rose-500/30 text-rose-300' :
                                u.role === 'staff' ? 'bg-emerald-500/30 text-emerald-300' :
                                'bg-cyan-500/30 text-cyan-300'
                            }">
                                ${u.role || 'user'}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-400">${new Date(u.created_at).toLocaleDateString('id-ID')}</td>
                        <td class="px-6 py-5 text-center">
                            <button onclick="editUser(${u.id})" class="text-blue-400 hover:text-blue-300 mr-3">Edit</button>
                            <button onclick="deleteUser(${u.id})" class="text-red-400 hover:text-red-300">Hapus</button>
                        </td>
                    </tr>
                `).join('');
            } catch (err) {
                document.getElementById('users-table').innerHTML = 
                    `<tr><td colspan="6" class="text-center py-12 text-red-400">Gagal memuat data: ${err.message}</td></tr>`;
            }
        }

        // Load saat buka halaman
        loadUsers();
    </script>
</body>
</html>