<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --card-border: rgba(255, 255, 255, 0.1);
            --text: #f1f5f9;
            --text-light: #cbd5e1;
            --accent: #10b981;
        }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', 'Tailwind', sans-serif;
        }
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .3);
        }
    </style>
</head>
<body class="p-4">
    <div class="min-h-screen">
        <div class="max-w-4xl mx-auto grid grid-cols-12 gap-6">
            <div class="col-span-8">
                <div class="glass-card p-6">
                    <h2 class="text-2xl font-bold mb-4">Pengaturan Akun</h2>
                    <p class="text-sm text-gray-300">Kelola informasi akun Anda dan pengaturan bahasa.</p>
                    <div class="mt-6">
                        <h4 class="font-semibold">Profil</h4>
                        <form id="profileForm" class="mt-3">
                            <div class="mb-3"><label class="block text-sm">Nama</label><input id="p_name" class="w-full p-2 rounded bg-white/5" value="{{ auth()->user()->name }}" /></div>
                            <div class="mb-3"><label class="block text-sm">Email</label><input id="p_email" class="w-full p-2 rounded bg-white/5" value="{{ auth()->user()->email }}" /></div>
                            <div><button type="submit" class="px-4 py-2 bg-emerald-500 rounded">Simpan Profil</button></div>
                        </form>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-semibold">Ganti Password</h4>
                        <form id="passwordForm" class="mt-3">
                            <div class="mb-3"><label class="block text-sm">Password Saat Ini</label><input id="cur_pass" type="password" class="w-full p-2 rounded bg-white/5" /></div>
                            <div class="mb-3"><label class="block text-sm">Password Baru</label><input id="new_pass" type="password" class="w-full p-2 rounded bg-white/5" /></div>
                            <div class="mb-3"><label class="block text-sm">Ulangi Password</label><input id="new_pass_confirm" type="password" class="w-full p-2 rounded bg-white/5" /></div>
                            <div><button type="submit" class="px-4 py-2 bg-amber-500 rounded">Ganti Password</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-span-4">
                <div class="glass-card p-6">
                    <h3 class="text-lg font-bold">Pengaturan Lainnya</h3>
                    <div class="mt-4">
                        <label class="block text-sm mb-2">Bahasa</label>
                        <select id="lang" class="w-full p-2 rounded bg-white/5">
                            <option value="id">Bahasa Indonesia</option>
                            <option value="en">English</option>
                        </select>
                        <div class="mt-4"><button id="btn-lang" class="px-4 py-2 bg-sky-500 rounded">Ubah Bahasa</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getCsrfToken(){
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        document.getElementById('profileForm').addEventListener('submit', async function(e){
            e.preventDefault();
            const name = document.getElementById('p_name').value;
            const email = document.getElementById('p_email').value;
            try{
                const res = await fetch('/pengaturan/profile', { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN': getCsrfToken()}, body: JSON.stringify({ name, email }) });
                if(!res.ok) throw new Error('Gagal');
                alert('Profil diperbarui');
            }catch(e){ alert('Error: '+e.message); }
        });

        document.getElementById('passwordForm').addEventListener('submit', async function(e){
            e.preventDefault();
            const current_password = document.getElementById('cur_pass').value;
            const password = document.getElementById('new_pass').value;
            const password_confirmation = document.getElementById('new_pass_confirm').value;
            try{
                const res = await fetch('/pengaturan/password', { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN': getCsrfToken()}, body: JSON.stringify({ current_password, password, password_confirmation }) });
                if(!res.ok) throw new Error('Gagal update password');
                alert('Password berhasil diubah');
            }catch(e){ alert('Error: '+e.message); }
        });

        document.getElementById('btn-lang').addEventListener('click', async () => {
            const lang = document.getElementById('lang').value;
            try{
                const res = await fetch('/pengaturan/lang', { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN': getCsrfToken()}, body: JSON.stringify({ lang }) });
                if(!res.ok) throw new Error('Gagal ubah bahasa');
                // Reload halaman utama (dashboard) agar bahasa berubah di semua tempat
                if(window.parent && window.parent !== window){
                    window.parent.location.reload();
                } else {
                    window.location.reload();
                }
            }catch(e){ alert('Error: '+e.message); }
        });
    </script>
</body>
</html>
