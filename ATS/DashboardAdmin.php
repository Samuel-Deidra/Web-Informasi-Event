<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <img src="cropped-cropped-01_Logo_1_Utama_Polibatam_Vertikal@2x.png" alt="logo" />
        </div>
        <h1>Web Informasi Event Kampus</h1>
        <div class="icon-user">
            <i class="fa-solid fa-user" id="userIcon"></i>
            <div class="dropdown-menu" id="logoutMenu">
                <a href="Login_page.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>

    <!-- Dashboard -->
    <main class="container">
        <div class="dashboard-header">
            <h1>🏠 Dashboard Admin</h1>
            <nav class="nav-tabs">
                <a href="#" id="tabEvent" class="active">Event</a>
                <a href="#" id="tabHistory">History</a>
            </nav>
        </div>

        <div class="table-container" id="tableActions" style="margin-bottom: 20px;">
            <div class="table-actions">
                <button class="add-btn" id="addEvent-Btn">+ Tambah Event</button>
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Cari Event..." />
                    <button id="searchBtn" class="search-btn">Cari</button>
                </div>
            </div>
        </div>
        
        <!-- EVENT SECTION -->
        <section class="event-container" id="eventSection">
            <div class="event-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Logo</th>
                            <th>Event</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Jenis</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Event 1 -->
                        <tr class="data-row">
                        <td>1</td>
                        <td>19-21 Desember</td>
                        <td><img src="jobfair.jpg" alt=""></td>
                        <td>Job Fair 2025</td>
                        <td>0</td>
                        <td><span class="status datang">Akan Datang</span></td>
                        <td>Pameran</td>
                            <td>
                            <button class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                <p><strong>Location : </strong>parkiran techno preneur politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>https://www.jobfair2025.com</p><br>
                                <p><strong>Deskripsi : </strong>Pameran lowongan kerja dan magang dari berbagai perusahaan nasional dan startup</p>
                                </div>
                            </td>
                        </tr>

                        <!-- Event 2 -->
                        <tr class="data-row">
                        <td>2</td>
                        <td>23-09 November</td>
                        <td><img src="fair.jpg"></td>
                        <td>HMTI FAIR 2025</td>
                        <td>Rp 30.000</td>
                        <td><span class="status dibuka">Pendaftaran Dibuka</span></td>
                        <td>Festival</td>
                            <td>
                            <button class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                    <p><strong>Location : </strong>parkiran techno preneur politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>https://www.nightmusic.com</p><br>
                                <p><strong>Deskripsi : </strong>konser music tahunan dengan penampilan band kapus dan bintang tamu</p><br>
                                </div>
                            </td>
                        </tr>

                        <!-- Event 3 -->
                        <tr class="data-row">
                        <td>3</td>
                        <td>19-21 Desember</td>
                        <td><img src="musc.jpg"></td>
                        <td>Campus Music night</td>
                        <td>Rp150.000</td>
                        <td><span class="status datang">Akan Datang</span></td>
                        <td>Konser</td>
                            <td>
                            <button class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                <p><strong>Location : </strong>Lapangan futsal politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>https://www.sportsdaypoltek.com</p><br>
                                <p><strong>Deskripsi : </strong>Turnamen olahraga antar-fakultas meliputi futsal, basket, badminton, dan e-sport.</p><br>
                            </td>
                        </tr>

                        <tr class="data-row">
                        <td>4</td>
                        <td>21-23 November</td>
                        <td><img src="energi.jpg"></td>
                        <td>ENERGI FESTIVAL</td>
                        <td>Rp 200.000</td>
                        <td><span class="status ditutup">Selesai</span></td>
                        <td>Festival</td>
                            <td>
                            <button class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                <p><strong>Location : </strong>Lapangan futsal politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>https://www.sportsdaypoltek.com</p><br>
                                <p><strong>Deskripsi : </strong>Turnamen olahraga antar-fakultas meliputi futsal, basket, badminton, dan e-sport.</p><br>
                            </td>
                        </tr>

                        <tr class="data-row">
                        <td>5</td>
                        <td>01-10 November</td>
                        <td><img src="pbl expo.jpg"></td>
                        <td>PBL EXPO 2025</td>
                        <td>Rp 20.000</td>
                        <td><span class="status mulai">Sedang Berlangsung</span></td>
                        <td>Pameran</td>
                            <td>
                            <button class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                <p><strong>Location : </strong>Lapangan futsal politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>https://www.sportsdaypoltek.com</p><br>
                                <p><strong>Deskripsi : </strong>Turnamen olahraga antar-fakultas meliputi futsal, basket, badminton, dan e-sport.</p><br>
                            </td>
                        </tr>
                        <tr class="data-row">
                        <td>6</td>
                        <td>20-23 Agustus</td>
                        <td><img src="pblexpo.jpg"></td>
                        <td>PBL EXPO 2024</td>
                        <td>Rp 20.000</td>
                        <td><span class="status ditutup">Selesai</span></td>
                        <td>Pameran</td>
                            <td>
                            <button class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                <p><strong>Location : </strong>Lapangan futsal politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>https://www.sportsdaypoltek.com</p><br>
                                <p><strong>Deskripsi : </strong>Turnamen olahraga antar-fakultas meliputi futsal, basket, badminton, dan e-sport.</p><br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Filter Bar -->
        <section class="event-container filter-event history-box" id="historyFilterBar">
        <div class="filter-bar">
  <div class="filter-left">
    <select id="yearFilter">
        <option value="">Tahun</option>
        <option value="2025">2025</option>
        <option value="2024">2024</option>
        <option value="2023">2023</option>
    </select>
    <select id="typeFilter">
        <option value="">Type</option>
        <option value="Seminar">Seminar</option>
        <option value="Workshop">Workshop</option>
        <option value="Festival">Festival</option>
    </select>
  </div>

  <div class="filter-right">
    <div class="search-box">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" placeholder="Cari Event..." />
        <button id="searchBtn" class="search-btn">Cari</button> 
    </div>
  </div>
