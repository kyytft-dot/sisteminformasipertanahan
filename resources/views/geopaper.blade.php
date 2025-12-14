<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GeoPaper - Info Provinsi</title>
<style>
  :root {
    --primary: #10b981;
    --primary-dark: #059669;
  }
  * { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif;}
  body {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    display:flex; justify-content:center; align-items:flex-start;
    min-height:100vh; padding:50px 10px;
  }
  .container {
    background:#fff; color:#333;
    border-radius:20px; padding:30px 40px;
    max-width:600px; width:100%;
    box-shadow:0 15px 40px rgba(0,0,0,0.2);
    animation:fadeIn 1s ease;
  }
  @keyframes fadeIn {from {opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);}}
  h1 {text-align:center; color:var(--primary-dark); margin-bottom:15px;}
  h3 {text-align:center; color:#1b5e20; margin-bottom:25px; font-weight:400;}
  select {
    width:100%; padding:12px; border-radius:10px; border:2px solid var(--primary);
    font-size:16px; margin-bottom:20px; outline:none; transition:0.3s;
  }
  select:focus {border-color:var(--primary-dark); box-shadow:0 0 10px rgba(16, 185, 129, 0.4);}
  .info-card {
    background:#e8f5e9; border-left:5px solid var(--primary);
    border-radius:12px; padding:15px; margin-bottom:20px;
    display:flex; justify-content:space-between; align-items:center;
    transition:0.3s;
  }
  .info-card:hover {transform:translateY(-5px); box-shadow:0 8px 20px rgba(0,0,0,0.1);}
  .info-card span {font-weight:600; color:var(--primary-dark); font-size:18px;}
  .counter {
    text-align:center; background:#c8e6c9; color:var(--primary-dark);
    padding:15px 20px; border-radius:15px; font-weight:600; font-size:18px;
    margin-bottom:25px; animation:pulse 1.5s infinite;
  }
  @keyframes pulse {
    0% {transform:scale(1); opacity:0.8;}
    50% {transform:scale(1.05); opacity:1;}
    100% {transform:scale(1); opacity:0.8;}
  }
  .dashboard-btn {
    display:block; width:100%; text-align:center;
    text-decoration:none; padding:12px; border-radius:12px;
    background:var(--primary); color:#fff; font-weight:600;
    transition:0.3s;
  }
  .dashboard-btn:hover {background:var(--primary-dark); transform:scale(1.03);}
  .map-btn {
    display:block; width:100%; text-align:center;
    text-decoration:none; padding:12px; border-radius:12px;
    background:#f0fdf4; color:var(--primary-dark); font-weight:600; border:2px solid var(--primary);
    margin-bottom:15px; transition:0.3s;
  }
  .map-btn:hover {background:var(--primary); color:#fff; transform:scale(1.03);}
</style>
</head>
<body>
<div class="container">
  <h1>🌿 GeoPaper</h1>
  <h3>Informasi Provinsi Indonesia</h3>

  <select id="provinsi">
    <option value="">-- Pilih Provinsi --</option>
  </select>

  <div class="info-card">
    <div>Ibu Kota:</div>
    <span id="ibukota">-</span>
  </div>

  <div class="info-card">
    <div>Status Provinsi:</div>
    <span id="status">Pilih provinsi untuk melihat info</span>
  </div>

  <div class="info-card">
    <div>Luas Wilayah:</div>
    <span id="luas">-</span>
  </div>

  <div class="info-card">
    <div>Jumlah Penduduk:</div>
    <span id="penduduk">-</span>
  </div>

  <div class="counter">Jumlah Provinsi: <span id="counter">0</span></div>

  <a href="#" class="map-btn" id="viewMapBtn">🗺️ Lihat Peta Provinsi</a>

  <a href="/" class="dashboard-btn">🏠 Kembali ke Dashboard</a>
</div>

<script>
const dataProvinsi = [
{nama:"Aceh", ibukota:"Banda Aceh", luas:"57.956 km²", penduduk:"5,3 juta"},
{nama:"Sumatera Utara", ibukota:"Medan", luas:"72.981 km²", penduduk:"14,9 juta"},
{nama:"Sumatera Barat", ibukota:"Padang", luas:"42.013 km²", penduduk:"5,5 juta"},
{nama:"Riau", ibukota:"Pekanbaru", luas:"87.024 km²", penduduk:"6,6 juta"},
{nama:"Jambi", ibukota:"Jambi", luas:"50.058 km²", penduduk:"3,6 juta"},
{nama:"Sumatera Selatan", ibukota:"Palembang", luas:"91.592 km²", penduduk:"8,7 juta"},
{nama:"Bengkulu", ibukota:"Bengkulu", luas:"19.919 km²", penduduk:"2,0 juta"},
{nama:"Lampung", ibukota:"Bandar Lampung", luas:"34.624 km²", penduduk:"9,0 juta"},
{nama:"Kepulauan Bangka Belitung", ibukota:"Pangkalpinang", luas:"16.424 km²", penduduk:"1,5 juta"},
{nama:"Kepulauan Riau", ibukota:"Tanjung Pinang", luas:"8.202 km²", penduduk:"2,1 juta"},
{nama:"DKI Jakarta", ibukota:"Jakarta", luas:"664 km²", penduduk:"10,6 juta"},
{nama:"Jawa Barat", ibukota:"Bandung", luas:"35.378 km²", penduduk:"49,0 juta"},
{nama:"Jawa Tengah", ibukota:"Semarang", luas:"32.801 km²", penduduk:"36,5 juta"},
{nama:"DI Yogyakarta", ibukota:"Yogyakarta", luas:"3.186 km²", penduduk:"3,7 juta"},
{nama:"Jawa Timur", ibukota:"Surabaya", luas:"47.800 km²", penduduk:"40,7 juta"},
{nama:"Banten", ibukota:"Serang", luas:"9.663 km²", penduduk:"12,0 juta"},
{nama:"Bali", ibukota:"Denpasar", luas:"5.780 km²", penduduk:"4,3 juta"},
{nama:"Nusa Tenggara Barat", ibukota:"Mataram", luas:"18.572 km²", penduduk:"5,3 juta"},
{nama:"Nusa Tenggara Timur", ibukota:"Kupang", luas:"48.718 km²", penduduk:"5,4 juta"},
{nama:"Kalimantan Barat", ibukota:"Pontianak", luas:"147.307 km²", penduduk:"5,4 juta"},
{nama:"Kalimantan Tengah", ibukota:"Palangka Raya", luas:"153.565 km²", penduduk:"2,7 juta"},
{nama:"Kalimantan Selatan", ibukota:"Banjarmasin", luas:"38.744 km²", penduduk:"4,1 juta"},
{nama:"Kalimantan Timur", ibukota:"Samarinda", luas:"129.067 km²", penduduk:"3,8 juta"},
{nama:"Kalimantan Utara", ibukota:"Tanjung Selor", luas:"75.468 km²", penduduk:"0,7 juta"},
{nama:"Sulawesi Utara", ibukota:"Manado", luas:"13.852 km²", penduduk:"2,6 juta"},
{nama:"Sulawesi Tengah", ibukota:"Palu", luas:"61.841 km²", penduduk:"3,0 juta"},
{nama:"Sulawesi Selatan", ibukota:"Makassar", luas:"46.717 km²", penduduk:"9,1 juta"},
{nama:"Sulawesi Tenggara", ibukota:"Kendari", luas:"38.068 km²", penduduk:"2,7 juta"},
{nama:"Gorontalo", ibukota:"Gorontalo", luas:"11.257 km²", penduduk:"1,2 juta"},
{nama:"Sulawesi Barat", ibukota:"Mamuju", luas:"16.787 km²", penduduk:"1,4 juta"},
{nama:"Maluku", ibukota:"Ambon", luas:"46.914 km²", penduduk:"1,9 juta"},
{nama:"Maluku Utara", ibukota:"Sofifi", luas:"31.983 km²", penduduk:"1,3 juta"},
{nama:"Papua", ibukota:"Jayapura", luas:"319.036 km²", penduduk:"4,4 juta"},
{nama:"Papua Barat", ibukota:"Manokwari", luas:"97.024 km²", penduduk:"1,1 juta"},
{nama:"Papua Tengah", ibukota:"Nabire", luas:"61.073 km²", penduduk:"1,2 juta"},
{nama:"Papua Pegunungan", ibukota:"Wamena", luas:"43.016 km²", penduduk:"1,4 juta"},
{nama:"Papua Selatan", ibukota:"Merauke", luas:"127.280 km²", penduduk:"0,5 juta"},
{nama:"Papua Barat Daya", ibukota:"Sorong", luas:"39.123 km²", penduduk:"0,6 juta"}
];

const selectProv = document.getElementById('provinsi');
const ibukotaEl = document.getElementById('ibukota');
const statusEl = document.getElementById('status');
const luasEl = document.getElementById('luas');
const pendudukEl = document.getElementById('penduduk');
const viewMapBtn = document.getElementById('viewMapBtn');

// isi dropdown
dataProvinsi.forEach(p=>{
  const opt = document.createElement('option');
  opt.value=p.nama;
  opt.textContent=p.nama;
  selectProv.appendChild(opt);
});

// animasi angka jumlah provinsi
const counterEl = document.getElementById('counter');
let count=0;
const totalProv=dataProvinsi.length;
const animate = setInterval(()=>{
  counterEl.textContent=count;
  count++;
  if(count>totalProv) clearInterval(animate);
},60);

// event interaktif
selectProv.addEventListener('change', e=>{
  const prov = dataProvinsi.find(p=>p.nama===e.target.value);
  if(prov){
    ibukotaEl.textContent = prov.ibukota;
    luasEl.textContent = prov.luas;
    pendudukEl.textContent = prov.penduduk;
    statusEl.textContent = `Provinsi ${prov.nama} siap diakses! ✅`;
    statusEl.style.color="#10b981";
    viewMapBtn.href = `map.html?prov=${encodeURIComponent(prov.nama)}`; // Link ke halaman peta (asumsi ada halaman map.html)
  } else {
    ibukotaEl.textContent = "-";
    luasEl.textContent = "-";
    pendudukEl.textContent = "-";
    statusEl.textContent = "Pilih provinsi untuk melihat info";
    statusEl.style.color="#555";
    viewMapBtn.href = "#";
  }
});
</script>
</body>
</html>
