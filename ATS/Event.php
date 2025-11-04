<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Event.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="">Event</a></li>
                <li><a href="calender.php">Calendar</a></li>
            </ul>
            <div class="icon-user">
                <a href="Login_page.php"><i class="fa-solid fa-user"></i></a>
            </div>
        </div>
    </nav>
        <!-- Filter Bar -->
        <section class="event-container">
        <div class="filter-bar">
            <select id="yearFilter">
                <option value="">Tahun</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
            </select>
            <select id="statusFilter">
                <option value="">Status</option>
                <option value="Akan Datang">Akan Datang</option>
                <option value="Selesai">Selesai</option>
                <option value="Pendaftaran Dibuka">Pendaftaran Dibuka</option>
                <option value="Sedang Berlangsung">Sedang Berlangsung</option>
            </select>
            <select id="typeFilter">
                <option value="">Jenis</option>
                <option value="Seminar">Seminar</option>
                <option value="Pameran">Pameran</option>
                <option value="Festival">Festival</option>
                <option value="Konser">Konser</option>
            </select>
            <div class="search-box">
            <i class="fa fa-search"></i>
            <input type="text" id="searchInput"  placeholder="Pencarian Nama Event">
            </div>
            <button onclick="applyFilters()">Cari</button>
        </div>

        <!-- Tabel Event -->
        <div class="event-list">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th></th>
                        <th>Event</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Jenis</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh data -->
                    <tr class="data-row" data-year="2025" data-status="Akan Datang" data-type="Pameran">
                       <td>19-21 Desember 2025</td>
                        <td><img src="jobfair.jpg" alt=""></td>
                        <td>Job Fair 2025</td>
                        <td>0</td>
                        <td><span class="status datang">Akan Datang</span></td>
                        <td>Pameran</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                                <p><strong>Lokasi : </strong>Lobby gedung utama politeknik negeri batam</p><br>
                                 <p><strong>Link : </strong>
                <a href="https://www.jobfair2025.com" target="_blank">https://www.jobfair2025.com</a>
            </p><br>
                                <p><strong>Deskripsi : </strong>Pameran lowongan kerja dan magang dari berbagai perusahaan nasional dan startup</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="data-row" data-year="2025" data-status="Pendaftaran Dibuka" data-type="Festival">
                        <td>23-09 November 2025</td>
                        <td><img src="fair.jpg"></td>
                        <td>HMTI FAIR 2025</td>
                        <td>Rp 30.000</td>
                        <td><span class="status dibuka">Pendaftaran Dibuka</span></td>
                        <td>Festival</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                               <p><strong>Lokasi : </strong>parkiran techno preneur politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>
                <a href="https://www.nightmusic.com" target="_blank">https://www.nightmusic.com</a>
            </p><br>
                                <p><strong>Deskripsi : </strong>HMTI FAIR 2025 adalah ajang tahunan Himpunan Mahasiswa Teknik Informatika Polibatam dengan tema “Exploring Infinite Space, Beyond the Horizon.” Kegiatan ini menghadirkan berbagai lomba seru seperti Short Movie, Capture The Flag, Graphic Design, Photography, PES, dan Mobile Legends untuk siswa SMA/SMK/MA se-Kepri.</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="data-row" data-year="2025" data-status="Akan Datang" data-type="Konser">
                       <td>19-21 Desember 2025</td>
                        <td><img src="musc.jpg"></td>
                        <td>Campus Music night 2025</td>
                        <td>Rp150.000</td>
                        <td><span class="status datang">Akan Datang</span></td>
                        <td>Konser</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                                <p><strong>Lokasi : </strong>parkiran techno preneur politeknik negeri batam</p><br>
                               <p><strong>Link : </strong>
                <a href="https://www.jobfair2025.com" target="_blank">https://www.jobfair2025.com</a>
            </p><br>
                                <p><strong>Deskripsi : </strong>konser music tahunan dengan penampilan band kapus dan bintang tamu</p>
                            </div>
                        </td>
                    </tr>
                    
                     <tr class="data-row" data-year="2024" data-status="Selesai" data-type="Festival">
                        <td>21-23 November 2024</td>
                        <td><img src="energi.jpg"></td>
                        <td>ENERGI FESTIVAL</td>
                        <td>Rp 200.000</td>
                        <td><span class="status ditutup">Selesai</span></td>
                        <td>Festival</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                               <p><strong>Lokasi : </strong>Lapangan Futsal Polibatam</p><br>
                                <p><strong>Link : </strong>
                <a href="https://www.paskibpoltek.com" target="_blank">https://www.paskibpoltek.com</a>
            </p><br>
                                <p><strong>Deskripsi : </strong>Lomba Paskibra merupakan ajang untuk mengasah kedisiplinan, kekompakan, dan semangat cinta tanah air bagi siswa-siswi SMA/SMK/sederajat. Dengan tema “Paskibra Jaya: Prestisi, Disiplin, dan Cinta Tanah Air”, kegiatan ini diadakan di Lapangan Futsal Polibatam. Biaya pendaftaran sebesar Rp 200.000 per tim.</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="data-row" data-year="2025" data-status="Sedang Berlangsung" data-type="Pameran">
                        <td>01-10 November 2025</td>
                        <td><img src="pbl expo.jpg"></td>
                        <td>PBL EXPO 2025</td>
                        <td>Rp 20.000</td>
                        <td><span class="status mulai">Sedang Berlangsung</span></td>
                        <td>Pameran</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                               <p><strong>Lokasi : </strong>Gedung Traine Politeknik Negeri Batam</p><br>
                               <p><strong>Link : </strong>
                <a href="https://www.pblpoltek.com" target="_blank">https://www.pblpoltek.com</a>
            </p><br>
                                <p><strong>Deskripsi : </strong>Pameran karya proyek PBL mahasiswa. Akan ada penilaian dan hadiah untuk karya terbaik. Cukup dengan Rp20.000 per tim, kamu sudah bisa ikut berpartisipasi.</p>
                            </div>
                        </td>
                    </tr>
                    <tr class="data-row" data-year="2024" data-status="Selesai" data-type="Pameran">
                        <td>20-23 Agustus 2024</td>
                        <td><img src="pblexpo.jpg"></td>
                        <td>PBL EXPO 2024</td>
                        <td>Rp 20.000</td>
                        <td><span class="status ditutup">Selesai</span></td>
                        <td>Pameran</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                               <p><strong>Lokasi : </strong>Gedung Traine Politeknik Negeri Batam</p><br>
                                <p><strong>Link : </strong>
                <a href="https://www.pblexpo25poltek.com" target="_blank">https://www.pblexpo25poltek.com</a>
            </p><br>
                                <p><strong>Deskripsi : </strong>PBL EXPO 2024 merupakan pameran karya mahasiswa
                                        Politeknik Negeri Batam hasil dari kegiatan Project Based Learning (PBL). Dalam
                                        acara ini, berbagai proyek inovatif ditampilkan dan dinilai oleh juri.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <img src="logopoltektransparan.png" alt="logo" class="footer-logo">
            <div class="footer-info">
                <h2>Hubungi Kami</h2>
                <p>Politeknik Negeri Batam</p>
                <p>Jl. Ahmad Yani Batam Kota, Kota Batam, Kepulauan Riau, Indonesia.</p>
                <p>Whats App 0821-7255-7099</p>
                <p>Fax : +62-778-463620</p>
                <p>Email : info@polibatam.ac.id atau humas@polibatam.ac.id</p>
            </div>
        </div>
    </footer>

    <!-- Script -->
    <script>
        // === Toggle Deskripsi ===
        const rows = document.querySelectorAll('.data-row');
        rows.forEach(row => {
            row.addEventListener('click', () => {
                const descRow = row.nextElementSibling;
                const descBox = descRow.querySelector('.desc-box');

                document.querySelectorAll('.desc-box').forEach(box => {
                    if (box !== descBox) box.classList.remove('active');
                });

                descBox.classList.toggle('active');
            });
        });

        const yearFilter = document.getElementById('yearFilter');
    const statusFilter = document.getElementById('statusFilter');
    const typeFilter = document.getElementById('typeFilter');
    const searchInput = document.getElementById('searchInput');

    function applyFilters() {
        const yearVal = yearFilter.value.toLowerCase();
        const statusVal = statusFilter.value.toLowerCase();
        const typeVal = typeFilter.value.toLowerCase();
        const searchVal = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const descRow = row.nextElementSibling;
            const year = row.dataset.year.toLowerCase();
            const status = row.dataset.status.toLowerCase();
            const type = row.dataset.type.toLowerCase();
            const eventName = row.cells[2].textContent.toLowerCase();

            const matchYear = !yearVal || year === yearVal;
            const matchStatus = !statusVal || status === statusVal;
            const matchType = !typeVal || type === typeVal;
            const matchSearch = !searchVal || eventName.includes(searchVal);

            if (matchYear && matchStatus && matchType && matchSearch) {
                row.style.display = '';
                descRow.style.display = '';
            } else {
                row.style.display = 'none';
                descRow.style.display = 'none';
            }
        });
    }

    // Jalankan filter langsung saat input berubah
    [yearFilter, statusFilter, typeFilter].forEach(input => {
        input.addEventListener('input', applyFilters);
    });

    // Jalankan filter ketika tekan Enter di kolom search
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault(); // biar form tidak reload
            applyFilters();
        }
    });

    function resetFilter() {
        yearFilter.value = '';
        statusFilter.value = '';
        typeFilter.value = '';
        searchInput.value = '';
        applyFilters();
    }
    </script>
</body>

</html>