</div>

        </section>
        <section class="history-container" id="historySection" style="display: none;">
            <h2>📜 Event History</h2>
            <p>Riwayat event yang sudah selesai atau ditutup</p>
            <!--History list-->
            <div class="history-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th></th>
                            <th>Event</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Jenis</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="history-data-row">
                            <td>126</td>
                            <td>20-23 Agustus 2024</td>
                            <td><img src="pblexpo.jpg"></td>
                            <td>PBL EXPO 2024</td>
                            <td>Rp 20.000</td>
                            <td><span class="status ditutup">Selesai</span></td>
                            <td>Pameran</td>
                            <td>
                            <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="history-desc-row">
                            <td colspan="9">
                                <div class="desc-box">
                                    <p><strong>Location : </strong>Gedung Traine Politeknik Negeri Batam
                                    </p>
                                    <p><strong>Link : </strong>https://www.pblexpo25poltek.com</p>
                                    <p><strong>Deskripsi : </strong>PBL EXPO 2024 merupakan pameran karya mahasiswa
                                        Politeknik Negeri Batam hasil dari kegiatan Project Based Learning (PBL). Dalam
                                        acara ini, berbagai proyek inovatif ditampilkan dan dinilai oleh juri.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr class="history-data-row">
                            <td>510</td>
                            <td>30 Desember 2024</td>
                            <td><img src="batassenja.jpg"></td>
                            <td>Konser Batas Senja Live at Poltek</td>
                            <td>Rp 50.000</td>
                            <td><span class="status ditutup">Selesai</span></td>
                            <td>Konser</td>
                            <td>
                            <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="history-desc-row">
                            <td colspan="9">
                                <div class="desc-box">
                                    <p><strong>Location : </strong>Depan Gedung Techno, Politeknik Negeri Batam
                                    </p>
                                    <p><strong>Link : </strong>https://www.konserpoltek.com</p>
                                    <p><strong>Deskripsi : </strong>Konser Batas Senja Live at Poltek menjadi penutup
                                        acara PBL EXPO 2024 yang meriah di Politeknik Negeri Batam. Acara ini
                                        menghadirkan penampilan seru dari band Batas Senja dan berhasil menarik banyak
                                        penonton, baik dari mahasiswa maupun umum.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr class="history-data-row">
                            <td>109</td>
                            <td>20 Agustus 2025</td>
                            <td><img src="summer art.jpg"></td>
                            <td>Summar Art Festival</td>
                            <td>0</td>
                            <td><span class="status ditutup">Selesai</span></td>
                            <td>Festival</td>
                            <td>
                            <button class="delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="history-desc-row">
                            <td colspan="9">
                                <div class="desc-box">
                                    <p><strong>Location : </strong> Depan Techno Politeknik Negeri Batam
                                    </p>
                                    <p><strong>Link : </strong>https://www.festivalpoltek.com </p>
                                    <p><strong>Deskripsi : </strong> Summer Art Festival 2025 adalah ajang seni tahunan yang diselenggarakan oleh Unit Kegiatan Mahasiswa Kuas Polibatam. Mengusung semangat “Salam Seni, Kreativitas Tanpa Batas!”, festival ini menjadi wadah bagi pelajar SMA/SMK sederajat untuk menyalurkan bakat dan mengekspresikan diri melalui berbagai lomba seperti Dance, Tari Tradisional, Solo Song, dan Lukis.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- ADD/EDIT EVENT MODAL -->
    <div class="modal" id="eventModal">
        <div class="modal-content">
            <form id="event" enctype="multipart/form-data" method="POST" action="Crud.php">
                <!-- Step 1 -->
                <div id="formStep1" class="form-step active">
                    <h2 id="modalTitle">Tambah Event Baru</h2>
                    
                    <label>Tanggal:</label>
                    <input type="text" id="dateInput" name="tdate" placeholder="Isi tanggal event" required />
                    
                    <label>Logo:</label>
                    <input type="file" id="Logo" name="tlogo" placeholder="Masukan Logo" required />
                    
                    <label>Nama Event:</label>
                    <input type="text" id="nameInput" name="tevent" placeholder="Nama Event" required />
                    
                    <label>Harga (Rp):</label>
                    <input type="text" id="feeInput" name="tfee" placeholder="Rp." required />

                    <label>Status:</label>
                    <input type="text" id="statusInput" name="tstatus" placeholder="Pendaftaran Terbuka" required />
                    
                    <label>Jenis:</label>
                    <input type="text" id="typeInput" name="ttype" placeholder="Festival / Seminar" required />
                    
                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel" id="cancelBtn">Batal</button>
                        <button type="button" class="btn-next" id="nextBtn">Lanjut</button>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div id="formStep2" class="form-step">
                    <h2>Deskripsi</h2>
                    
                    <label>Event dimulai:</label>
                    <input type="text" id="startInput" placeholder="Hari, Tanggal (contoh: Senin, 24 Oktober 2025)" required />
                    
                    <label>Lokasi:</label>
                    <input type="text" id="locationInput" placeholder="Tempat Acara" required />
                    
                    <label>Tautan:</label>
                    <input type="url" id="linkInput" placeholder="https://example.com" />
                    
                    <label>Deskripsi:</label>
                    <textarea id="descInput" placeholder="Tuliskan deskripsi singkat..." required></textarea>
                    
                    <div class="modal-buttons">
                        <button type="button" class="btn-back" id="backBtn">Kembali</button>
                        <input type="submit" class="btn-save" name="addevent" id="saveBtn" value="Simpan"/>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="EA.js" defer></script>
</body>
</html>