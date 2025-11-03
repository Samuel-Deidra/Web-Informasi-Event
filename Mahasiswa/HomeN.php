<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Informasi Event Kampus</title>
    <link rel="stylesheet" href="HomeN.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-calendar-alt"></i>
                    Web Informasi Event Kampus
                </div>
                <nav>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Event</a></li>
                        <li><a href="#">Tiket</a></li>
                        <li><a href="#">Promo</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </nav>
                <div class="search-box">
                    <input type="text" placeholder="Cari event...">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Slider -->
    <section class="hero-slider">
        <div class="slider-container">
            <div class="slide" style="background-image: url('https://picsum.photos/seed/event1/1200/400.jpg')">
                <div class="slide-content">
                    <h2>Festival Seni Kampus 2025</h2>
                    <p>Merayakan kreativitas mahasiswa dalam seni, musik, dan pertunjukan</p>
                    <a href="#" class="btn">Lihat Detail</a>
                </div>
            </div>
            <div class="slide" style="background-image: url('https://picsum.photos/seed/event2/1200/400.jpg')">
                <div class="slide-content">
                    <h2>Kompetisi Debat Antar Fakultas</h2>
                    <p>Ajang adu argumen terbaik antar fakultas se-universitas</p>
                    <a href="#" class="btn">Lihat Detail</a>
                </div>
            </div>
            <div class="slide" style="background-image: url('https://picsum.photos/seed/event3/1200/400.jpg')">
                <div class="slide-content">
                    <h2>Job Fair Kampus 2025</h2>
                    <p>Temukan peluang karir dengan lebih dari 50 perusahaan ternama</p>
                    <a href="#" class="btn">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="slider-nav">
            <button id="prevBtn"><i class="fas fa-chevron-left"></i></button>
            <button id="nextBtn"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="slider-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>

    <!-- Top Events Section -->
    <section class="top-events container">
        <h2 class="section-title">Top Event Kampus</h2>
        <div class="events-container">
            <div class="event-card" onclick="openModal('event1')">
                <div class="event-image" style="background-image: url('https://picsum.photos/seed/topevent1/400/300.jpg')"></div>
                <div class="event-details">
                    <span class="event-date">15 November 2025</span>
                    <h3 class="event-title">Lomba Karya Tulis Ilmiah Nasional</h3>
                    <div class="event-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Auditorium Utama Kampus</span>
                    </div>
                </div>
            </div>
            
            <div class="event-card" onclick="openModal('event2')">
                <div class="event-image" style="background-image: url('https://picsum.photos/seed/topevent2/400/300.jpg')"></div>
                <div class="event-details">
                    <span class="event-date">22 November 2025</span>
                    <h3 class="event-title">Pekan Olahraga Mahasiswa</h3>
                    <div class="event-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Lapangan Olahraga Kampus</span>
                    </div>
                </div>
            </div>
            
            <div class="event-card" onclick="openModal('event3')">
                <div class="event-image" style="background-image: url('https://picsum.photos/seed/topevent3/400/300.jpg')"></div>
                <div class="event-details">
                    <span class="event-date">30 November 2025</span>
                    <h3 class="event-title">Seminar Nasional Teknologi</h3>
                    <div class="event-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Gedung Fakultas Teknik</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Modal -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <div class="modal-image" id="modalImage"></div>
                <div class="modal-info">
                    <h2 class="modal-title" id="modalTitle"></h2>
                    <div class="modal-meta">
                        <div class="modal-meta-item">
                            <i class="fas fa-calendar"></i>
                            <span id="modalDate"></span>
                        </div>
                        <div class="modal-meta-item">
                            <i class="fas fa-clock"></i>
                            <span id="modalTime"></span>
                        </div>
                        <div class="modal-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span id="modalLocation"></span>
                        </div>
                        <div class="modal-meta-item">
                            <i class="fas fa-tag"></i>
                            <span id="modalPrice"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-description" id="modalDescription"></div>
            <div class="modal-actions">
                <button class="btn-primary">Beli Tiket</button>
                <button class="btn-secondary">Bagikan Event</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Tentang EventKampus</h3>
                    <p>Platform informasi event kampus terlengkap untuk memudahkan mahasiswa menemukan dan mengikuti berbagai kegiatan di kampus.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Link Cepat</h3>
                    <ul>
                        <li><a href="#">Event Mendatang</a></li>
                        <li><a href="#">Event Populer</a></li>
                        <li><a href="#">Kategori Event</a></li>
                        <li><a href="#">Cara Pemesanan</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Bantuan</h3>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p>Dapatkan informasi event terbaru langsung di email Anda</p>
                    <div class="search-box" style="width: 100%; margin-top: 15px;">
                        <input type="email" placeholder="Email Anda">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 EventKampus. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Slider functionality
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentSlide = 0;

        function showSlide(index) {
            const sliderContainer = document.querySelector('.slider-container');
            sliderContainer.style.transform = `translateX(-${index * 100}%)`;
            
            dots.forEach(dot => dot.classList.remove('active'));
            dots[index].classList.add('active');
            
            currentSlide = index;
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });

        // Auto-slide
        setInterval(nextSlide, 5000);

        // Modal functionality
        const modal = document.getElementById('eventModal');
        
        const eventData = {
            event1: {
                title: "Lomba Karya Tulis Ilmiah Nasional",
                date: "15 November 2025",
                time: "08:00 - 17:00 WIB",
                location: "Auditorium Utama Kampus",
                price: "Gratis",
                image: "https://picsum.photos/seed/topevent1/800/600.jpg",
                description: "Lomba Karya Tulis Ilmiah Nasional adalah ajang kompetisi tahunan yang diselenggarakan untuk mendorong mahasiswa mengembangkan kemampuan menulis ilmiah dan berpikir kritis. Tahun ini, tema yang diangkat adalah 'Inovasi Teknologi untuk Pembangunan Berkelanjutan'. Peserta akan dinilai oleh dosen dan peneliti berpengalaman dari berbagai universitas ternama. Pemenang akan mendapatkan hadiah uang tunai, sertifikat, dan kesempatan untuk mempublikasikan karyanya di jurnal ilmiah terakreditasi."
            },
            event2: {
                title: "Pekan Olahraga Mahasiswa",
                date: "22 November 2025",
                time: "07:00 - 18:00 WIB",
                location: "Lapangan Olahraga Kampus",
                price: "Rp 25.000",
                image: "https://picsum.photos/seed/topevent2/800/600.jpg",
                description: "Pekan Olahraga Mahasiswa (POM) adalah festival olahraga tahunan yang mempertemukan atlet-atlet dari berbagai fakultas. Berbagai cabang olahraga dipertandingkan, mulai dari bola basket, voli, futsal, hingga atletik. Acara ini tidak hanya bertujuan untuk mencari atlet terbaik, tetapi juga untuk memperkuat rasa persatuan dan sportivitas antar mahasiswa. Selain pertandingan, akan ada berbagai stan makanan dan minuman, serta penampilan dari unit kegiatan mahasiswa."
            },
            event3: {
                title: "Seminar Nasional Teknologi",
                date: "30 November 2025",
                time: "09:00 - 16:00 WIB",
                location: "Gedung Fakultas Teknik",
                price: "Rp 50.000 (Mahasiswa), Rp 75.000 (Umum)",
                image: "https://picsum.photos/seed/topevent3/800/600.jpg",
                description: "Seminar Nasional Teknologi menghadirkan pembicara dari industri teknologi ternama dan akademisi terkemuka untuk berbagi wawasan tentang tren teknologi terkini. Tahun ini, fokus seminar adalah 'Kecerdasan Buatan dan Masa Depan Industri'. Peserta akan mendapatkan sertifikat, materi seminar, dan kesempatan untuk networking dengan para profesional di bidang teknologi. Terdapat juga sesi workshop praktis untuk pengembangan keterampilan teknis."
            }
        };

        function openModal(eventId) {
            const event = eventData[eventId];
            
            document.getElementById('modalTitle').textContent = event.title;
            document.getElementById('modalDate').textContent = event.date;
            document.getElementById('modalTime').textContent = event.time;
            document.getElementById('modalLocation').textContent = event.location;
            document.getElementById('modalPrice').textContent = event.price;
            document.getElementById('modalDescription').textContent = event.description;
            document.getElementById('modalImage').style.backgroundImage = `url('${event.image}')`;
            
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside of modal content
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
</body>
</html>