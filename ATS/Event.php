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
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
            </select>
            <select id="statusFilter">
                <option value="">Status</option>
                <option value="Open">Open</option>
                <option value="Closed">Closed</option>
                <option value="Upcoming">Upcoming</option>
            </select>
            <select id="typeFilter">
                <option value="">Type</option>
                <option value="Seminar">Seminar</option>
                <option value="Workshop">Workshop</option>
                <option value="Festival">Festival</option>
            </select>
            <input type="text" id="searchInput" placeholder="Search Event Name">
            <button onclick="resetFilter()">Reset</button>
        </div>

        <!-- Tabel Event -->
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
                    <!-- Contoh data -->
                    <tr class="data-row" data-year="2025" data-status="Open" data-type="Seminar">
                       <td>19-21 Desember</td>
                        <td><img src="jobfair.jpg" alt=""></td>
                        <td>Job Fair 2025</td>
                        <td>Gratis</td>
                        <td>Coming Soon</td>
                        <td>Pameran</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                                <p><strong>Location : </strong>Lobby gedung utama politeknik negeri batam</p>
                                <p><strong>Link : </strong>https://www.jobfair2025.com</p>
                                <p><strong>Deskripsi : </strong>Pameran lowongan kerja dan magang dari berbagai perusahaan nasional dan startup</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="data-row" data-year="2025" data-status="Closed" data-type="Workshop">
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
                               <p><strong>Location : </strong>parkiran techno preneur politeknik negeri batam</p>
                                <p><strong>Link : </strong>https://www.nightmusic.com</p>
                                <p><strong>Deskripsi : </strong>konser music tahunan dengan penampilan band kapus dan bintang tamu</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="data-row" data-year="2024" data-status="Upcoming" data-type="Festival">
                        <td>25-28 Oktober</td>
                        <td><img src="sport.jpg"></td>
                        <td>Sports day</td>
                        <td>Rp 20.000/tim</td>
                        <td>Upcoming</td>
                        <td>Kompetisi</td>
                    </tr>
                    <tr class="desc-row">
                        <td colspan="6">
                            <div class="desc-box">
                               <p><strong>Location : </strong>Lapangan futsal politeknik negeri batam</p>
                                <p><strong>Link : </strong>https://www.sportsdaypoltek.com</p>
                                <p><strong>Deskripsi : </strong>Turnamen olahraga antar-fakultas meliputi futsal, basket, badminton, dan e-sport.</p>
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
                <h2>Contact Us</h2>
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