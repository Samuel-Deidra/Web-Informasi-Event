<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Event Kampus - Platform Informasi Event</title>

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
      <link rel="stylesheet" href="">
      <link rel="stylesheet" href="../css/Mahasiswa.css">
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
          <a href="Login_page.html" 
           class="btn btn-light"
           style="margin-left:auto; margin-right:20px; background-color:#FFD700; color:#000; font-weight:bold; padding:10px 28px; border-radius:6px;">Masuk
          </a>

        </div>
      </div>
    </nav>

    <!-- Home Page -->
    <section id="home" class="page-section active">
      <div class="container">
        <!-- Hero Slider -->
        <div class="hero-slider">
          <div class="slide active">
            <img src="../Foto/banner.jpg" alt="Slide 1" />
          </div>
          <div class="slide">
            <img src="../Foto/banner.jpg" alt="Slide 2" />
          </div>
          <div class="slide">
            <img src="../Foto/banner.jpg" alt="Slide 3" />
          </div>
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
              src="https://calendar.google.com/calendar/embed?src=54c9f1cc039bbf175212c522ee8f81556538fb9371f9551c309086df78f021a4%40group.calendar.google.com&ctz=Asia%2FJakarta"
            ></iframe>
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
            <option value="">Jenis</option>
            <option value="Seminar">Seminar</option>
            <option value="Pameran">Pameran</option>
            <option value="Festival">Festival</option>
            <option value="Konser">Konser</option>
            <option value="Workshop">Workshop</option>
           </select>
          <div class="search-box">
            <i class="fa fa-search"></i>
            <input
              type="text"
              id="searchInput"
              placeholder="Pencarian Nama Event"
            />
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
            <img
              id="modalImage"
              src=""
              alt="Event Image"
              class="event-detail-image"
            />
            <div class="event-detail-info">
              <div class="event-detail-item">
                <i class="fas fa-calendar"></i>
                <span class="event-detail-label">Tanggal:</span>
                <span class="event-detail-value" id="modalDate"></span>
              </div>
              <div class="event-detail-item">
                <i class="fas fa-user-plus"></i>
                <span class="event-detail-label">Pendaftaran:</span>
                <span class="event-detail-value" id="modalRegistrationDate"></span>
              </div>
              <div class="event-detail-item">
                <i class="fas fa-clock"></i>
                <span class="event-detail-label">Jam:</span>
                <span class="event-detail-value" id="modalTime"></span>
              </div>
              <div class="event-detail-item">
                <i class="fas fa-map-marker-alt"></i>
                <span class="event-detail-label">Lokasi:</span>
                <span class="event-detail-value" id="modalLocation"></span>
              </div>
              <div class="event-detail-item">
                <i class="fas fa-tag"></i>
                <span class="event-detail-label">Harga:</span>
                <span class="event-detail-value" id="modalPrice"></span>
              </div>
              <div class="event-detail-item">
                <i class="fas fa-users"></i>
                <span class="event-detail-label">Peserta:</span>
                <span class="event-detail-value" id="modalParticipants"></span>
              </div>
            </div>
          </div>
          <div class="event-description">
            <h6>Deskripsi</h6>
            <p id="modalDescription"></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Daftar Event</button>
          <button
            type="button"
            class="btn btn-secondary"
            onclick="closeModal()"
          >Bagikan</button>
        </div>
      </div>
    </div>

    <footer class="footer-end">
      <div class="footer-content-end">
        <img
          src="../Foto/logopoltektransparan.png"
          alt="logo"
          class="footer-logo"
        />
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

    <script>
let allEvents = [];

// Fungsi untuk mengambil data event dari database
async function fetchEventsFromDatabase() {
    try {
        const response = await fetch('get_events.php');
        allEvents = await response.json();
        filteredEvents = [...allEvents];
        
        // Memuat data setelah berhasil diambil
        loadHomeEvents();
        loadEvents();
    } catch (error) {
        console.error('Error:', error);
    }
}

