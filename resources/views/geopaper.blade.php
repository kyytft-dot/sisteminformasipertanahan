<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GeoPaper - Info Provinsi</title>
<style>
  * { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif;}
  body {
    background: linear-gradient(135deg,#2e7d32,#4caf50);
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
  h1 {text-align:center; color:#2e7d32; margin-bottom:15px;}
  h3 {text-align:center; color:#1b5e20; margin-bottom:25px; font-weight:400;}
  select {
    width:100%; padding:12px; border-radius:10px; border:2px solid #4caf50;
    font-size:16px; margin-bottom:20px; outline:none; transition:0.3s;
  }
  select:focus {border-color:#1b5e20; box-shadow:0 0 10px rgba(76,175,80,0.4);}
  .info-card {
    background:#e8f5e9; border-left:5px solid #4caf50;
    border-radius:12px; padding:15px; margin-bottom:20px;
    display:flex; justify-content:space-between; align-items:center;
    transition:0.3s;
  }
  .info-card:hover {transform:translateY(-5px); box-shadow:0 8px 20px rgba(0,0,0,0.1);}
  .info-card span {font-weight:600; color:#1b5e20; font-size:18px;}
  .counter {
    text-align:center; background:#c8e6c9; color:#2e7d32;
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
    background:#4caf50; color:#fff; font-weight:600;
    transition:0.3s;
  }
  .dashboard-btn:hover {background:#2e7d32; transform:scale(1.03);}
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

  <div class="counter">Jumlah Provinsi: <span id="counter">0</span></div>

  <a href="\" class="dashboard-btn">🏠 Kembali ke Dashboard</a>
</div>

<script>
const dataProvinsi = [
{nama:"Aceh", ibukota:"Banda Aceh"},
{nama:"Sumatera Utara", ibukota:"Medan"},
{nama:"Sumatera Barat", ibukota:"Padang"},
{nama:"Riau", ibukota:"Pekanbaru"},
{nama:"Jambi", ibukota:"Jambi"},
{nama:"Sumatera Selatan", ibukota:"Palembang"},
{nama:"Bengkulu", ibukota:"Bengkulu"},
{nama:"Lampung", ibukota:"Bandar Lampung"},
{nama:"Kepulauan Bangka Belitung", ibukota:"Pangkalpinang"},
{nama:"Kepulauan Riau", ibukota:"Tanjung Pinang"},
{nama:"DKI Jakarta", ibukota:"Jakarta"},
{nama:"Jawa Barat", ibukota:"Bandung"},
{nama:"Jawa Tengah", ibukota:"Semarang"},
{nama:"DI Yogyakarta", ibukota:"Yogyakarta"},
{nama:"Jawa Timur", ibukota:"Surabaya"},
{nama:"Banten", ibukota:"Serang"},
{nama:"Bali", ibukota:"Denpasar"},
{nama:"Nusa Tenggara Barat", ibukota:"Mataram"},
{nama:"Nusa Tenggara Timur", ibukota:"Kupang"},
{nama:"Kalimantan Barat", ibukota:"Pontianak"},
{nama:"Kalimantan Tengah", ibukota:"Palangka Raya"},
{nama:"Kalimantan Selatan", ibukota:"Banjarmasin"},
{nama:"Kalimantan Timur", ibukota:"Samarinda"},
{nama:"Kalimantan Utara", ibukota:"Tanjung Selor"},
{nama:"Sulawesi Utara", ibukota:"Manado"},
{nama:"Sulawesi Tengah", ibukota:"Palu"},
{nama:"Sulawesi Selatan", ibukota:"Makassar"},
{nama:"Sulawesi Tenggara", ibukota:"Kendari"},
{nama:"Gorontalo", ibukota:"Gorontalo"},
{nama:"Sulawesi Barat", ibukota:"Mamuju"},
{nama:"Maluku", ibukota:"Ambon"},
{nama:"Maluku Utara", ibukota:"Sofifi"},
{nama:"Papua", ibukota:"Jayapura"},
{nama:"Papua Barat", ibukota:"Manokwari"},
{nama:"Papua Tengah", ibukota:"Nabire"},
{nama:"Papua Pegunungan", ibukota:"Wamena"},
{nama:"Papua Selatan", ibukota:"Merauke"},
{nama:"Papua Barat Daya", ibukota:"Sorong"}
];

const selectProv = document.getElementById('provinsi');
const ibukotaEl = document.getElementById('ibukota');
const statusEl = document.getElementById('status');

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
    statusEl.textContent = `Provinsi ${prov.nama} siap diakses! ✅`;
    statusEl.style.color="#2e7d32";
  } else {
    ibukotaEl.textContent = "-";
    statusEl.textContent = "Pilih provinsi untuk melihat info";
    statusEl.style.color="#555";
  }
});
</script>
</body>
</html>
