const API_URL = "api_events.php";

// DOM Elements
const input = document.getElementById("searchInput");
const tbody = document.getElementById("eventTbody");
const historyTbody = document.getElementById("historyTbody");
const filterTanggal = document.getElementById("filterTanggal");
const filterKategori = document.getElementById("filterKategori");
const filterStatus = document.getElementById("filterStatus");

// Data cache
let eventsData = [];
let historyData = [];

// State untuk mencegah multiple clicks
let isProcessing = false;

// Modal instances
let editModal, deleteModal, addModal;

// Current editing/deleting data
let currentRowToDelete = null;

// Helper function to format date without timezone conversion
function formatDateFromString(dateString) {
  if (!dateString) return "";
  const [year, month, day] = dateString.split("-");
  return new Date(year, month - 1, day).toLocaleDateString("id-ID", {
    day: "numeric",
    month: "long",
    year: "numeric",
  });
}

function parseDateFromString(dateString) {
  if (!dateString) return null;
  const [year, month, day] = dateString.split("-");
  return new Date(year, month - 1, day);
}

// Initialize everything when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  // Initialize modals
  editModal = new bootstrap.Modal(document.getElementById("editEventModal"));
  deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
  addModal = new bootstrap.Modal(document.getElementById("addEventModal"));

  // Set up event listeners
  setupEventListeners();
  setupFormHandlers();
  setupNavigation();

  // Initial load
  fetchEvents();
});

// Setup event listeners using event delegation
function setupEventListeners() {
  // Event delegation for event table
  document.getElementById("eventTbody").addEventListener("click", function (e) {
    if (e.target.closest(".action-btn.edit")) {
      e.preventDefault();
      e.stopPropagation();
      const button = e.target.closest(".action-btn.edit");
      handleEditClick(button);
    }
    if (e.target.closest(".action-btn.delete")) {
      e.preventDefault();
      e.stopPropagation();
      const button = e.target.closest(".action-btn.delete");
      handleDeleteClick(button);
    }
    if (e.target.closest(".event-row") && !e.target.closest(".action-btns")) {
      const row = e.target.closest(".event-row");
      handleRowClick(row);
    }
  });

  // Event delegation for history table
  document.getElementById("historyTbody").addEventListener("click", function (e) {
    if (e.target.closest(".action-btn.edit")) {
      e.preventDefault();
      e.stopPropagation();
      const button = e.target.closest(".action-btn.edit");
      handleEditClick(button);
    }
    if (e.target.closest(".action-btn.delete")) {
      e.preventDefault();
      e.stopPropagation();
      const button = e.target.closest(".action-btn.delete");
      handleDeleteClick(button);
    }
    if (e.target.closest(".event-row") && !e.target.closest(".action-btns")) {
      const row = e.target.closest(".event-row");
      handleRowClick(row);
    }
  });
}

// Handle edit button click
function handleEditClick(button) {
  if (isProcessing) return;
  const row = button.closest("tr");
  const eventId = row.dataset.eventId;
  const eventData = eventsData.find((event) => event.id == eventId) || historyData.find((event) => event.id == eventId);
  if (eventData) {
    populateEditForm(eventData);
    editModal.show();
  } else {
    loadEventForEdit(eventId);
  }
}

// Handle delete button click
function handleDeleteClick(button) {
  if (isProcessing) return;
  const row = button.closest("tr");
  const eventId = row.dataset.eventId;
  const eventName = row.querySelector(".ev-name").textContent;
  showDeleteConfirmation(eventId, eventName, row);
}

// Handle row click for expand/collapse
function handleRowClick(row) {
  const eventId = row.dataset.eventId;
  const detailsRow = document.getElementById(`details-${eventId}`);
  if (!detailsRow) return;
  row.classList.toggle("expanded");
  detailsRow.classList.toggle("show");
  document.querySelectorAll(".event-row").forEach((otherRow) => {
    if (otherRow !== row && otherRow.classList.contains("expanded")) {
      otherRow.classList.remove("expanded");
      const otherEventId = otherRow.dataset.eventId;
      const otherDetailsRow = document.getElementById(`details-${otherEventId}`);
      if (otherDetailsRow) otherDetailsRow.classList.remove("show");
    }
  });
}

