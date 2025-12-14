@extends('layouts.app')

@section('title', 'Pengaturan - SIPertanahan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cogs text-secondary"></i> Pengaturan Akun
        </h1>
        <span class="text-muted">Kelola profil dan preferensi Anda</span>
    </div>

    <div class="row">
        <!-- Profile Settings -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-circle"></i> Profil Pengguna
                    </h6>
                </div>
                <div class="card-body">
                    <form id="profileForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img id="profilePhotoPreview" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #dee2e6;" src="{{ auth()->user()->profile_photo_url }}" alt="Foto Profil">
                                <div class="form-group">
                                    <label for="profile_photo">Ubah Foto Profil</label>
                                    <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label-required">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ auth()->user()->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label-required">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="{{ auth()->user()->email }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="current_password_profile">Password Saat Ini (untuk konfirmasi)</label>
                                    <input type="password" class="form-control" id="current_password_profile"
                                           name="current_password" placeholder="Masukkan password saat ini">
                                    <small class="form-text text-muted">Diperlukan untuk mengubah data profil</small>
                                </div>
                                <button type="submit" class="btn btn-primary" id="saveProfileBtn">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Change -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-key"></i> Ubah Password
                    </h6>
                </div>
                <div class="card-body">
                    <form id="passwordForm">
                        @csrf
                        <div class="form-group">
                            <label for="current_password" class="form-label-required">Password Saat Ini</label>
                            <input type="password" class="form-control" id="current_password"
                                   name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label-required">Password Baru</label>
                            <input type="password" class="form-control" id="password"
                                   name="password" minlength="6" required>
                            <small class="form-text text-muted">Minimal 6 karakter</small>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label-required">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-warning" id="changePasswordBtn">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Language & Preferences -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-language"></i> Preferensi Bahasa
                    </h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="language">Bahasa Interface</label>
                        <select class="form-control" id="language">
                            <option value="id" {{ session('app_lang', 'id') == 'id' ? 'selected' : '' }}>
                                🇮🇩 Bahasa Indonesia
                            </option>
                            <option value="en" {{ session('app_lang', 'id') == 'en' ? 'selected' : '' }}>
                                🇬🇧 English
                            </option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-info btn-block" id="changeLanguageBtn">
                        <i class="fas fa-language"></i> Ubah Bahasa
                    </button>
                    <small class="form-text text-muted mt-2">
                        Perubahan bahasa akan diterapkan setelah halaman dimuat ulang
                    </small>
                </div>
            </div>

            <!-- Account Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-info-circle"></i> Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Role:</strong>
                        <span class="badge badge-primary ml-2">
                            {{ auth()->user()->getRoleNames()->first() ?? 'user' }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge badge-success ml-2">
                            {{ auth()->user()->is_approved ? 'Disetujui' : 'Pending' }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Bergabung:</strong>
                        <span class="text-muted">
                            {{ auth()->user()->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div class="mb-0">
                        <strong>Terakhir Login:</strong>
                        <span class="text-muted">
                            {{ auth()->user()->updated_at->format('d M Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageTitle">Pesan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="messageBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Profile Update
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#saveProfileBtn');
        const originalText = btn.html();

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: '{{ url("/profile") }}',
            method: 'PATCH',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Profil berhasil diperbarui.',
                    timer: 2000,
                    showConfirmButton: false
                });
                // Update sidebar name if changed
                if ($('#name').val() !== '{{ auth()->user()->name }}') {
                    $('.sidebar .text-gray-600').text($('#name').val());
                }
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan profil.';
                Swal.fire('Error!', error, 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Password Change
    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();

        if ($('#password').val() !== $('#password_confirmation').val()) {
            showMessage('Error!', 'Konfirmasi password tidak cocok.', 'error');
            return;
        }

        const btn = $('#changePasswordBtn');
        const originalText = btn.html();

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengubah...');

        $.ajax({
            url: '{{ url("/pengaturan/password") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                showMessage('Berhasil!', 'Password berhasil diubah.', 'success');
                $('#passwordForm')[0].reset();
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.message || 'Terjadi kesalahan saat mengubah password.';
                showMessage('Error!', error, 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Language Change
    $('#changeLanguageBtn').on('click', function() {
        const lang = $('#language').val();
        const btn = $(this);
        const originalText = btn.html();

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengubah...');

        $.ajax({
            url: '{{ url("/pengaturan/lang") }}',
            method: 'POST',
            data: { lang: lang, _token: '{{ csrf_token() }}' },
            success: function(response) {
                showMessage('Berhasil!', 'Bahasa berhasil diubah. Halaman akan dimuat ulang.', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.message || 'Terjadi kesalahan saat mengubah bahasa.';
                showMessage('Error!', error, 'error');
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    function showMessage(title, message, type = 'info') {
        $('#messageTitle').text(title);
        $('#messageBody').html(message);
        $('#messageModal').modal('show');
    }

    // Photo Upload Handler
    $('#profile_photo').on('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validate file size (2MB max)
        if (file.size > 2048 * 1024) {
            Swal.fire('Error!', 'Ukuran file maksimal 2MB.', 'error');
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire('Error!', 'Format file harus JPG, PNG, atau GIF.', 'error');
            return;
        }

        // Show preview immediately
        const reader = new FileReader();
        reader.onload = function(ev) {
            $('#profilePhotoPreview').attr('src', ev.target.result);
        };
        reader.readAsDataURL(file);

        // Upload to server
        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("profile.photo") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    const url = response.profile_photo_url;
                    $('#profilePhotoPreview').attr('src', url);

                    // Store updated photo URL in localStorage for other pages
                    localStorage.setItem('userProfilePhotoUrl', url);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Foto profil berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.message || 'Gagal mengupload foto.';
                Swal.fire('Error!', error, 'error');
                // Revert preview on error
                $('#profilePhotoPreview').attr('src', '{{ auth()->user()->profile_photo_url }}');
            }
        });
    });
});
</script>
@endpush
@endsection
