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

        <!-- Table Actions (Add Event & Search) -->
        <div class="table-container" id="tableActions" style="margin-bottom: 20px;">
            <div class="table-actions">
                <button class="add-btn" id="addEvent-Btn">+ Add Event</button>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search Event" />
                    <button class="search-btn" id="searchBtn">Search Event</button>
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
                            <th>Date</th>
                            <th>Logo</th>
                            <th>Event</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Event 1 -->
                        <tr class="data-row">
                            <td>1</td>
                           <td>19-21 Desember</td>
                        <td><img src="jobfair.jpg" alt=""></td>
                        <td>Job Fair 2025</td>
                        <td>Gratis</td>
                        <td>Coming Soon</td>
                        <td>Pameran</td>
                            <td>
                                <button class="edit">Edit</button>
                                <button class="delete">Delete</button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                    <p><strong>Location : </strong>Lobby gedung utama politeknik negeri batam</p>
                                <p><strong>Link : </strong>https://www.jobfair2025.com</p>
                                <p><strong>Deskripsi : </strong>Pameran lowongan kerja dan magang dari berbagai perusahaan nasional dan startup</p>
                                </div>
                            </td>
                        </tr>

                        <!-- Event 2 -->
                        <tr class="data-row">
                            <td>2</td>
                            <td>19-21 Desember</td>
                        <td><img src="musc.jpg"></td>
                        <td>Campus Music night</td>
                        <td>Rp 150.000</td>
                        <td>Coming Soon</td>
                        <td>Konser</td>
                            <td>
                                <button class="edit">Edit</button>
                                <button class="delete">Delete</button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                    <p><strong>Location : </strong>parkiran techno preneur politeknik negeri batam</p>
                                <p><strong>Link : </strong>https://www.nightmusic.com</p>
                                <p><strong>Deskripsi : </strong>konser music tahunan dengan penampilan band kapus dan bintang tamu</p>
                                </div>
                            </td>
                        </tr>

                        <!-- Event 3 -->
                        <tr class="data-row">
                            <td>3</td>
                            <td>25-28 Oktober</td>
                        <td><img src="sport.jpg"></td>
                        <td>Sports day</td>
                        <td>Rp 20.000/tim</td>
                        <td>Upcoming</td>
                        <td>Kompetisi</td>
                            <td>
                                <button class="edit">Edit</button>
                                <button class="delete">Delete</button>
                            </td>
                        </tr>
                        <tr class="desc-row">
                            <td colspan="8">
                                <div class="desc-box">
                                   <p><strong>Location : </strong>Lapangan futsal politeknik negeri batam</p>
                                <p><strong>Link : </strong>https://www.sportsdaypoltek.com</p>
                                <p><strong>Deskripsi : </strong>Turnamen olahraga antar-fakultas meliputi futsal, basket, badminton, dan e-sport.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- HISTORY SECTION -->
        <section class="history-container" id="historySection" style="display: none;">
            <h2>📜 Event History</h2>
            <p>Riwayat event yang sudah selesai atau ditutup</p>
            
            <div class="history-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Logo</th>
                            <th>Event</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- History Event 1 -->
                        <tr class="history-data-row">
                            <td>101</td>
                            <td>2025-06-14</td>
                            <td><img src="logopoltektransparan.png" alt="poltek"></td>
                            <td>Workshop Design Thinking</td>
                            <td>Rp 60.000</td>
                            <td>Closed</td>
                            <td>Workshop</td>
                            <td>
                                <button class="view-detail">View</button>
                                <button class="delete-history">Delete</button>
                            </td>
                        </tr>
                        <tr class="history-desc-row">
                            <td colspan="9">
                                <div class="desc-box">
                                    Workshop intensif tentang design thinking untuk pengembangan produk inovatif.
                                </div>
                            </td>
                        </tr>

                        <!-- History Event 2 -->
                        <tr class="history-data-row">
                            <td>102</td>
                            <td>2025-08-03</td>
                            <td><img src="logopoltektransparan.png" alt="poltek"></td>
                            <td>Seminar Startup 101</td>
                            <td>Gratis</td>
                            <td>Closed</td>
                            <td>Seminar</td>
                            <td>
                                <button class="view-detail">View</button>
                                <button class="delete-history">Delete</button>
                            </td>
                        </tr>
                        <tr class="history-desc-row">
                            <td colspan="9">
                                <div class="desc-box">
                                    Seminar membahas dasar-dasar membangun startup dari nol hingga mendapat pendanaan.
                                </div>
                            </td>
                        </tr>

                        <!-- History Event 3 -->
                        <tr class="history-data-row">
                            <td>103</td>
                            <td>2025-07-22</td>
                            <td><img src="logopoltektransparan.png" alt="poltek"></td>
                            <td>Hackathon 2025</td>
                            <td>Rp 100.000</td>
                            <td>Closed</td>
                            <td>Competition</td>
                            <td>
                                <button class="view-detail">View</button>
                                <button class="delete-history">Delete</button>
                            </td>
                        </tr>
                        <tr class="history-desc-row">
                            <td colspan="9">
                                <div class="desc-box">
                                    Kompetisi coding 24 jam untuk menciptakan solusi teknologi inovatif.
                                </div>
                            </td>
                        </tr>

                        <!-- History Event 4 -->
                        <tr class="history-data-row">
                            <td>104</td>
                            <td>2025-05-10</td>
                            <td><img src="logopoltektransparan.png" alt="poltek"></td>
                            <td>Tech Talk: Cloud Computing</td>
                            <td>Gratis</td>
                            <td>Closed</td>
                            <td>Seminar</td>
                            <td>
                                <button class="view-detail">View</button>
                                <button class="delete-history">Delete</button>
                            </td>
                        </tr>
                        <tr class="history-desc-row">
                            <td colspan="9">
                                <div class="desc-box">
                                    Diskusi mendalam tentang cloud computing dan implementasinya di industri.
                                </div>
                            </td>
                        </tr>

                        <!-- History Event 5 -->
                        <tr class="history-data-row">
                            <td>105</td>
                            <td>2025-09-15</td>
                            <td><img src="logopoltektransparan.png" alt="poltek"></td>
                            <td>Career Fair 2025</td>
                            <td>Gratis</td>
                            <td>Closed</td>
                            <td>Career</td>
                            <td>
                                <button class="view-detail">View</button>
                                <button class="delete-history">Delete</button>
                            </td>
                        </tr>
                        <tr class="history-desc-row">
                            <td colspan="9">
                                <div class="desc-box">
                                    Bursa kerja tahunan dengan lebih dari 50 perusahaan teknologi terkemuka.
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
                    <h2 id="modalTitle">Add New Event</h2>
                    
                    <label>Date:</label>
                    <input type="text" id="dateInput" name="tdate" placeholder="Isi tanggal event" required />
                    
                    <label>Logo:</label>
                    <input type="file" id="Logo" name="tlogo" placeholder="Masukan Logo" required />
                    
                    <label>Event Name:</label>
                    <input type="text" id="nameInput" name="tevent" placeholder="Nama Event" required />
                    
                    <label>Fee (Rp):</label>
                    <input type="text" id="feeInput" name="tfee" placeholder="Rp." required />

                    <label>Status:</label>
                    <input type="text" id="statusInput" name="tstatus" placeholder="Open Registration" required />
                    
                    <label>Type:</label>
                    <input type="text" id="typeInput" name="ttype" placeholder="Festival / Seminar" required />
                    
                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
                        <button type="button" class="btn-next" id="nextBtn">Next</button>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div id="formStep2" class="form-step">
                    <h2>Description</h2>
                    
                    <label>Start Event:</label>
                    <input type="text" id="startInput" placeholder="Hari, Tanggal (contoh: Senin, 24 Oktober 2025)" required />
                    
                    <label>Location:</label>
                    <input type="text" id="locationInput" placeholder="Tempat Acara" required />
                    
                    <label>Link:</label>
                    <input type="url" id="linkInput" placeholder="https://example.com" />
                    
                    <label>Description:</label>
                    <textarea id="descInput" placeholder="Tuliskan deskripsi singkat..." required></textarea>
                    
                    <div class="modal-buttons">
                        <button type="button" class="btn-back" id="backBtn">Back</button>
                        <input type="submit" class="btn-save" name="addevent" id="saveBtn" value="Save"/>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="EA.js" defer></script>
</body>
</html>