// Load event data for editing
async function loadEventForEdit(eventId) {
  if (isProcessing) return;
  isProcessing = true;
  try {
    const response = await fetch(`${API_URL}?id=${eventId}`);
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
    const result = await response.json();
    if (result.success) {
      populateEditForm(result.data);
      editModal.show();
    } else {
      showErrorMessage("Gagal memuat data event: " + result.message);
    }
  } catch (error) {
    console.error("Error loading event:", error);
    showErrorMessage("Terjadi kesalahan saat memuat data event");
  } finally {
    isProcessing = false;
  }
}

// Populate edit form with event data
function populateEditForm(event) {
  document.getElementById("editFormStep2").classList.add("d-none");
  document.getElementById("editFormStep1").classList.remove("d-none");
  document.getElementById("editEventId").value = event.id || "";
  document.getElementById("editNamaEvent").value = event.name || "";
  document.getElementById("editTanggalEvent").value = event.tanggal_event || "";
  document.getElementById("editTanggalEventAkhir").value = event.tanggal_event_akhir || "";
  document.getElementById("editTanggalPendaftaranAwal").value = event.tanggal_pendaftaran_awal || "";
  document.getElementById("editTanggalPendaftaranAkhir").value = event.tanggal_pendaftaran_akhir || "";
  
  // Flatpickr population
  if (window.flatpickr && document.getElementById("editTanggalPendaftaranRange")) {
    const fpReg = document.getElementById("editTanggalPendaftaranRange")._flatpickr;
    if (fpReg && event.tanggal_pendaftaran_awal && event.tanggal_pendaftaran_akhir) {
      fpReg.setDate([event.tanggal_pendaftaran_awal, event.tanggal_pendaftaran_akhir], true);
    }
  }
  if (window.flatpickr && document.getElementById("editTanggalEventRange")) {
    const fpEvent = document.getElementById("editTanggalEventRange")._flatpickr;
    if (fpEvent) {
      const endDate = event.tanggal_event_akhir;
      if (event.tanggal_event && endDate) {
        fpEvent.setDate([event.tanggal_event, endDate], true);
      } else if (event.tanggal_event) {
        fpEvent.setDate([event.tanggal_event], true);
      }
    }
  }
  document.getElementById("editJamEvent").value = event.jam_event || "";
  document.getElementById("editLokasi").value = event.lokasi || "";
  document.getElementById("editTautan").value = event.link || "";
  document.getElementById("editDeskripsi").value = event.deskripsi || "";
  document.getElementById("editBiaya").value = event.biaya || 0;
  document.getElementById("editPeserta").value = event.peserta || "Mahasiswa";
  document.getElementById("editKategoriEvent").value = event.kategori || "Festival";

  const previewEditLogo = document.getElementById("previewEditLogo");
  if (event.logo) {
    previewEditLogo.src = event.logo;
    previewEditLogo.style.display = "block";
  } else {
    previewEditLogo.style.display = "none";
  }
}

