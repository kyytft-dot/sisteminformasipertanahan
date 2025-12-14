<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - SIPertanahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.8);
            --card-border: rgba(16, 185, 129, 0.2);
            --text: #f1f5f9;
            --text-light: #cbd5e1;
            --accent: #10b981;
            --accent-hover: #059669;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --warning: #f59e0b;
            --success: #10b981;
        }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 50px rgba(0, 0, 0, 0.5);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
        }
        .btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
        }
        .btn-danger {
            background: linear-gradient(135deg, var(--danger), var(--danger-hover));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-danger:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        .btn-edit {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-edit:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: var(--text);
            transition: all 0.3s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            background: rgba(255, 255, 255, 0.08);
        }
        .table-container {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1));
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
        }
        .table-row {
            transition: all 0.2s ease;
        }
        .table-row:hover {
            background: rgba(16, 185, 129, 0.05);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent);
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .brand-title {
            font-family: 'Orbitron', sans-serif;
            background: linear-gradient(135deg, var(--accent), #34d399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2rem;
            font-weight: 700;
        }
    </style>
</head>
<body class="p-6">
    <div class="min-h-screen fade-in">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="brand-title mb-2">User Management</h1>
                <p class="text-gray-400">Kelola pengguna sistem informasi pertanahan dengan mudah</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8">
                    <div class="glass-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-3xl font-bold flex items-center gap-3">
                                <i class="fas fa-users text-emerald-400"></i>
                                Daftar Pengguna
                            </h2>
                            <button id="btn-refresh" class="btn-primary flex items-center gap-2">
                                <i class="fas fa-sync-alt"></i>
                                <span id="refresh-text">Refresh</span>
                                <div id="loading-spinner" class="loading hidden ml-2"></div>
                            </button>
                        </div>

                        <div class="table-container">
                            <table class="w-full text-left">
                                <thead class="table-header">
                                    <tr class="text-sm font-semibold text-gray-200">
                                        <th class="px-6 py-4">#</th>
                                        <th class="px-6 py-4">Nama</th>
                                        <th class="px-6 py-4">Email</th>
                                        <th class="px-6 py-4">Role</th>
                                        <th class="px-6 py-4">Dibuat</th>
                                        <th class="px-6 py-4">Aksi</th>
                                    </tr>
                                </thead>
                            <tbody id="users-table" class="divide-y divide-white/10 text-sm">
                                <!-- Data will be loaded here -->
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="glass-card p-8">
                        <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                            <i class="fas fa-user-plus text-emerald-400"></i>
                            Tambah / Undang Pengguna
                        </h3>
                        <form id="user-form">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    Nama
                                </label>
                                <input type="text" id="name" class="input-field w-full" placeholder="Masukkan nama lengkap" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                    Email
                                </label>
                                <input type="email" id="email" class="input-field w-full" placeholder="email@domain.com" required />
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="fas fa-shield-alt text-gray-400"></i>
                                    Role
                                </label>
                                <select id="role" class="input-field w-full">
                                    <option value="user">👤 Pengguna</option>
                                    <option value="staff">👨‍💼 Petugas</option>
                                    <option value="admin">👑 Administrator</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="fas fa-lock text-gray-400"></i>
                                    Password (opsional)
                                </label>
                                <input type="password" id="password" class="input-field w-full" placeholder="Kosongkan untuk kirim undangan" />
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                                    <i class="fas fa-lock text-gray-400"></i>
                                    Ulangi Password
                                </label>
                                <input type="password" id="password_confirmation" class="input-field w-full" />
                            </div>
                            <div class="flex gap-3">
                                <button type="submit" class="btn-primary flex-1 flex items-center justify-center gap-2">
                                    <i class="fas fa-plus"></i>
                                    Buat
                                </button>
                                <button type="button" id="btn-invite" class="btn-secondary flex-1 flex items-center justify-center gap-2">
                                    <i class="fas fa-envelope"></i>
                                    Kirim Undangan
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 mt-4 flex items-start gap-2">
                                <i class="fas fa-info-circle mt-0.5"></i>
                                Jika password dikosongkan, sistem akan mengirim undangan via email (Mailtrap pada lingkungan dev).
                            </p>
                        </form>
                    </div>

                    <div class="glass-card p-6">
                        <h4 class="font-bold mb-4 flex items-center gap-2">
                            <i class="fas fa-lightbulb text-yellow-400"></i>
                            Petunjuk Mailtrap
                        </h4>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            Gunakan layanan Mailtrap untuk menangkap email test. Masukkan kredensial Mailtrap di file <code class="bg-gray-700 px-1 py-0.5 rounded text-xs">.env</code> (lihat README) lalu gunakan tombol "Kirim Undangan" untuk menerima email undangan di Mailtrap.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', ()=>{
            async function fetchUsers(){
                try{
                    const res = await fetch('/users/list',{headers:{'Accept':'application/json'}});
                    if(!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();
                    const tbody = document.getElementById('users-table');
                    tbody.innerHTML = data.map((u,i)=>`<tr class="text-sm"><td class="px-4 py-3">${i+1}</td><td class="px-4 py-3">${u.name}</td><td class="px-4 py-3">${u.email}</td><td class="px-4 py-3">${u.roles.join(', ')}</td><td class="px-4 py-3">${new Date(u.created_at).toLocaleString()}</td><td class="px-4 py-3"><button onclick="editUser(${u.id})" class="px-3 py-1 bg-blue-600 rounded text-sm mr-2">Edit</button><button onclick="deleteUser(${u.id})" class="px-3 py-1 bg-red-600 rounded text-sm">Hapus</button></td></tr>`).join('');
                }catch(e){ console.error(e); document.getElementById('users-table').innerHTML = '<tr><td colspan="5" class="text-center py-6">Gagal memuat pengguna</td></tr>'; }
            }

            document.getElementById('btn-refresh').addEventListener('click', fetchUsers);
            let editingId = null;
            document.getElementById('user-form').addEventListener('submit', async function(e){
                e.preventDefault();
                const payload = { name: document.getElementById('name').value, email: document.getElementById('email').value, role: document.getElementById('role').value, password: document.getElementById('password').value, password_confirmation: document.getElementById('password_confirmation').value };
                try{
                    let url = '/users'; let method = 'POST';
                    if (editingId) { url = '/users/' + editingId; method = 'PUT'; }
                    const res = await fetch(url,{ method, headers: {'Content-Type':'application/json','X-CSRF-TOKEN': getCsrfToken() }, body: JSON.stringify(payload) });
                    if(!res.ok) {
                        const txt = await res.text();
                        throw new Error('Gagal: '+res.status+' '+txt);
                    }
                    alert(editingId ? 'Pengguna diupdate.' : 'Pengguna dibuat (email undangan dikirim jika ada).');
                    editingId = null; resetForm(); fetchUsers();
                }catch(err){ alert('Error: '+err.message); }
            });

            window.editUser = function(id){
                fetch('/users/list',{headers:{'Accept':'application/json'}}).then(r=>r.json()).then(list=>{
                    const u = list.find(x=>x.id==id);
                    if(!u) return alert('User tidak ditemukan');
                    document.getElementById('name').value = u.name || '';
                    document.getElementById('email').value = u.email || '';
                    document.getElementById('role').value = (u.roles && u.roles[0]) || 'user';
                    editingId = id; ensureCancelButton();
                });
            }

            function ensureCancelButton(){
                if (document.getElementById('btn-cancel')) return;
                const btn = document.createElement('button');
                btn.id = 'btn-cancel'; btn.type='button'; btn.className='px-4 py-2 bg-gray-500 rounded text-white'; btn.textContent='Batal Edit';
                btn.addEventListener('click', ()=>{ editingId=null; resetForm(); btn.remove(); });
                document.querySelector('#user-form .flex').appendChild(btn);
            }

            function resetForm(){
                document.getElementById('name').value=''; document.getElementById('email').value=''; document.getElementById('password').value=''; document.getElementById('password_confirmation').value=''; document.getElementById('role').value='user';
            }

            window.deleteUser = async function(id){
                if(!confirm('Yakin hapus user ini?')) return;
                try{
                    const res = await fetch('/users/' + id, { method: 'DELETE', headers: {'X-CSRF-TOKEN': getCsrfToken() } });
                    if(!res.ok) throw new Error('Gagal: '+res.status);
                    alert('User dihapus'); fetchUsers();
                }catch(e){ alert('Error: '+e.message); }
            }

            document.getElementById('btn-invite').addEventListener('click', async function(){
                const email = document.getElementById('email').value;
                const name = document.getElementById('name').value;
                const role = document.getElementById('role').value;
                if(!email) return alert('Masukkan email untuk undangan');
                try{
                    const res = await fetch('/users/invite', { method:'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN': getCsrfToken() }, body: JSON.stringify({ email, name, role }) });
                    if(!res.ok) throw new Error('HTTP '+res.status);
                    alert('Undangan dikirim (cek Mailtrap).');
                    fetchUsers();
                }catch(e){ alert('Gagal kirim undangan: '+e.message); }
            });

            function getCsrfToken(){
                return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            }

            fetchUsers();
        });
    </script>
</body>
</html>
