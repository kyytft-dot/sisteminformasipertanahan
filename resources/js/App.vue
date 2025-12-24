<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
              <div class="flex-shrink-0 flex items-center">
                <img src="/sbadmin/img/Logo_BPN-KemenATR_(2017).png" alt="ATR/BPN" class="h-10 w-auto">
                <span class="ml-3 text-xl font-bold text-gray-800">GEOTERRAID</span>
              </div>
            </div>
          <div class="flex items-center space-x-4">
            <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
              <i class="fas fa-sign-in-alt mr-2"></i>Login Dashboard
            </a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
      <div class="absolute inset-0 bg-black opacity-20"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-black mb-6">
            Selamat Datang di
            <span class="block text-blue-300">GEOTERRAID</span>
          </h1>
          <p class="text-xl md:text-2xl font-light mb-8 max-w-3xl mx-auto">
            Sistem Informasi Pertanahan Terintegrasi Kementerian Agraria dan Tata Ruang / Badan Pertanahan Nasional
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/login" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-4 px-8 rounded-lg text-lg transition duration-200 shadow-lg">
              <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Dashboard
            </a>
            <button @click="scrollToFeatures" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-bold py-4 px-8 rounded-lg text-lg transition duration-200">
              <i class="fas fa-info-circle mr-2"></i>Pelajari Lebih Lanjut
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Fitur Utama Sistem</h2>
          <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            GEOTERRAID menyediakan berbagai fitur canggih untuk pengelolaan data pertanahan yang terintegrasi
          </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Feature 1 sampai 5 tetap sama -->
          <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <div class="bg-blue-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
              <i class="fas fa-map-marked-alt text-blue-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Peta Interaktif</h3>
            <p class="text-gray-600">Visualisasi data pertanahan dengan peta digital yang akurat dan mudah digunakan</p>
          </div>
          <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <div class="bg-green-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
              <i class="fas fa-database text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Manajemen Data</h3>
            <p class="text-gray-600">Pengelolaan data penduduk, polygon, polyline, dan marker dengan sistem yang terstruktur</p>
          </div>
          <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <div class="bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
              <i class="fas fa-chart-bar text-purple-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Laporan & Analitik</h3>
            <p class="text-gray-600">Generate laporan komprehensif dan analisis data untuk keperluan pengambilan keputusan</p>
          </div>
          <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <div class="bg-red-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
              <i class="fas fa-users text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Manajemen Pengguna</h3>
            <p class="text-gray-600">Sistem manajemen pengguna dengan role-based access control untuk keamanan data</p>
          </div>
          <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <div class="bg-yellow-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
              <i class="fas fa-bell text-yellow-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Notifikasi Real-time</h3>
            <p class="text-gray-600">Sistem notifikasi real-time untuk update data dan informasi penting</p>
          </div>
          <div class="bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <div class="bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
              <i class="fas fa-robot text-indigo-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Chatbot AI</h3>
            <p class="text-gray-600">Asisten virtual cerdas untuk membantu pengguna dalam mengakses informasi</p>
          </div>
        </div>
      </div>
    </div>

    <!-- About Section, CTA Section, Footer tetap sama seperti aslinya -->
    <!-- ... (copy-paste bagian About, CTA, dan Footer dari kode kamu sebelumnya) ... -->

    <!-- About Section -->
    <div class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Tentang GEOTERRAID</h2>
          <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Sistem informasi pertanahan modern yang dikembangkan untuk mendukung tugas-tugas Kementerian ATR/BPN
          </p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Teknologi Modern untuk Pengelolaan Pertanahan</h3>
            <p class="text-gray-600 mb-6">
              GEOTERRAID menggunakan teknologi terkini untuk memastikan pengelolaan data pertanahan yang akurat,
              efisien, dan dapat diakses oleh pihak yang berwenang.
            </p>
            <ul class="space-y-3">
              <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-gray-700">Sistem keamanan berlapis dengan autentikasi ganda</span>
              </li>
              <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-gray-700">Interface yang user-friendly dan responsif</span>
              </li>
              <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-gray-700">Integrasi dengan berbagai format data geografis</span>
              </li>
              <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-gray-700">Backup dan recovery otomatis</span>
              </li>
            </ul>
          </div>
          <div class="text-center">
            <img src="/sbadmin/img/Logo_BPN-KemenATR_(2017).png" alt="ATR/BPN Logo" class="mx-auto h-48 w-auto mb-8">
            <p class="text-gray-600 italic">
              "Melayani dengan Integritas, Profesionalitas, dan Inovasi"
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-blue-600 text-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Menggunakan GEOTERRAID?</h2>
        <p class="text-xl mb-8 opacity-90">
          Masuk ke dashboard untuk mengakses semua fitur sistem informasi pertanahan
        </p>
        <a href="/login" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-4 px-8 rounded-lg text-lg transition duration-200 shadow-lg inline-block">
          <i class="fas fa-sign-in-alt mr-2"></i>Masuk Sekarang
        </a>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div>
            <div class="flex items-center mb-4">
              <img src="/sbadmin/img/Logo_BPN-KemenATR_(2017).png" alt="ATR/BPN" class="h-10 w-auto mr-3">
              <span class="text-xl font-bold">GEOTERRAID</span>
            </div>
            <p class="text-gray-400">
              Sistem Informasi Pertanahan Terintegrasi Kementerian ATR/BPN
            </p>
          </div>
          <div>
            <h3 class="text-lg font-semibold mb-4">Kontak</h3>
            <p class="text-gray-400">
              Kementerian Agraria dan Tata Ruang<br>
              Badan Pertanahan Nasional<br>
              Republik Indonesia
            </p>
          </div>
          <div>
            <h3 class="text-lg font-semibold mb-4">Pengembang</h3>
            <p class="text-gray-400">
              Developed by Kementerian ATR/BPN<br>
              © 2025 All Rights Reserved
            </p>
          </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
          <p class="text-gray-400">
            Sistem ini hanya diperuntukkan bagi petugas resmi Kementerian ATR/BPN dan pihak yang telah mendapat izin akses.
          </p>
        </div>
      </div>
    </footer>

    <!-- === TAMBAHAN: Pop-up AI Assistant (Vue managed) === -->
    <!-- Logo AI kecil di kanan bawah -->
    <button
      @click="showModal = true"
      class="fixed bottom-6 right-6 z-50 w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform duration-300"
    >
      <i class="fas fa-robot text-2xl"></i>
    </button>

    <!-- Modal besar -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center"
    >
      <div
        class="absolute inset-0 bg-black bg-opacity-60"
        @click="showModal = false"
      ></div>

      <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-8 animate__animated animate__fadeInUp">
        <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
          <i class="fas fa-times text-2xl"></i>
        </button>

        <div class="text-center">
          <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-full flex items-center justify-center text-white">
            <i class="fas fa-robot text-4xl"></i>
          </div>
          <h2 class="text-3xl font-bold text-gray-800 mb-3">AI CS/Assistant</h2>
          <p class="text-gray-600 mb-8">
            Dapatkan bantuan instan untuk semua pertanyaan Anda tentang sistem pertanahan
          </p>

          <a
            href="/chatbot"
            class="inline-block px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-full hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300"
          >
            Coba Sekarang
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LandingPage', // sesuaikan nama jika perlu
  data() {
    return {
      showModal: false
    }
  },
  methods: {
    scrollToFeatures() {
      const element = document.getElementById('features');
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
      }
    }
  }
}
</script>

<style scoped>
/* Jika kamu pakai animate.css, pastikan sudah di-load di blade atau app.js */
.animate__animated {
  animation-duration: 0.5s;
}
.animate__fadeInUp {
  animation-name: fadeInUp;
}
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translate3d(0, 100%, 0);
  }
  to {
    opacity: 1;
    transform: translate3d(0, 0, 0);
  }
}
</style>