// Setup form handlers
function setupFormHandlers() {
  function formatYMD(d) { if (!d) return ""; const y = d.getFullYear(); const m = ("0" + (d.getMonth() + 1)).slice(-2); const day = ("0" + d.getDate()).slice(-2); return `${y}-${m}-${day}`; }
  if (typeof flatpickr !== "undefined") {
    const regRange = document.getElementById("tanggalPendaftaranRange"); const regStartHidden = document.getElementById("tanggalPendaftaranAwal"); const regEndHidden = document.getElementById("tanggalPendaftaranAkhir");
    if (regRange) flatpickr(regRange, { mode: "range", dateFormat: "Y-m-d", locale: "id", onChange: function (selectedDates) { if (selectedDates.length >= 1) regStartHidden.value = formatYMD(selectedDates[0]); if (selectedDates.length >= 2) regEndHidden.value = formatYMD(selectedDates[1]); }, });
    const eventRange = document.getElementById("tanggalEventRange"); const eventHidden = document.getElementById("tanggalEvent"); const eventEndHidden = document.getElementById("tanggalEventAkhir");
    if (eventRange) flatpickr(eventRange, { mode: "range", dateFormat: "Y-m-d", locale: "id", onChange: function (selectedDates) { if (selectedDates.length >= 1) eventHidden.value = formatYMD(selectedDates[0]); if (selectedDates.length >= 2) eventEndHidden.value = formatYMD(selectedDates[1]); else eventEndHidden.value = ""; }, });
    const editRegRange = document.getElementById("editTanggalPendaftaranRange"); const editRegStartHidden = document.getElementById("editTanggalPendaftaranAwal"); const editRegEndHidden = document.getElementById("editTanggalPendaftaranAkhir");
    if (editRegRange) flatpickr(editRegRange, { mode: "range", dateFormat: "Y-m-d", locale: "id", onChange: function (selectedDates) { if (selectedDates.length >= 1) editRegStartHidden.value = formatYMD(selectedDates[0]); if (selectedDates.length >= 2) editRegEndHidden.value = formatYMD(selectedDates[1]); }, });
    const editEventRange = document.getElementById("editTanggalEventRange"); const editEventHidden = document.getElementById("editTanggalEvent"); const editEventEndHidden = document.getElementById("editTanggalEventAkhir");
    if (editEventRange) flatpickr(editEventRange, { mode: "range", dateFormat: "Y-m-d", locale: "id", onChange: function (selectedDates) { if (selectedDates.length >= 1) editEventHidden.value = formatYMD(selectedDates[0]); if (selectedDates.length >= 2) editEventEndHidden.value = formatYMD(selectedDates[1]); else editEventEndHidden.value = ""; }, });
  }
  
  document.getElementById("formStep2").addEventListener("submit", handleAddEventSubmit);
  document.getElementById("editFormStep2").addEventListener("submit", handleEditEventSubmit);
  document.getElementById("nextStep").addEventListener("click", () => { document.getElementById("formStep1").classList.add("d-none"); document.getElementById("formStep2").classList.remove("d-none"); });
  document.getElementById("backStep").addEventListener("click", () => { document.getElementById("formStep2").classList.add("d-none"); document.getElementById("formStep1").classList.remove("d-none"); });
  document.getElementById("editNextStep").addEventListener("click", () => { document.getElementById("editFormStep1").classList.add("d-none"); document.getElementById("editFormStep2").classList.remove("d-none"); });
  document.getElementById("editBackStep").addEventListener("click", () => { document.getElementById("editFormStep2").classList.add("d-none"); document.getElementById("editFormStep1").classList.remove("d-none"); });
  document.getElementById("confirmDelete").addEventListener("click", handleDeleteConfirm);
  document.querySelector(".add-event").addEventListener("click", () => { addModal.show(); });
  setupFilePreview();
  [input, filterTanggal, filterKategori, filterStatus].forEach((el) => { el.addEventListener("input", filterTable); });
  [filterTanggal, filterKategori, filterStatus].forEach((el) => { el.addEventListener("change", filterTable); });
}

// Setup file preview
function setupFilePreview() {
  const logoInput = document.getElementById("logoEvent"); const fileWarning = document.getElementById("fileWarning"); const previewLogo = document.getElementById("previewLogo");
  logoInput.addEventListener("change", function () {
    fileWarning.textContent = ""; previewLogo.style.display = "none";
    const file = this.files[0];
    if (file) {
      const validTypes = ["image/jpeg", "image/png"]; if (!validTypes.includes(file.type)) { fileWarning.textContent = "❌ Format file harus JPG atau PNG."; this.value = ""; return; }
      if (file.size > 10 * 1024 * 1024) { fileWarning.textContent = "❌ Ukuran file maksimal 10MB."; this.value = ""; return; }
      const reader = new FileReader(); reader.onload = (e) => { previewLogo.src = e.target.result; previewLogo.style.display = "block"; }; reader.readAsDataURL(file);
    }
  });
  const editLogoInput = document.getElementById("editLogoEvent"); const editFileWarning = document.getElementById("editFileWarning"); const previewEditLogo = document.getElementById("previewEditLogo");
  editLogoInput.addEventListener("change", function () {
    editFileWarning.textContent = "";
    const file = this.files[0];
    if (file) {
      const validTypes = ["image/jpeg", "image/png"]; if (!validTypes.includes(file.type)) { editFileWarning.textContent = "❌ Format file harus JPG atau PNG."; this.value = ""; return; }
      if (file.size > 10 * 1024 * 1024) { editFileWarning.textContent = "❌ Ukuran file maksimal 10MB."; this.value = ""; return; }
      const reader = new FileReader(); reader.onload = (e) => { previewEditLogo.src = e.target.result; previewEditLogo.style.display = "block"; }; reader.readAsDataURL(file);
    }
  });
}

