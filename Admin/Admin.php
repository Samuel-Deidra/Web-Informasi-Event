<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Halaman Admin - Final</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/Admin.css">
    <!-- Flatpickr CSS untuk date picker modern -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- TAMBAHKAN CSS UNTUK KATEGORI BUBBLE -->
    <style>
        /* Gaya untuk bubble kategori di tabel admin */
        .category-bubble {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #fff;
            text-align: center;
        }
        
        /* Warna untuk setiap kategori */
        .category-seminar { background-color: rgba(0, 123, 255, 0.8); } /* Biru Transparan */
        .category-workshop { background-color: rgba(40, 167, 69, 0.8); } /* Hijau Transparan */
        .category-festival { background-color: rgba(253, 126, 20, 0.8); } /* Orange Transparan */
        .category-konser { background-color: rgba(111, 66, 193, 0.8); } /* Ungu Transparan */
        .category-pameran { background-color: rgba(220, 53, 69, 0.8); } /* Merah Transparan */
        .category-kompetisi { background-color: rgba(25, 135, 84, 0.8); } /* Hijau Tua Transparan */
        .category-default { background-color: rgba(108, 117, 125, 0.8); } /* Abu-abu Transparan */
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand-menu">Menu</div>
        <a href="#" class="nav-item active"><i class="fa-solid fa-calendar-days"></i><span>Event</span></a>
        <a href="#" class="nav-item" id="menuHistory"><i class="fa-regular fa-clock"></i><span>History</span></a>
        <a href="../Mahasiswa/Mahasiswa.php" class="nav-item"><i
                class="fa-solid fa-arrow-left"></i><span>Keluar</span></a>
        <hr style="border-color:rgba(255,255,255,0.1);margin:16px 0;">
        <button class="add-event"><i class="fa-solid fa-plus"></i>Tambah Event</button>
    </aside>

    <!-- CONTENT -->
    <main class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="title">
                <img src="../Foto/logopoltektransparan.png" alt="logo" style="height:34px; border-radius:5px;">
                Halaman Admin
            </div>
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="searchInput" type="text" placeholder="Cari Disini">
            </div>
        </div>

        <!-- FILTERS -->
        <div class="filter-row d-flex align-items-center gap-3 mb-3">
            <div>
                <label class="form-label fw-semibold small mb-1">Tanggal</label>
                <input type="date" id="filterTanggal" class="form-control form-control-sm">
            </div>

            <div>
                <label class="form-label fw-semibold small mb-1">Kategori</label>
                <select id="filterKategori" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option>Konser</option>
                    <option>Festival</option>
                    <option>Pameran</option>
                    <option>Workshop</option>
                    <option>Seminar</option>
                    <option>Kompetisi</option>
                </select>
            </div>

            <div>
                <label class="form-label fw-semibold small mb-1">Status</label>
                <select id="filterStatus" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option>Pendaftaran dibuka</option>
                    <option>Akan Datang</option>
                    <option>Sedang Berlangsung</option>
                    <option>Selesai</option>
                </select>
            </div>
        </div>

        <!-- EVENT PAGE -->
        <div id="eventPage">
            <!-- TABLE -->
            <div class="table-box">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Peserta</th>
                            <th>Kategori</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="eventTbody">
                        <!-- Data akan dimuat dari database -->
                        <tr class="loading-container">
                            <td colspan="8">
                                <div class="spinner"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- HISTORY PAGE -->
        <div id="historyPage" class="d-none">
            <!-- TABLE HISTORY -->
            <div class="table-box">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Peserta</th>
                            <th>Kategori</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="historyTbody">
                        <!-- Data akan dimuat dari database -->
                        <tr class="loading-container">
                            <td colspan="8">
                                <div class="spinner"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- MODAL TAMBAH EVENT -->
    <div class="modal fade" id="addEventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Event Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- STEP 1 -->
                    <form id="formStep1">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pendaftaran</label>
                            <!-- Date range hotel style -->
                            <input type="text" class="form-control" id="tanggalPendaftaranRange"
                                placeholder="Pilih rentang tanggal pendaftaran" required>
                            <input type="hidden" id="tanggalPendaftaranAwal" name="tanggal_pendaftaran_awal">
                            <input type="hidden" id="tanggalPendaftaranAkhir" name="tanggal_pendaftaran_akhir">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Event</label>
                            <input type="text" class="form-control" id="tanggalEventRange"
                                placeholder="Pilih rentang tanggal event" required>
                            <input type="hidden" id="tanggalEvent" name="tanggal_event">
                            <input type="hidden" id="tanggalEventAkhir" name="tanggal_event_akhir">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo Event (JPG/PNG, max 10MB)</label>
                            <input type="file" class="form-control" id="logoEvent" accept=".jpg,.jpeg,.png" required>
                            <img id="previewLogo" alt="Preview Logo">
                            <div id="fileWarning" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Event</label>
                            <input type="text" class="form-control" id="namaEvent" placeholder="Masukkan nama event"
                                required>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Biaya</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="biaya" placeholder="0" min="0">
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Peserta</label>
                                <select class="form-select" id="peserta">
                                    <option value="Mahasiswa">Mahasiswa</option>
                                    <option value="Umum">Umum</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Jam Event</label>
                                <input type="time" class="form-control" id="jamEvent" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Kategori Event</label>
                                <select class="form-select" id="kategoriEvent">
                                    <option value="Konser">Konser</option>
                                    <option value="Festival">Festival</option>
                                    <option value="Pameran">Pameran</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Seminar">Seminar</option>
                                    <option value="Kompetisi">Kompetisi</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-danger px-3" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary px-3" id="nextStep">Lanjut</button>
                        </div>
                    </form>

                    <!-- STEP 2 -->
                    <form id="formStep2" class="d-none">
                        <div class="mb-2">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" placeholder="Masukkan lokasi event">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tautan</label>
                            <input type="text" class="form-control" id="tautan" placeholder="Masukkan link (opsional)">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Deskripsi Event</label>
                            <textarea class="form-control" id="deskripsi" rows="4"
                                placeholder="Tuliskan deskripsi event..."></textarea>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-warning text-dark px-3" id="backStep">Kembali</button>
                            <button type="submit" class="btn btn-success px-3">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT EVENT -->
    <div class="modal fade" id="editEventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- STEP 1 -->
                    <form id="editFormStep1">
                        <input type="hidden" id="editEventId">

                        <div class="mb-3">
                            <label class="form-label">Tanggal Pendaftaran</label>
                            <!-- Date range hotel style untuk edit event -->
                            <input type="text" class="form-control" id="editTanggalPendaftaranRange"
                                placeholder="Pilih rentang tanggal pendaftaran" required>
                            <input type="hidden" id="editTanggalPendaftaranAwal" name="tanggal_pendaftaran_awal">
                            <input type="hidden" id="editTanggalPendaftaranAkhir" name="tanggal_pendaftaran_akhir">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Event</label>
                            <input type="text" class="form-control" id="editTanggalEventRange"
                                placeholder="Pilih rentang tanggal event" required>
                            <input type="hidden" id="editTanggalEvent" name="tanggal_event">
                            <input type="hidden" id="editTanggalEventAkhir" name="tanggal_event_akhir">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo Event (JPG/PNG, max 10MB)</label>
                            <input type="file" class="form-control" id="editLogoEvent" accept=".jpg,.jpeg,.png">
                            <img id="previewEditLogo" alt="Preview Logo">
                            <div id="editFileWarning" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Event</label>
                            <input type="text" class="form-control" id="editNamaEvent" placeholder="Masukkan nama event"
                                required>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Biaya</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="editBiaya" placeholder="0" min="0">
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Peserta</label>
                                <select class="form-select" id="editPeserta">
                                    <option value="Mahasiswa">Mahasiswa</option>
                                    <option value="Umum">Umum</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Jam Event</label>
                                <input type="time" class="form-control" id="editJamEvent" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Kategori Event</label>
                                <select class="form-select" id="editKategoriEvent">
                                    <option value="Konser">Konser</option>
                                    <option value="Festival">Festival</option>
                                    <option value="Pameran">Pameran</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Seminar">Seminar</option>
                                    <option value="Kompetisi">Kompetisi</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-danger px-3" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary px-3" id="editNextStep">Lanjut</button>
                        </div>
                    </form>

                    <!-- STEP 2 -->
                    <form id="editFormStep2" class="d-none">
                        <div class="mb-2">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="editLokasi" placeholder="Masukkan lokasi event">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tautan</label>
                            <input type="text" class="form-control" id="editTautan"
                                placeholder="Masukkan link (opsional)">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Deskripsi Event</label>
                            <textarea class="form-control" id="editDeskripsi" rows="4"
                                placeholder="Tuliskan deskripsi event..."></textarea>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-warning text-dark px-3"
                                id="editBackStep">Kembali</button>
                            <button type="submit" class="btn btn-success px-3">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE CONFIRMATION -->
    <div class="modal fade delete-modal" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="delete-icon">
                        <i class="fa-solid fa-trash"></i>
                    </div>
                    <h5 class="modal-title">Hapus Event?</h5>
                    <p class="modal-text">Apakah Anda yakin ingin menghapus event "<span id="deleteEventName"></span>"?
                        Tindakan
                        ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn-delete" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container for Success Notification -->
    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="../javascript/Admin.js"></script>
</body>

</html>