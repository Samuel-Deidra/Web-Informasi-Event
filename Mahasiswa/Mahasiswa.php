<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Web Informasi Event Kampus</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../css/Mahasiswa.css">

    <style>
        .event-info-tag.category-seminar {
            background-color: rgba(108, 117, 125, 0.10);
        }

        .event-info-tag.category-workshop {
            background-color: rgba(108, 117, 125, 0.10);
        }

        .event-info-tag.category-festival {
            background-color: rgba(108, 117, 125, 0.10);
        }

        .event-info-tag.category-konser {
            background-color: rgba(108, 117, 125, 0.10);
        }

        .event-info-tag.category-pameran {
            background-color: rgba(108, 117, 125, 0.10);
        }

        .event-info-tag.category-default {
            background-color: rgba(108, 117, 125, 0.10);
        }

        /* PERBAIKAN: Tambahkan CSS untuk notifikasi Toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;

        }

        .toast {
            background-color: #333;
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            margin-bottom: 10px;
            opacity: 0;
            transform: translateX(100%);
            transition: opacity 0.3s, transform 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-container">
                <a class="navbar-brand" href="#">
                    <img src="../Foto/logopoltektransparan.png" alt="" />
                </a>
                <button class="navbar-toggler" onclick="toggleNavbar()">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="navbar-nav" id="navbarNav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-page="home">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="events">
                            <i class="fas fa-calendar me-1"></i> Event
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#calendar-section">
                            <i class="fas fa-calendar-alt me-1"></i> Kalender
                        </a>
                    </li>
                </ul>
                <!-- Tombol Masuk Admin -->
                <a href="../Admin/Login_page.php" class="btn "
                    style="margin-left:auto; margin-right:20px; background-color: hsla(192, 100%, 74%, 0.62); color:black; font-weight:bold; padding:10px 28px; border-radius:7px;">Masuk
                </a>

            </div>
        </div>
    </nav>

    <!-- Home Page -->
    <section id="home" class="page-section active">
        <div class="container">
            <!-- Hero Slider -->
            <div class="hero-slider">
                <div class="slide active banner1"></div>
                <div class="slide banner2"></div>
                <div class="slide banner3"></div>
                <div class="slider-controls">
                    <button class="slider-btn" onclick="changeSlide(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slider-btn" onclick="changeSlide(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="slider-indicators">
                    <span class="indicator active" onclick="goToSlide(0)"></span>
                    <span class="indicator" onclick="goToSlide(1)"></span>
                    <span class="indicator" onclick="goToSlide(2)"></span>
                </div>
            </div>

            <div class="New-event">
                <h2>Event Terbaru</h2>
                <a href="#" onclick="showPage('events'); return false;">Lihat semua</a>
            </div>

            <!-- Event Cards -->
            <div class="row" id="homeEvents">
                <!-- Events will be loaded here -->
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="calendar-section" id="calendar-section">
            <div class="container">
                <h3 class="mb-4">Kalender Event</h3>
                <div class="ratio ratio-16x9">
                    <iframe
                        src="https://calendar.google.com/calendar/embed?src=704495b66ae8dc005c14421765292630e0dfd0dee90f60ed388680811a0251e3%40group.calendar.google.com&ctz=Asia%2FJakarta"
                        style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Page -->
    <section id="events" class="page-section">
        <div class="container">
            <div class="filter-bar">
                <select id="yearFilter">
                    <option value="">Tahun</option>
                    <option value="2027">2027</option>
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                </select>
                <select id="statusFilter">
                    <option value="">Status</option>
                    <option value="Akan Datang">Akan Datang</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Pendaftaran Dibuka">Pendaftaran Dibuka</option>
                    <option value="Pendaftaran Ditutup">Pendaftaran Ditutup</option>
                    <option value="Sedang Berlangsung">Sedang Berlangsung</option>

                </select>
                <select id="typeFilter">
                    <option value="">Kategori</option>
                    <option value="Seminar">Seminar</option>
                    <option value="Pameran">Pameran</option>
                    <option value="Festival">Festival</option>
                    <option value="Konser">Konser</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Workshop">Kompetisi</option>
                </select>
                <div class="search-box">
                    <i class="fa fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Pencarian Nama Event" />
                </div>
            </div>

            <!-- Events Grid -->
            <div class="row" id="eventsGrid">
                <!-- Events will be loaded here -->
            </div>

            <!-- Pagination -->
            <ul class="pagination" id="pagination">
                <!-- Pagination will be generated here -->
            </ul>
        </div>
    </section>

    <!-- Event Detail Modal -->
    <div class="modal" id="eventModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Detail Event</h5>
                <button class="btn-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="event-detail-container">
                    <img id="modalImage" src="" alt="Event Image" class="event-detail-image" />
                    <div class="event-detail-info"
                        style="display: flex; flex-direction: column; gap: 12px; margin-top: 10px;">
                        <div class="event-detail-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-calendar"></i>
                            <span class="event-detail-label" style="font-size:13px; min-width:90px;">Tanggal</span>
                            <span class="event-detail-value" id="modalDate" style="font-weight:600;"></span>
                        </div>
                        <div class="event-detail-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-user-plus"></i>
                            <span class="event-detail-label" style="font-size:13px; min-width:90px;">Pendaftaran</span>
                            <span class="event-detail-value" id="modalRegistrationDate" style="font-weight:600;"></span>
                        </div>
                        <div class="event-detail-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-clock"></i>
                            <span class="event-detail-label" style="font-size:13px; min-width:90px;">Jam</span>
                            <span class="event-detail-value" id="modalTime" style="font-weight:600;"></span>
                        </div>
                        <div class="event-detail-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="event-detail-label" style="font-size:13px; min-width:90px;">Lokasi</span>
                            <span class="event-detail-value" id="modalLocation" style="font-weight:600;"></span>
                        </div>
                        <div class="event-detail-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-tag"></i>
                            <span class="event-detail-label" style="font-size:13px; min-width:90px;">Harga</span>
                            <span class="event-detail-value" id="modalPrice" style="font-weight:600;"></span>
                        </div>
                        <div class="event-detail-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-users"></i>
                            <span class="event-detail-label" style="font-size:13px; min-width:90px;">Peserta</span>
                            <span class="event-detail-value" id="modalParticipants" style="font-weight:600;"></span>
                        </div>
                    </div>
                </div>
                <div class="event-description">
                    <h6>Deskripsi</h6>
                    <p id="modalDescription"></p>
                    <div id="modalLinkContainer" style="margin-top:10px;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- PERBAIKAN: Ubah onclick tombol Bagikan -->
                <button type="button" class="btn btn-secondary" onclick="shareEvent()">
                    <i class="fas fa-share-alt"></i> Bagikan
                </button>
                <a id="modalDaftarEvent" href="Login_page.html" class="btn btn-primary" target="_blank">Daftar Event</a>
            </div>
        </div>
    </div>

    <footer class="footer-end">
        <div class="footer-content-end">
            <img src="../Foto/logopoltektransparan.png" alt="logo" class="footer-logo" />
            <div class="footer-info">
                <h2>Hubungi Kami</h2>
                <p>Politeknik Negeri Batam</p>
                <p>
                    Jl. Ahmad Yani Batam Kota, Kota Batam, Kepulauan Riau, Indonesia.
                </p>
                <p>Whats App 0821-7255-7099</p>
                <p>Fax : +62-778-463620</p>
                <p>Email : info@polibatam.ac.id atau humas@polibatam.ac.id</p>
            </div>
        </div>
    </footer>

    <!-- PERBAIKAN: Tambahkan container untuk notifikasi Toast -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        let allEvents = [];
        let filteredEvents = [];
        let currentPage = 1;
        const eventsPerPage = 8;
        let currentSlide = 0;

        // Fungsi untuk mengambil data event dari database
        async function fetchEventsFromDatabase() {
            try {
                // Coba berbagai path API untuk memastikan bekerja
                let apiUrl = '../Admin/api_events.php?for=mahasiswa';

                console.log('Fetching from:', apiUrl);
                const response = await fetch(apiUrl);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const apiResponse = await response.json();
                console.log('API Response:', apiResponse);

                if (apiResponse.success && apiResponse.data && Array.isArray(apiResponse.data)) {
                    allEvents = apiResponse.data.map(event => {
                        return {
                            id: event.id,
                            title: event.name || 'Tanpa Judul',
                            image: event.image ? '../Admin/' + event.image : 'https://via.placeholder.com/300',
                            date: event.tanggal_event,
                            endDate: event.tanggal_event_akhir,
                            registrationDate: event.tanggal_pendaftaran_awal,
                            registrationEndDate: event.tanggal_pendaftaran_akhir,
                            time: event.jam_event,
                            location: event.lokasi || 'Lokasi Tidak Ditentukan',
                            price: event.price || 'Gratis',
                            participantType: event.peserta || 'Umum',
                            category: event.kategori || 'Umum',
                            description: event.deskripsi || 'Deskripsi tidak tersedia',
                            link: event.link,
                            status: event.status || 'Akan Datang'
                        };
                    });

                    console.log('Processed Events:', allEvents);
                    filteredEvents = [...allEvents];

                    // Memuat data setelah berhasil diambil
                    loadHomeEvents();
                    loadEvents();
                } else {
                    console.error('Invalid API response:', apiResponse);
                    const container = document.getElementById("homeEvents");
                    if (container) {
                        container.innerHTML = `<p class="text-danger">Format data tidak valid. Response: ${JSON.stringify(apiResponse)}</p>`;
                    }
                }
            } catch (error) {
                console.error('Error fetching events:', error);
                const container = document.getElementById("homeEvents");
                if (container) {
                    container.innerHTML = `<p class="text-danger">Gagal memuat data event. Periksa koneksi Anda.</p>`;
                }
            }
        }

        // Initialize
        document.addEventListener("DOMContentLoaded", function () {
            fetchEventsFromDatabase(); // Panggil fetch dulu
            startAutoSlide();

            document.querySelectorAll(".nav-link").forEach((link) => {
                link.addEventListener("click", function (e) {
                    const page = this.getAttribute("data-page");
                    const href = this.getAttribute("href");

                    if (href === "#calendar-section") {
                        e.preventDefault();
                        showPage("home");
                        setTimeout(() => {
                            document.getElementById("calendar-section").scrollIntoView({ behavior: "smooth" });
                        }, 300);
                        return;
                    }

                    if (page) {
                        e.preventDefault();
                        showPage(page);
                    }
                });
            });

            // Event listeners untuk filter
            document.getElementById("yearFilter").addEventListener("change", filterEvents);
            document.getElementById("statusFilter").addEventListener("change", filterEvents);
            document.getElementById("typeFilter").addEventListener("change", filterEvents);
            document.getElementById("searchInput").addEventListener("input", filterEvents);
        });

        // Toggle mobile navbar
        function toggleNavbar() {
            const navbar = document.getElementById("navbarNav");
            navbar.classList.toggle("show");
        }

        // Page Navigation
        function showPage(pageName) {
            document.querySelectorAll(".page-section").forEach((section) => {
                section.classList.remove("active");
            });
            document.getElementById(pageName).classList.add("active");

            document.querySelectorAll(".nav-link").forEach((link) => {
                link.classList.remove("active");
            });
            document.querySelector(`.nav-link[data-page="${pageName}"]`).classList.add("active");

            if (pageName === "events") {
                loadEvents();
            }
        }

        // Slider Functions
        function changeSlide(direction) {
            const slides = document.querySelectorAll(".slide");
            const indicators = document.querySelectorAll(".indicator");

            slides[currentSlide].classList.remove("active");
            indicators[currentSlide].classList.remove("active");

            currentSlide = (currentSlide + direction + slides.length) % slides.length;

            slides[currentSlide].classList.add("active");
            indicators[currentSlide].classList.add("active");
        }

        function goToSlide(index) {
            const slides = document.querySelectorAll(".slide");
            const indicators = document.querySelectorAll(".indicator");

            slides[currentSlide].classList.remove("active");
            indicators[currentSlide].classList.remove("active");

            currentSlide = index;

            slides[currentSlide].classList.add("active");
            indicators[currentSlide].classList.add("active");
        }

        function startAutoSlide() {
            setInterval(() => {
                changeSlide(1);
            }, 10000);
        }

        // FUNGSI PENGURUTAN
        function sortEventsByStatus(events) {
            const statusPriority = {
                'Akan Datang': 1,
                'Pendaftaran Dibuka': 2,
                'Pendaftaran Ditutup': 3,
                'Sedang Berlangsung': 4,
                'Selesai': 5
            };

            return events.sort((a, b) => {
                const statusA = a.status;
                const statusB = b.status;

                const priorityA = statusPriority[statusA] || 99;
                const priorityB = statusPriority[statusB] || 99;

                if (priorityA !== priorityB) {
                    return priorityA - priorityB;
                }

                return Number(b.id) - Number(a.id);
            });
        }

        // Load Home Events
        function loadHomeEvents() {
            const container = document.getElementById("homeEvents");
            const sortedEvents = sortEventsByStatus([...allEvents]);
            const homeEvents = sortedEvents.slice(0, 4);

            container.innerHTML = homeEvents.map(
                (event) => {
                    const status = event.status; // Status diambil dari API
                    return `
            <div class="col-lg-3 col-md-6">
                <div class="event-card" onclick="showEventDetail(${event.id})">
                    <img src="${event.image}" alt="${event.title}">
                    <div class="event-card-body">
                        <span class="event-date">${formatDate(event.date)}</span>                    
                        <h5 class="event-title">${event.title}</h5>
                        <p class="event-location">
                            <i class="fas fa-map-marker-alt"></i> ${event.location}
                        </p>
                        <div class="event-info-tags">
                            <div class="event-info-tag ${getStatusClass(status)}">
                                <i class="fas fa-user-check"></i> ${status}
                            </div>
                            <div class="event-info-tag ${getCategoryColor(event.category)}">
                                <i class="fas fa-tag"></i> ${event.category || 'Tidak ada kategori'}
                            </div>
                        </div>
                        <div class="event-info-tags">
                            <div class="event-info-tag ${getParticipantClass(event.participantType)}">
                                <i class="fas fa-users"></i> ${event.participantType}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
                }
            ).join("");
        }

        // Load Events with Pagination
        function loadEvents() {
            const container = document.getElementById("eventsGrid");
            const sortedEvents = sortEventsByStatus([...filteredEvents]);
            const startIndex = (currentPage - 1) * eventsPerPage;
            const endIndex = startIndex + eventsPerPage;
            const pageEvents = sortedEvents.slice(startIndex, endIndex);

            container.innerHTML = pageEvents.map(
                (event) => {
                    const status = event.status; // Status diambil dari API
                    return `
            <div class="col-lg-3 col-md-6">
                <div class="event-card" onclick="showEventDetail(${event.id})">
                    <img src="${event.image}" alt="${event.title}">
                    <div class="event-card-body">
                        <span class="event-date">${formatDate(event.date)}</span>
                        <h5 class="event-title">${event.title}</h5>
                        <p class="event-location">
                            <i class="fas fa-map-marker-alt"></i> ${event.location}
                        </p>
                        <div class="event-info-tags">
                            <div class="event-info-tag ${getStatusClass(status)}">
                                <i class="fas fa-user-check"></i> ${status}
                            </div>
                            <div class="event-info-tag ${getCategoryColor(event.category)}">
                                <i class="fas fa-tag"></i> ${event.category || 'Tidak ada kategori'}
                            </div>
                        </div>
                        <div class="event-info-tags">
                            <div class="event-info-tag ${getParticipantClass(event.participantType)}">
                                <i class="fas fa-users"></i> ${event.participantType}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
                }
            ).join("");

            generatePagination();
        }

        function getStatusClass(status) {
            const statusLower = status.toLowerCase();
            if (statusLower.includes("akan datang")) return "coming";
            if (statusLower.includes("dibuka")) return "open";
            if (statusLower.includes("ditutup")) return "closed";
            if (statusLower.includes("berlangsung")) return "ongoing";
            if (statusLower.includes("selesai")) return "finished";
            return "";
        }

        // Fungsi untuk menentukan kelas warna peserta
        function getParticipantClass(participantType) {
            const typeLower = participantType.toLowerCase();
            if (typeLower.includes("mahasiswa")) {
                return "participants-mahasiswa";
            }
            return "participants-umum";
        }

        // Filter Events
        function filterEvents() {
            const yearFilter = document.getElementById("yearFilter").value;
            const statusFilter = document.getElementById("statusFilter").value;
            const typeFilter = document.getElementById("typeFilter").value;
            const searchInput = document.getElementById("searchInput").value.toLowerCase();

            filteredEvents = allEvents.filter((event) => {
                let matchYear = !yearFilter || event.date.includes(yearFilter);
                let matchStatus = !statusFilter || (event.status && event.status.toLowerCase() === statusFilter.toLowerCase());
                let matchType = !typeFilter || (event.category && event.category.toLowerCase() === typeFilter.toLowerCase());
                let matchSearch = !searchInput || (event.title && event.title.toLowerCase().includes(searchInput));

                return matchYear && matchStatus && matchType && matchSearch;
            });

            currentPage = 1;
            loadEvents();
        }

        // Generate Pagination
        function generatePagination() {
            const totalPages = Math.ceil(filteredEvents.length / eventsPerPage);
            const pagination = document.getElementById("pagination");

            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }

            let html = '';
            html += `<li class="page-item ${currentPage === 1 ? "disabled" : ""}">`;
            html += `<a class="page-link" href="#" onclick="changePage(${currentPage - 1}); return false;">`;
            html += `<i class="fas fa-chevron-left"></i>`;
            html += `</a></li>`;

            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="page-item ${currentPage === i ? 'active' : ''}">`;
                html += `<a class="page-link" href="#" onclick="changePage(${i}); return false;">${i}</a>`;
                html += `</li>`;
            }

            html += `<li class="page-item ${currentPage === totalPages ? "disabled" : ""}">`;
            html += `<a class="page-link" href="#" onclick="changePage(${currentPage + 1}); return false;">`;
            html += `<i class="fas fa-chevron-right"></i>`;
            html += `</a></li>`;

            pagination.innerHTML = html;
        }

        // Change Page
        function changePage(page) {
            const totalPages = Math.ceil(filteredEvents.length / eventsPerPage);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                loadEvents();
            }
            return false;
        }

        // Show Event Detail Modal
        function showEventDetail(eventId) {
            const event = allEvents.find((e) => Number(e.id) === Number(eventId));
            if (!event) {
                console.warn('Event not found for id:', eventId, 'available ids:', allEvents.map(e => e.id));
                return;
            }
            if (event) {
                document.getElementById("modalTitle").textContent = event.title;
                document.getElementById("modalImage").src = event.image;
                document.getElementById("modalDate").textContent = formatDateRange(event.date, event.endDate);
                document.getElementById("modalRegistrationDate").textContent = formatDateRange(event.registrationDate, event.registrationEndDate);
                document.getElementById("modalTime").textContent = formatTimeHHMM(event.time || event.jam_event || event.jamEvent || '');
                document.getElementById("modalLocation").textContent = event.location;
                document.getElementById("modalPrice").textContent = event.price;
                document.getElementById("modalParticipants").textContent = event.participantType;
                document.getElementById("modalDescription").textContent = event.description;

                const daftarBtn = document.getElementById("modalDaftarEvent");
                if (event.link && event.link.trim() !== "") {
                    daftarBtn.href = event.link;
                    daftarBtn.textContent = "Daftar Event";
                    daftarBtn.target = "_blank";
                } else {
                    daftarBtn.href = "Login_page.html";
                    daftarBtn.textContent = "Daftar Event";
                    daftarBtn.target = "_self";
                }

                const linkContainer = document.getElementById("modalLinkContainer");
                linkContainer.innerHTML = "";

                document.getElementById("eventModal").classList.add("show");
                document.body.style.overflow = "hidden";
            }
        }

        // Close Modal
        function closeModal() {
            document.getElementById("eventModal").classList.remove("show");
            document.body.style.overflow = "auto";
        }

        // Close modal when clicking outside
        document.getElementById("eventModal").addEventListener("mousedown", function (event) {
            if (event.target === this) {
                closeModal();
            }
        });

        // Utility Functions
        function formatDateWithoutYear(dateStr) {
            if (!dateStr) return "";
            const [year, month, day] = dateStr.split("-");
            const date = new Date(year, month - 1, day);
            const options = { day: "numeric", month: "long" };
            return date.toLocaleDateString("id-ID", options);
        }

        function formatDate(dateStr) {
            if (!dateStr) return "";
            const [year, month, day] = dateStr.split("-");
            const date = new Date(year, month - 1, day);
            const options = { day: "numeric", month: "long", year: "numeric" };
            return date.toLocaleDateString("id-ID", options);
        }

        function formatDateRange(startDateStr, endDateStr) {
            if (!startDateStr) return "";

            if (!endDateStr || endDateStr === startDateStr) {
                return formatDate(startDateStr);
            }

            const [startYear] = startDateStr.split("-");
            const [endYear] = endDateStr.split("-");

            if (startYear === endYear) {
                return `${formatDateWithoutYear(startDateStr)} - ${formatDate(endDateStr)}`;
            }

            return `${formatDate(startDateStr)} - ${formatDate(endDateStr)}`;
        }

        function getCategoryColor(category) {
            if (!category) return 'category-default';
            const categoryLower = category.toLowerCase();
            switch (categoryLower) {
                case 'seminar': return 'category-seminar';
                case 'workshop': return 'category-workshop';
                case 'festival': return 'category-festival';
                case 'konser': return 'category-konser';
                case 'pameran': return 'category-pameran';
                default: return 'category-default';
            }
        }

        function formatTimeHHMM(timeString) {
            if (!timeString) return '';
            const parts = timeString.split(':');
            if (parts.length >= 2) {
                const hh = parts[0].padStart(2, '0');
                const mm = parts[1].padStart(2, '0');
                return hh + ':' + mm;
            }
            return timeString;
        }

        /* PERBAIKAN: Tambahkan fungsi untuk berbagi dan menampilkan toast */
        // Fungsi untuk menampilkan notifikasi Toast
        function showToast(message, duration = 3000) {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.textContent = message;

            toastContainer.appendChild(toast);

            // Trigger reflow untuk memulai transisi
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);

            // Hapus toast setelah durasi tertentu
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toastContainer.removeChild(toast);
                    }
                }, 300); // Tunggu hingga transisi selesai
            }, duration);
        }

        // Fungsi untuk menyalin link URL halaman
        function shareEvent() {
            const url = window.location.href;

            // Gunakan modern Clipboard API
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Link berhasil disalin!');
                }).catch(err => {
                    console.error('Gagal menyalin link: ', err);
                    showToast('Gagal menyalin link. Silakan coba lagi.');
                });
            } else {
                // Fallback untuk browser yang lebih lama
                const textArea = document.createElement("textarea");
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    showToast('Link berhasil disalin!');
                } catch (err) {
                    console.error('Fallback: Gagal menyalin link: ', err);
                    showToast('Gagal menyalin link. Silakan salin secara manual.');
                }
                document.body.removeChild(textArea);
            }
        }
    </script>
</body>

</html>