// Handle add event form submission
async function handleAddEventSubmit(e) {
  e.preventDefault(); if (isProcessing) return; isProcessing = true;
  const namaEvent = document.getElementById("namaEvent").value.trim(); const tanggalEvent = document.getElementById("tanggalEvent").value; const tanggalPendaftaranAwal = document.getElementById("tanggalPendaftaranAwal").value; const tanggalPendaftaranAkhir = document.getElementById("tanggalPendaftaranAkhir").value; const jamEvent = document.getElementById("jamEvent").value; const lokasi = document.getElementById("lokasi").value.trim(); const tautan = document.getElementById("tautan").value.trim(); const deskripsi = document.getElementById("deskripsi").value.trim(); const biaya = document.getElementById("biaya").value;
  if (!namaEvent || !tanggalEvent || !tanggalPendaftaranAwal || !tanggalPendaftaranAkhir || !jamEvent || !tautan || !deskripsi) { showErrorMessage("Mohon lengkapi semua field yang wajib diisi, termasuk Link dan Deskripsi"); isProcessing = false; return; }
  const regStartDate = parseDateFromString(tanggalPendaftaranAwal); const regEndDate = parseDateFromString(tanggalPendaftaranAkhir); const eventDate = parseDateFromString(tanggalEvent);
  if (regStartDate > regEndDate) { showErrorMessage("Tanggal pendaftaran awal tidak boleh lebih dari tanggal pendaftaran akhir"); isProcessing = false; return; }
  if (eventDate < regEndDate) { showErrorMessage("Tanggal event harus setelah atau sama dengan tanggal pendaftaran akhir"); isProcessing = false; return; }
  if (!isValidUrl(tautan)) { showErrorMessage("Format link pendaftaran tidak valid. Harap masukkan URL yang valid (contoh: https://example.com)"); isProcessing = false; return; }
  if (deskripsi.length < 10 || deskripsi.length > 1000) { showErrorMessage("Deskripsi event harus diisi dengan 10-1000 karakter"); isProcessing = false; return; }
  if (biaya && (isNaN(parseFloat(biaya)) || parseFloat(biaya) < 0)) { showErrorMessage("Biaya harus berupa angka yang valid dan tidak boleh negatif"); isProcessing = false; return; }
  if (namaEvent.length < 3 || namaEvent.length > 100) { showErrorMessage("Nama event harus diisi dengan 3-100 karakter"); isProcessing = false; return; }

  const formData = new FormData();
  formData.append("name", namaEvent); formData.append("tanggal_event", tanggalEvent); formData.append("tanggal_event_akhir", document.getElementById("tanggalEventAkhir").value); formData.append("tanggal_pendaftaran_awal", tanggalPendaftaranAwal); formData.append("tanggal_pendaftaran_akhir", tanggalPendaftaranAkhir); formData.append("jam_event", jamEvent); formData.append("lokasi", lokasi); formData.append("link", tautan); formData.append("deskripsi", deskripsi); formData.append("biaya", biaya || 0); formData.append("peserta", document.getElementById("peserta").value); formData.append("kategori", document.getElementById("kategoriEvent").value);
  const logoFile = document.getElementById("logoEvent").files[0]; if (logoFile) { formData.append("logo", logoFile); }

  try {
    const submitBtn = e.target.querySelector('button[type="submit"]'); const originalText = submitBtn.textContent; submitBtn.disabled = true; submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    const response = await fetch(API_URL, { method: "POST", body: formData });
    const result = await response.json();
    if (result.success) {
      showSuccessToast("Berhasil", "Event berhasil ditambahkan");
      addModal._element.addEventListener('hidden.bs.modal', function () {
        e.target.reset(); document.getElementById("formStep2").classList.add("d-none"); document.getElementById("formStep1").classList.remove("d-none"); document.getElementById("previewLogo").style.display = "none"; fetchEvents();
      }, { once: true });
      addModal.hide();
    } else {
      showErrorMessage("Gagal menambahkan event: " + result.message);
    }
  } catch (error) {
    console.error("Error:", error); showErrorMessage("Terjadi kesalahan saat menambahkan event");
  } finally {
    const submitBtn = e.target.querySelector('button[type="submit"]'); if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = submitBtn.getAttribute('data-original-text') || 'Simpan'; } isProcessing = false;
  }
}

