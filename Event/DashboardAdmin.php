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

        <!-- ALERT -->
        
        <!-- EVENT SECTION -->

            <?php include '../Database/Event_Admin.php' ?>
        <!-- HISTORY SECTION -->
        <section class="event-container filter-event history-box" id="historySection" style="display:none;">
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
                <div class="search-box">
                    <input type="text" id="searchInputHistory" placeholder="Search Event" />
                    <button class="search-btn" id="searchBtnHistory">Search</button>
                </div>
            </div>
            </section>

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
                        <?php
                        $history = $conn->query("SELECT * FROM event WHERE Status='Finished' AND is_deleted=0 ORDER BY Date DESC");
                        if ($history && $history->num_rows > 0):
                            while ($h = $history->fetch_assoc()):
                                ?>
                                <tr class="history-data-row">
                                    <td><?= $h['ID']; ?></td>
                                    <td><?= $h['Date']; ?></td>
                                    <td><img src="../uploads/<?= htmlspecialchars($h['Logo']); ?>" style="height:60px;"></td>
                                    <td><?= htmlspecialchars($h['Event']); ?></td>
                                    <td><?= htmlspecialchars($h['Fee']); ?></td>
                                    <td><?= htmlspecialchars($h['Status']); ?></td>
                                    <td><?= htmlspecialchars($h['Type']); ?></td>
                                    <td><a href="event_crud.php?delete=<?= $h['ID']; ?>" class="delete-history"
                                            onclick="return confirm('Hapus event ini?')">Delete</a></td>
                                </tr>
                                <tr class="history-desc-row">
                                    <td colspan="8">
                                        <div class="desc-box">
                                            <p><strong>Location:</strong> <?= htmlspecialchars($h['Location']); ?></p>
                                            <p><strong>Link:</strong> <a href="<?= htmlspecialchars($h['Link']); ?>"
                                                    target="_blank"><?= htmlspecialchars($h['Link']); ?></a></p>
                                            <p><strong>Deskripsi:</strong> <?= htmlspecialchars($h['Description']); ?></p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; else: ?>
                            <tr>
                                <td colspan="8" style="text-align:center;">Belum ada event history</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- ADD EVENT MODAL -->
    <div class="modal" id="eventModal">
        <div class="modal-content">
            <form id="event" enctype="multipart/form-data" method="POST" action="crud.php">
                <!-- Step 1 -->
                <div id="formStep1" class="form-step active">
                    <h2 id="modalTitle">Add New Event</h2>

                    <label>Date:</label>
                    <input type="date" id="dateInput" name="Date" required />

                    <label>Logo:</label>
                    <input type="file" id="Logo" name="Logo" accept="image/*" required />

                    <label>Event Name:</label>
                    <input type="text" id="nameInput" name="Event" placeholder="Nama Event" required />

                    <label>Fee (Rp):</label>
                    <input type="text" id="feeInput" name="Fee" placeholder="Rp." required />

                    <label>Status:</label>
                    <input type="text" id="statusInput" name="Status" placeholder="Open Registration" required />

                    <label>Type:</label>
                    <input type="text" id="typeInput" name="Type" placeholder="Festival / Seminar" required />

                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
                        <button type="button" class="btn-next" id="nextBtn">Next</button>
                    </div>
                </div>

                <!-- Step 2 -->
                <div id="formStep2" class="form-step">
                    <h2>Description</h2>

                    <label>Start Event:</label>
                    <input type="text" id="startInput" name="Start"
                        placeholder="Hari, Tanggal (contoh: Senin, 24 Oktober 2025)" required />

                    <label>Location:</label>
                    <input type="text" id="locationInput" name="Location" placeholder="Tempat Acara" required />

                    <label>Link:</label>
                    <input type="url" id="linkInput" name="Link" placeholder="https://example.com" />

                    <label>Description:</label>
                    <textarea id="descInput" name="Description" placeholder="Tuliskan deskripsi singkat..."
                        required></textarea>

                    <div class="modal-buttons">
                        <button type="button" class="btn-back" id="backBtn">Back</button>
                        <input type="submit" class="btn-save" name="addevent" id="saveBtn" value="Save" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="EA.js" defer></script>
</body>

</html>