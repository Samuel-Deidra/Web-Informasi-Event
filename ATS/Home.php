    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Informasi Event Kampus</title>
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>

    <!-- Navbar -->
        <nav class="navbar">
            <div class="container">
                <ul class="nav-links">
                    <li><a href="Home.php">Home</a></li>
                    <li><a href="Event.php">Event</a></li>
                    <li><a href="calender.php">Calendar</a></li>
                </ul>

                <div class="icon-user">
                    <a href="Login_page.php"><i class="fa-solid fa-user"></i></a>
                </div>

            </div>
        </nav>

        <!-- Banner -->
        <section class="banner">
            <img src="banner.jpg" alt="banner">
        </section>

        <section>
            <!-- Filter Bar -->
            <section class="event-container">
        <div class="event-list">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Logo</th>
                        <th>Event</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh data statis -->
                    <tr class="data-row">
                        <td>23-09 November</td>
                        <td><img src="fair.jpg"></td>
                        <td>HMTI FAIR 2025</td>
                        <td>Rp 30.000</td>
                        <td>Open Registration</td>
                        <td>Festival</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                               <p><strong>Location : </strong>parkiran techno preneur politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>https://www.nightmusic.com</p><br>
                                <p><strong>Deskripsi : </strong>HMTI FAIR 2025 adalah ajang tahunan Himpunan Mahasiswa Teknik Informatika Polibatam dengan tema “Exploring Infinite Space, Beyond the Horizon.” Kegiatan ini menghadirkan berbagai lomba seru seperti Short Movie, Capture The Flag, Graphic Design, Photography, PES, dan Mobile Legends untuk siswa SMA/SMK/MA se-Kepri.</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="data-row">
                        <td>19-21 Desember</td>
                        <td><img src="musc.jpg"></td>
                        <td>Campus Music night</td>
                        <td>Rp 150.000</td>
                        <td>Coming Soon</td>
                        <td>Konser</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                                <p><strong>Location : </strong>parkiran techno preneur politeknik negeri batam</p><br>
                                <p><strong>Link : </strong>https://www.nightmusic.com</p><br>
                                <p><strong>Deskripsi : </strong>konser music tahunan dengan penampilan band kapus dan bintang tamu</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="data-row">
                       <td>25-28 Februari 2026</td>
                        <td><img src="pbl expo.jpg"></td>
                        <td>PBL EXPO 2025</td>
                        <td>Rp 20.000/tim</td>
                        <td>Coming Soon</td>
                        <td>Pameran</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                               <p><strong>Location : </strong>Gedung Traine Politeknik Negeri Batam</p><br>
                                <p><strong>Link : </strong>https://www.pblpoltek.com</p><br>
                                <p><strong>Deskripsi : </strong>Pameran karya proyek PBL mahasiswa. Akan ada penilaian dan hadiah untuk karya terbaik.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
            
    <footer class="footer">
                <div class="footer-content">
                    <img src="logopoltektransparan.png" alt="logo" class="footer-logo">
                    <div class="footer-info">
                        <h2>Contact Us</h2>
                            <p>Politeknik Negeri Batam</p>
                            <p>Jl. Ahmad Yani Batam Kota, Kota Batam, Kepulauan Riau, Indonesia.</p>
                            <p>Whats App 0821-7255-7099</p>
                            <p>Fax : +62-778-463620</p>
                            <p>Email : info@polibatam.ac.id atau humas@polibatam.ac.id</p>
                        </div>
                    </div>
                </footer>
    </body>

        <!-- jangan diganti lagi -->
        <script>
        const rows = document.querySelectorAll('.data-row');

        rows.forEach((row, index) => {
        row.addEventListener('click', () => {
            const descRow = row.nextElementSibling;
            const descBox = descRow.querySelector('.desc-box');

            document.querySelectorAll('.desc-box').forEach(box => {
            if (box !== descBox) box.classList.remove('active');
            });

            descBox.classList.toggle('active');
        });
        });
    </script>

    </html>