// Handle edit event form submission
async function handleEditEventSubmit(e) {
  e.preventDefault(); if (isProcessing) return; isProcessing = true;
  const namaEvent = document.getElementById("editNamaEvent").value.trim(); const tanggalEvent = document.getElementById("editTanggalEvent").value; const tanggalPendaftaranAwal = document.getElementById("editTanggalPendaftaranAwal").value; const tanggalPendaftaranAkhir = document.getElementById("editTanggalPendaftaranAkhir").value; const jamEvent = document.getElementById("editJamEvent").value; const lokasi = document.getElementById("editLokasi").value.trim(); const tautan = document.getElementById("editTautan").value.trim(); const deskripsi = document.getElementById("editDeskripsi").value.trim(); const biaya = document.getElementById("editBiaya").value;
  if (!namaEvent || !tanggalEvent || !tanggalPendaftaranAwal || !tanggalPendaftaranAkhir || !jamEvent || !tautan || !deskripsi) { showErrorMessage("Mohon lengkapi semua field yang wajib diisi, termasuk Link dan Deskripsi"); isProcessing = false; return; }
  const regStartDate = parseDateFromString(tanggalPendaftaranAwal); const regEndDate = parseDateFromString(tanggalPendaftaranAkhir); const eventDate = parseDateFromString(tanggalEvent);
  if (regStartDate > regEndDate) { showErrorMessage("Tanggal pendaftaran awal tidak boleh lebih dari tanggal pendaftaran akhir"); isProcessing = false; return; }
  if (eventDate < regEndDate) { showErrorMessage("Tanggal event harus setelah atau sama dengan tanggal pendaftaran akhir"); isProcessing = false; return; }
  if (!isValidUrl(tautan)) { showErrorMessage("Format link pendaftaran tidak valid. Harap masukkan URL yang valid (contoh: https://example.com)"); isProcessing = false; return; }
  if (deskripsi.length < 10 || deskripsi.length > 1000) { showErrorMessage("Deskripsi event harus diisi dengan 10-1000 karakter"); isProcessing = false; return; }
  if (biaya && (isNaN(parseFloat(biaya)) || parseFloat(biaya) < 0)) { showErrorMessage("Biaya harus berupa angka yang valid dan tidak boleh negatif"); isProcessing = false; return; }
  if (namaEvent.length < 3 || namaEvent.length > 100) { showErrorMessage("Nama event harus diisi dengan 3-100 karakter"); isProcessing = false; return; }

  const eventId = document.getElementById("editEventId").value; const formData = new FormData();
  formData.append("_method", "PUT"); formData.append("name", namaEvent); formData.append("tanggal_event", tanggalEvent); formData.append("tanggal_event_akhir", document.getElementById("editTanggalEventAkhir").value); formData.append("tanggal_pendaftaran_awal", tanggalPendaftaranAwal); formData.append("tanggal_pendaftaran_akhir", tanggalPendaftaranAkhir); formData.append("jam_event", jamEvent); formData.append("lokasi", lokasi); formData.append("link", tautan); formData.append("deskripsi", deskripsi); formData.append("biaya", biaya || 0); formData.append("peserta", document.getElementById("editPeserta").value); formData.append("kategori", document.getElementById("editKategoriEvent").value);
  const logoFile = document.getElementById("editLogoEvent").files[0]; if (logoFile) { formData.append("logo", logoFile); }

  try {
    const submitBtn = e.target.querySelector('button[type="submit"]'); const originalText = submitBtn.textContent; submitBtn.disabled = true; submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memperbarui...';
    const response = await fetch(`${API_URL}?id=${eventId}`, { method: "POST", body: formData });
    const result = await response.json();
    if (result.success) {
      showSuccessToast("Berhasil", "Event berhasil diperbarui");
      editModal._element.addEventListener('hidden.bs.modal', function () {
        e.target.reset(); document.getElementById("editFormStep2").classList.add("d-none"); document.getElementById("editFormStep1").classList.remove("d-none"); document.getElementById("previewEditLogo").style.display = "none"; fetchEvents();
      }, { once: true });
      editModal.hide();
    } else {
      showErrorMessage("Gagal memperbarui event: " + result.message);
    }
  } catch (error) {
    console.error("Error updating event:", error); showErrorMessage("Terjadi kesalahan saat memperbarui event");
  } finally {
    const submitBtn = e.target.querySelector('button[type="submit"]'); if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = submitBtn.getAttribute('data-original-text') || 'Perbarui'; } isProcessing = false;
  }
}

