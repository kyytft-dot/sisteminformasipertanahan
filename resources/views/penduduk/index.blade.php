<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Master Penduduk</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border: none;
            border-radius: 10px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .required::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-users me-2"></i>Data Master Penduduk
                            </h4>
                            <button class="btn btn-light" id="btnTambah">
                                <i class="fas fa-plus me-2"></i>Tambah Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablePenduduk" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Data Penduduk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formPenduduk">
                    <div class="modal-body">
                        <input type="hidden" id="penduduk_id">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">NIK</label>
                                <input type="text" class="form-control" id="nik" maxlength="16" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin">
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Alamat</label>
                            <textarea class="form-control" id="alamat" rows="2" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">RT</label>
                                <input type="text" class="form-control" id="rt" maxlength="3">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">RW</label>
                                <input type="text" class="form-control" id="rw" maxlength="3">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelurahan</label>
                                <input type="text" class="form-control" id="kelurahan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kota</label>
                                <input type="text" class="form-control" id="kota">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="telepon" maxlength="15">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status Perkawinan</label>
                                <select class="form-select" id="status_perkawinan">
                                    <option value="">Pilih</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Agama</label>
                                <input type="text" class="form-control" id="agama">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" placeholder="-6.xxx">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" placeholder="106.xxx">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Setup AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTable
            let table = $('#tablePenduduk').DataTable({
                ajax: {
                    url: '/penduduk/penduduk',
                    dataSrc: ''
                },
                columns: [
                    {
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    { data: 'nik' },
                    { data: 'nama' },
                    { data: 'jenis_kelamin' },
                    { 
                        data: 'tanggal_lahir',
                        render: (data) => data ? new Date(data).toLocaleDateString('id-ID') : '-'
                    },
                    { 
                        data: 'alamat',
                        render: (data) => data.length > 50 ? data.substring(0, 50) + '...' : data
                    },
                    { data: 'telepon' },
                    {
                        data: null,
                        render: (data) => `
                            <button class="btn btn-sm btn-info btnDetail" data-id="${data.id}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning btnEdit" data-id="${data.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btnHapus" data-id="${data.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        `
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }
            });

            // Tambah Data
            $('#btnTambah').click(function() {
                $('#modalTitle').text('Tambah Data Penduduk');
                $('#formPenduduk')[0].reset();
                $('#penduduk_id').val('');
                $('.is-invalid').removeClass('is-invalid');
                $('#modalForm').modal('show');
            });

            // Submit Form
            $('#formPenduduk').submit(function(e) {
                e.preventDefault();
                
                const id = $('#penduduk_id').val();
                const url = id ? `/penduduk/penduduk/${id}` : '/penduduk/penduduk';
                const method = id ? 'PUT' : 'POST';
                
                const data = {
                    nik: $('#nik').val(),
                    nama: $('#nama').val(),
                    tanggal_lahir: $('#tanggal_lahir').val(),
                    jenis_kelamin: $('#jenis_kelamin').val(),
                    alamat: $('#alamat').val(),
                    rt: $('#rt').val(),
                    rw: $('#rw').val(),
                    kelurahan: $('#kelurahan').val(),
                    kecamatan: $('#kecamatan').val(),
                    kota: $('#kota').val(),
                    provinsi: $('#provinsi').val(),
                    telepon: $('#telepon').val(),
                    email: $('#email').val(),
                    status_perkawinan: $('#status_perkawinan').val(),
                    pekerjaan: $('#pekerjaan').val(),
                    agama: $('#agama').val(),
                    latitude: $('#latitude').val(),
                    longitude: $('#longitude').val(),
                };

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        if(response.success) {
                            $('#modalForm').modal('hide');
                            table.ajax.reload();
                            Swal.fire('Berhasil!', response.message, 'success');
                        }
                    },
                    error: function(xhr) {
                        if(xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $('.is-invalid').removeClass('is-invalid');
                            
                            Object.keys(errors).forEach(key => {
                                $(`#${key}`).addClass('is-invalid')
                                    .siblings('.invalid-feedback').text(errors[key][0]);
                            });
                        } else {
                            Swal.fire('Error!', xhr.responseJSON.message, 'error');
                        }
                    }
                });
            });

            // Detail Data
            $('#tablePenduduk').on('click', '.btnDetail', function() {
                const id = $(this).data('id');
                
                $.get(`/penduduk/penduduk/${id}`, function(response) {
                    if(response.success) {
                        const d = response.data;
                        Swal.fire({
                            title: '<strong>Detail Penduduk</strong>',
                            html: `
                                <table class="table table-sm text-start">
                                    <tr><th>NIK</th><td>${d.nik}</td></tr>
                                    <tr><th>Nama</th><td>${d.nama}</td></tr>
                                    <tr><th>Tanggal Lahir</th><td>${d.tanggal_lahir || '-'}</td></tr>
                                    <tr><th>Jenis Kelamin</th><td>${d.jenis_kelamin || '-'}</td></tr>
                                    <tr><th>Alamat</th><td>${d.alamat}</td></tr>
                                    <tr><th>RT/RW</th><td>${d.rt || '-'}/${d.rw || '-'}</td></tr>
                                    <tr><th>Kelurahan</th><td>${d.kelurahan || '-'}</td></tr>
                                    <tr><th>Kecamatan</th><td>${d.kecamatan || '-'}</td></tr>
                                    <tr><th>Kota</th><td>${d.kota || '-'}</td></tr>
                                    <tr><th>Provinsi</th><td>${d.provinsi || '-'}</td></tr>
                                    <tr><th>Telepon</th><td>${d.telepon || '-'}</td></tr>
                                    <tr><th>Email</th><td>${d.email || '-'}</td></tr>
                                    <tr><th>Status Perkawinan</th><td>${d.status_perkawinan || '-'}</td></tr>
                                    <tr><th>Pekerjaan</th><td>${d.pekerjaan || '-'}</td></tr>
                                    <tr><th>Agama</th><td>${d.agama || '-'}</td></tr>
                                    <tr><th>Koordinat</th><td>${d.latitude || '-'}, ${d.longitude || '-'}</td></tr>
                                </table>
                            `,
                            width: 600
                        });
                    }
                });
            });

            // Edit Data
            $('#tablePenduduk').on('click', '.btnEdit', function() {
                const id = $(this).data('id');
                
                $.get(`/penduduk/penduduk/${id}`, function(response) {
                    if(response.success) {
                        const d = response.data;
                        $('#modalTitle').text('Edit Data Penduduk');
                        $('#penduduk_id').val(d.id);
                        $('#nik').val(d.nik);
                        $('#nama').val(d.nama);
                        $('#tanggal_lahir').val(d.tanggal_lahir);
                        $('#jenis_kelamin').val(d.jenis_kelamin);
                        $('#alamat').val(d.alamat);
                        $('#rt').val(d.rt);
                        $('#rw').val(d.rw);
                        $('#kelurahan').val(d.kelurahan);
                        $('#kecamatan').val(d.kecamatan);
                        $('#kota').val(d.kota);
                        $('#provinsi').val(d.provinsi);
                        $('#telepon').val(d.telepon);
                        $('#email').val(d.email);
                        $('#status_perkawinan').val(d.status_perkawinan);
                        $('#pekerjaan').val(d.pekerjaan);
                        $('#agama').val(d.agama);
                        $('#latitude').val(d.latitude);
                        $('#longitude').val(d.longitude);
                        
                        $('.is-invalid').removeClass('is-invalid');
                        $('#modalForm').modal('show');
                    }
                });
            });

            // Hapus Data
            $('#tablePenduduk').on('click', '.btnHapus', function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/penduduk/penduduk/${id}`,
                            method: 'DELETE',
                            success: function(response) {
                                if(response.success) {
                                    table.ajax.reload();
                                    Swal.fire('Terhapus!', response.message, 'success');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', xhr.responseJSON.message, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>