// Memanggil fungsi fetchEventsFromDatabase saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
    fetchEventsFromDatabase();
    startAutoSlide();
    
    // ... kode lainnya ...
});

      let currentPage = 1;
      const eventsPerPage = 8;
      let filteredEvents = [...allEvents];
      let currentSlide = 0;

      // Initialize
      document.addEventListener("DOMContentLoaded", function () {
        loadHomeEvents();
        loadEvents();
        startAutoSlide();

      // Navigation
      document.querySelectorAll(".nav-link").forEach((link) => {
      link.addEventListener("click", function (e) {
      const page = this.getAttribute("data-page");
      const href = this.getAttribute("href");

      // Kalau yang diklik adalah tombol "Kalender"
      if (href === "#calendar-section") {
      e.preventDefault();
      // Tampilkan beranda dulu
      showPage("home");
      // Tunggu sedikit biar transisi jalan, baru scroll ke kalender
      setTimeout(() => {
        document.getElementById("calendar-section").scrollIntoView({
          behavior: "smooth"
        });
      }, 300);
      return; // hentikan di sini biar nggak lanjut ke bawah
    }

    // Navigasi normal antar-section (Beranda, Event, dll)
    if (page) {
      e.preventDefault();
      showPage(page);
    }
    });
    });


        // Filters
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
        document
          .querySelector(`.nav-link[data-page="${pageName}"]`)
          .classList.add("active");

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
        }, 5000);
      }

      // Load Home Events
      function loadHomeEvents() {
        const container = document.getElementById("homeEvents");
        const homeEvents = allEvents.slice(0, 4);

      container.innerHTML = homeEvents
      .map(
        (event) => `
          <div class="col-lg-3 col-md-6">
              <div class="event-card" onclick="showEventDetail(${
                event.id
              })">
                  <img src="${event.image}" alt="${event.title}">
                  <div class="event-card-body">
                      <span class="event-date">${formatDate(
                        event.date
                      )}</span>                    
                      <h5 class="event-title">${event.title}</h5>
                      <p class="event-location">
                          <i class="fas fa-map-marker-alt"></i> ${
                            event.location
                          }
                      </p>
                      <div class="event-info-tags">
                          <div class="event-info-tag ${getStatusClass(event.status)}">
                              <i class="fas fa-user-check"></i> ${event.status}
                          </div>
                            <div class="event-info-tag ${getParticipantClass(event.participantType)}">     
                              <i class="fas fa-users"></i> ${
                                event.participantType
                              }
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      `
      )
      .join("");
      }

      function getStatusClass(status) {
        const statusLower = status.toLowerCase();
        let classToReturn = ""; // Defaultnya kosong
        if (statusLower.includes("akan datang")) {
          classToReturn = "coming";
        } else if (statusLower.includes("dibuka")) {
          classToReturn = "open";
        } else if (statusLower.includes("ditutup")) {
          classToReturn = "closed";
        } else if (statusLower.includes("berlangsung")) {
          classToReturn = "ongoing";
        } else if (statusLower.includes("selesai")) {
          classToReturn = "finished";
        }

      // Tambahkan baris ini untuk debugging
      console.log(`Status: "${status}" -> Class: "${classToReturn}"`);

      return classToReturn;
    }
      // Load Events with Pagination
      function loadEvents() {
        const container = document.getElementById("eventsGrid");
        const startIndex = (currentPage - 1) * eventsPerPage;
        const endIndex = startIndex + eventsPerPage;
        const pageEvents = filteredEvents.slice(startIndex, endIndex);

      container.innerHTML = pageEvents
      .map(
       (event) => `
          <div class="col-lg-3 col-md-6">
            <div class="event-card" onclick="showEventDetail(${
                event.id
              })">
                <img src="${event.image}" alt="${event.title}">
                <div class="event-card-body">
                      <span class="event-date">${formatDate(
                        event.date
                      )}</span>
                      <h5 class="event-title">${event.title}</h5>
                      <p class="event-location">
                          <i class="fas fa-map-marker-alt"></i> ${
                            event.location
                          }
                      </p>
                      <div class="event-info-tags">
                        <div class="event-info-tag ${getStatusClass(event.status)}">
                          <i class="fas fa-user-check"></i> ${event.status}
                        </div>
                          <div class="event-info-tag ${getParticipantClass(event.participantType)}">   
                              <i class="fas fa-users"></i> ${event.participantType}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      `
    )
    .join("");

    generatePagination();
    }
      // Fungsi untuk menentukan kelas warna peserta
      function getParticipantClass(participantType) {
        const typeLower = participantType.toLowerCase();
  
      // Jika mengandung "mahasiswa", gunakan warna hijau
      if (typeLower.includes("mahasiswa")) {
        return "participants-mahasiswa";
      }
  
      // Jika hanya "umum" atau kategori lain, gunakan warna biru (default)
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
          let matchStatus = !statusFilter || event.status.toLowerCase() === statusFilter.toLowerCase();
          let matchType = !typeFilter || event.category.toLowerCase() === typeFilter.toLowerCase();
          let matchSearch = !searchInput || event.title.toLowerCase().includes(searchInput);

          return matchYear && matchStatus && matchType && matchSearch;
        });

        currentPage = 1;
        loadEvents();
      }

      // Generate Pagination
      function generatePagination() {
        const totalPages = Math.ceil(filteredEvents.length / eventsPerPage);
        const pagination = document.getElementById("pagination");

      // Kalau cuma 1 halaman, gausah ditampilkan
      if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
      }

      let html = `

      <!-- Panah Kiri -->
      <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
        <a class="page-link" href="#" onclick="changePage(${currentPage - 1}); return false;">
          <i class="fas fa-chevron-left"></i>
        </a>
      </li>
    
      <!-- NOMOR HALAMAN YANG SEDANG AKTIF SAJA -->
      <li class="page-item active">
        <a class="page-link" href="#">${currentPage}</a>
      </li>

      <!-- Panah Kanan -->
      <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
        <a class="page-link" href="#" onclick="changePage(${currentPage + 1}); return false;">
          <i class="fas fa-chevron-right"></i>
        </a>
      </li>
      `;

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
        const event = allEvents.find((e) => e.id === eventId);
        if (event) {
          document.getElementById("modalTitle").textContent = event.title;
          document.getElementById("modalImage").src = event.image;
          document.getElementById("modalDate").textContent = formatDate(event.date);
          document.getElementById("modalRegistrationDate").textContent = formatDate(event.registrationDate);
          document.getElementById("modalTime").textContent = event.time;
          document.getElementById("modalLocation").textContent = event.location;
          document.getElementById("modalPrice").textContent = event.price;
          document.getElementById("modalParticipants").textContent = event.participants;
          document.getElementById("modalDescription").textContent = event.description;

          document.getElementById("eventModal").classList.add("show");
        }
      }

      // Close Modal
      function closeModal() {
        document.getElementById("eventModal").classList.remove("show");
      }

      // Close modal when clicking outside
      window.onclick = function (event) {
        const modal = document.getElementById("eventModal");
        if (event.target === modal) {
          closeModal();
        }
      };

      // Utility Functions
      function formatDate(dateStr) {
        const date = new Date(dateStr);
        const options = { day: "numeric", month: "long", year: "numeric" };
        return date.toLocaleDateString("id-ID", options);
      }
    </script>
  </body>
</html>