// Fungsi bantu: validasi format URL
function isValidUrl(string) { try { new URL(string); return true; } catch (_) { return false; } }

// Show delete confirmation modal
function showDeleteConfirmation(eventId, eventName, row) {
  const isHistoryPage = !document.getElementById("historyPage").classList.contains("d-none");
  document.getElementById("deleteEventName").textContent = eventName;
  const modalTitle = document.querySelector("#deleteModal .modal-title"); const modalText = document.querySelector("#deleteModal .modal-text"); const confirmBtn = document.getElementById("confirmDelete");
  if (isHistoryPage) {
    modalTitle.textContent = "Hapus Event Permanen?"; modalText.textContent = `Apakah Anda yakin ingin menghapus event "${eventName}" secara permanen? Tindakan ini tidak dapat dibatalkan.`; confirmBtn.textContent = "Hapus Permanen"; confirmBtn.className = "btn-delete";
  } else {
    modalTitle.textContent = "Hapus Event?"; modalText.textContent = `Apakah Anda yakin ingin menghapus event "${eventName}"? Event akan dipindahkan ke history.`; confirmBtn.textContent = "Hapus"; confirmBtn.className = "btn-delete";
  }
  currentRowToDelete = { eventId: eventId, eventName: eventName, isHistoryPage: isHistoryPage, };
  deleteModal.show();
}

// Handle delete confirmation
async function handleDeleteConfirm() {
  if (!currentRowToDelete || isProcessing) return; isProcessing = true;
  try {
    const confirmBtn = document.getElementById("confirmDelete"); const originalText = confirmBtn.textContent; confirmBtn.disabled = true; confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
    const response = await fetch(`${API_URL}?id=${currentRowToDelete.eventId}`, { method: "DELETE", });
    const result = await response.json();
    if (result.success) {
      if (currentRowToDelete.isHistoryPage) { showSuccessToast("Berhasil", `Event "${currentRowToDelete.eventName}" telah dihapus permanen`); } else { showSuccessToast("Berhasil", `Event "${currentRowToDelete.eventName}" telah dipindahkan ke history`); }
      deleteModal._element.addEventListener('hidden.bs.modal', function () { fetchEvents(); }, { once: true });
      deleteModal.hide();
    } else {
      showErrorMessage("Gagal memproses event: " + result.message);
    }
  } catch (error) {
    console.error("Error:", error); showErrorMessage("Terjadi kesalahan saat memproses event");
  } finally {
    const confirmBtn = document.getElementById("confirmDelete"); if (confirmBtn) { confirmBtn.disabled = false; confirmBtn.textContent = originalText; } currentRowToDelete = null; isProcessing = false;
  }
}

// Setup navigation
function setupNavigation() {
  const pageEvent = document.getElementById("eventPage"); const pageHistory = document.getElementById("historyPage"); const btnEvent = document.querySelector(".nav-item.active"); const btnHistory = document.getElementById("menuHistory"); const filterRow = document.querySelector(".filter-row");
  btnHistory.addEventListener("click", () => {
    btnEvent.classList.remove("active"); btnHistory.classList.add("active"); pageEvent.style.display = "none"; pageHistory.classList.remove("d-none"); filterRow.style.display = "flex"; filterStatus.closest("div").style.display = "none";
    filterTanggal.value = ""; filterKategori.value = ""; filterStatus.value = ""; input.value = ""; filterTable();
  });
  btnEvent.addEventListener("click", () => {
    btnHistory.classList.remove("active"); btnEvent.classList.add("active"); pageHistory.classList.add("d-none"); pageEvent.style.display = "block"; filterRow.style.display = "flex"; filterStatus.closest("div").style.display = "block";
    filterTanggal.value = ""; filterKategori.value = ""; filterStatus.value = ""; input.value = ""; filterTable();
  });
}

// Fetch events from API
async function fetchEvents() {
  try {
    const response = await fetch(API_URL); const result = await response.json();
    if (result.success) {
      // Status sudah dihitung di API, tinggal pisahkan berdasarkan status
      eventsData = result.data.filter((ev) => ev.status !== 'Selesai');
      historyData = result.data.filter((ev) => ev.status === 'Selesai');
      renderEvents(); renderHistory();
    } else {
      showErrorMessage("Gagal memuat data event: " + result.message);
    }
  } catch (error) {
    console.error("Error:", error); showErrorMessage("Terjadi kesalahan saat memuat data");
  }
}

// Render events table
function renderEvents() {
  tbody.innerHTML = "";
  if (eventsData.length === 0) { tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4">Tidak ada data event</td></tr>'; return; }
  eventsData.forEach((event) => { const row = createEventRow(event); tbody.appendChild(row); const detailsRow = createDetailsRow(event); tbody.appendChild(detailsRow); });
}

// Render history table
function renderHistory() {
  historyTbody.innerHTML = "";
  if (historyData.length === 0) { historyTbody.innerHTML = '<tr><td colspan="8" class="text-center py-4">Tidak ada data history</td></tr>'; return; }
  historyData.forEach((event) => { const row = createEventRow(event, true); historyTbody.appendChild(row); const detailsRow = createDetailsRow(event); historyTbody.appendChild(detailsRow); });
}

// Create event row
function createEventRow(event, isHistory = false) {
  const row = document.createElement("tr"); row.className = "event-row"; row.dataset.eventId = event.id;
  const formattedEventStart = formatDateFromString(event.tanggal_event); const formattedEventEnd = event.tanggal_event_akhir ? formatDateFromString(event.tanggal_event_akhir) : "";
  const formattedPrice = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR", minimumFractionDigits: 0, }).format(event.biaya);
  
  // PERUBAHAN: Gunakan status langsung dari API tanpa perhitungan ulang
  const status = event.status;
  let statusBadge = "";
  switch (status) {
    case "Pendaftaran Dibuka": statusBadge = '<span class="badge-pill badge-open">Pendaftaran Dibuka</span>'; break;
    case "Akan Datang": statusBadge = '<span class="badge-pill badge-up">Akan Datang</span>'; break;
    case "Pendaftaran Ditutup": statusBadge = '<span class="badge-pill badge-close">Pendaftaran Ditutup</span>'; break;
    case "Sedang Berlangsung": statusBadge = '<span class="badge-pill badge-on">Sedang Berlangsung</span>'; break;
    case "Selesai": statusBadge = '<span class="badge-pill badge-history">Selesai</span>'; break;
  }

  const logoSrc = event.logo ? event.logo : "https://picsum.photos/seed/event" + event.id + "/45/55.jpg";
  const actionButtons = isHistory ? `<div class="action-btns"><button class="action-btn delete" title="Hapus Permanen"><i class="fa-solid fa-trash"></i></button></div>` : `<div class="action-btns"><button class="action-btn edit" title="Edit"><i class="fa-solid fa-pen"></i></button><button class="action-btn delete" title="Hapus"><i class="fa-solid fa-trash"></i></button></div>`;
  row.innerHTML = `<td><i class="expand-icon"></i><img class="ev-thumb" src="${logoSrc}" alt="${event.name}"></td><td class="ev-name">${event.name}</td><td class="date-cell">${formattedEventStart}${formattedEventEnd ? "<br>" + formattedEventEnd : ""}</td><td>${formattedPrice}</td><td>${statusBadge}</td><td><span class="badge-pill badge-peserta ${event.peserta.toLowerCase() === "mahasiswa" ? "mahasiswa" : "umum"}"> ${event.peserta}</span></td><td>${event.kategori}</td><td>${actionButtons}</td>`;
  return row;
}

// Create details row
function createDetailsRow(event) {
  const detailsRow = document.createElement("tr"); detailsRow.className = "event-details"; detailsRow.id = `details-${event.id}`;
  const formattedRegStart = formatDateFromString(event.tanggal_pendaftaran_awal); const formattedRegEnd = formatDateFromString(event.tanggal_pendaftaran_akhir);
  const formattedEventStart = formatDateFromString(event.tanggal_event); const formattedEventEnd = event.tanggal_event_akhir ? formatDateFromString(event.tanggal_event_akhir) : "";
  detailsRow.innerHTML = `<td colspan="8"><div class="details-content"><div class="details-grid"><div class="detail-item"><div class="detail-icon"><i class="fa-solid fa-calendar-check"></i></div><div class="detail-text"><div class="detail-label">Tanggal Pendaftaran</div><div class="detail-value">${formattedRegStart} - ${formattedRegEnd}</div></div></div><div class="detail-item"><div class="detail-icon"><i class="fa-solid fa-calendar-day"></i></div><div class="detail-text"><div class="detail-label">Tanggal Event</div><div class="detail-value">${formattedEventStart}${formattedEventEnd ? " - " + formattedEventEnd : ""}</div></div></div><div class="detail-item"><div class="detail-icon"><i class="fa-solid fa-clock"></i></div><div class="detail-text"><div class="detail-label">Jam Event</div><div class="detail-value">${formatTimeHHMM(event.jam_event)} WIB</div></div></div><div class="detail-item"><div class="detail-icon"><i class="fa-solid fa-location-dot"></i></div><div class="detail-text"><div class="detail-label">Lokasi</div><div class="detail-value">${event.lokasi || "Tidak tersedia"}</div></div></div><div class="detail-item"><div class="detail-icon"><i class="fa-solid fa-link"></i></div><div class="detail-text"><div class="detail-label">Link Pendaftaran</div><div class="detail-value">${event.link ? `<a href="${event.link}" class="detail-link" target="_blank">${event.link}</a>` : "Tidak tersedia"}</div></div></div><div class="detail-item" style="grid-column: 1 / -1;"><div class="detail-icon"><i class="fa-solid fa-info-circle"></i></div><div class="detail-text"><div class="detail-label">Deskripsi</div><div class="detail-value" style="white-space: pre-wrap; word-wrap: break-word;">${event.deskripsi || "Tidak ada deskripsi"}</div></div></div></div></div></td>`;
  return detailsRow;
}

// Format waktu
function formatTimeHHMM(timeString) { if (!timeString) return ""; const parts = timeString.split(":"); if (parts.length >= 2) { const hh = parts[0].padStart(2, "0"); const mm = parts[1].padStart(2, "0"); return `${hh}:${mm}`; } return timeString; }

// Filter table
function filterTable() {
  const search = input.value.trim().toLowerCase(); const tgl = filterTanggal.value; const kategori = filterKategori.value; const status = filterStatus.value;
  const isHistoryPage = !document.getElementById("historyPage").classList.contains("d-none"); const activeData = isHistoryPage ? historyData : eventsData; const activeTbody = isHistoryPage ? historyTbody : tbody;
  activeTbody.innerHTML = "";
  const filteredData = activeData.filter((event) => {
    const text = Object.values(event).join(" ").toLowerCase();
    const matchSearch = search === "" || text.includes(search);
    const matchDate = !tgl || event.tanggal_event === tgl;
    const matchKategori = !kategori || (event.kategori && event.kategori.toLowerCase() === kategori.toLowerCase());
    const matchStatus = !status || (event.status && event.status.toLowerCase() === status.toLowerCase());
    return matchSearch && matchDate && matchKategori && matchStatus;
  });
  if (filteredData.length === 0) { activeTbody.innerHTML = '<tr><td colspan="8" class="text-center py-4">Tidak ada data yang cocok dengan filter</td></tr>'; return; }
  filteredData.forEach((event) => { const row = createEventRow(event, isHistoryPage); activeTbody.appendChild(row); const detailsRow = createDetailsRow(event); activeTbody.appendChild(detailsRow); });
}

// Toast notification functions
function showSuccessToast(title, message) {
  const toastContainer = document.getElementById("toastContainer"); const toast = document.createElement("div"); toast.className = "success-toast"; toast.innerHTML = `<div class="toast-icon"><i class="fa-solid fa-check"></i></div><div class="toast-content"><div class="toast-title">${title}</div><div class="toast-message">${message}</div></div>`; toastContainer.appendChild(toast);
  setTimeout(() => { toast.style.animation = "slideIn 0.3s ease-out reverse"; setTimeout(() => toast.remove(), 300); }, 3000);
}
function showErrorMessage(message) {
  const toastContainer = document.getElementById("toastContainer"); const toast = document.createElement("div"); toast.className = "success-toast"; toast.innerHTML = `<div class="toast-icon" style="background: #fee2e2;"><i class="fa-solid fa-exclamation-triangle" style="color: #dc2626;"></i></div><div class="toast-content"><div class="toast-title">Error</div><div class="toast-message">${message}</div></div>`; toastContainer.appendChild(toast);
  setTimeout(() => { toast.style.animation = "slideIn 0.3s ease-out reverse"; setTimeout(() => toast.remove(), 300); }, 3000);
}