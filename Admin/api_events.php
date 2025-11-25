<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../Database/koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

// --- PERUBAHAN 1: Tentukan siapa yang memanggil API ---
// Cek parameter 'for' di URL. Jika tidak ada, asumsikan pemanggil adalah 'admin'.
$requestFor = isset($_GET['for']) ? $_GET['for'] : 'admin';

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Get single event (logika ini bisa dikembangkan di kemudian hari)
            $id = $conn->real_escape_string($_GET['id']);
            $sql = "SELECT * FROM events WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $event = $result->fetch_assoc();
                echo json_encode(['success' => true, 'data' => $event]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Event tidak ditemukan']);
            }
        } else {
            // --- PERUBAHAN 2: Gunakan logika berbeda untuk Mahasiswa dan Admin ---
            if ($requestFor === 'mahasiswa') {
                // Query khusus untuk Mahasiswa, dengan alias agar sesuai dengan frontend
                $sql = "SELECT 
                            id, 
                            name AS title, 
                            logo AS image, 
                            tanggal_event AS date, 
                            tanggal_pendaftaran_awal AS registrationDate, 
                            tanggal_pendaftaran_akhir AS registrationEndDate, 
                            tanggal_event AS endDate, 
                            lokasi AS location, 
                            status, 
                            peserta AS participantType, 
                            kategori AS category, 
                            jam_event AS time, 
                            biaya AS price, 
                            deskripsi AS description, 
                            link 
                        FROM events 
                        ORDER BY tanggal_event DESC";
            } else {
                // Query default untuk Admin, dengan nama kolom asli
                $sql = "SELECT * FROM events ORDER BY tanggal_event DESC";
            }

            $result = $conn->query($sql);
            $events = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // --- PERUBAHAN 3: Format data khusus untuk Mahasiswa ---
                    if ($requestFor === 'mahasiswa') {
                        // Perbaiki path gambar agar dapat diakses dari folder Mahasiswa
                        if (!empty($row['image'])) {
                            $row['image'] = '../Admin/' . $row['image'];
                        }
                        // Format harga agar lebih mudah dibaca
                        if ($row['price'] > 0) {
                            $row['price'] = 'Rp ' . number_format($row['price'], 0, ',', '.');
                        } else {
                            $row['price'] = 'Gratis';
                        }
                    }
                    $events[] = $row;
                }
            }

            echo json_encode(['success' => true, 'data' => $events]);
        }
        break;

    case 'POST':
        // Create new event (kode ini tetap)
        $name = $_POST['name'];
        $tanggal_event = $_POST['tanggal_event'];
        $tanggal_pendaftaran_awal = $_POST['tanggal_pendaftaran_awal'];
        $tanggal_pendaftaran_akhir = $_POST['tanggal_pendaftaran_akhir'];
        $jam_event = $_POST['jam_event'];
        $lokasi = $_POST['lokasi'];
        $link = $_POST['link'];
        $deskripsi = $_POST['deskripsi'];
        $biaya = $_POST['biaya'];
        $peserta = $_POST['peserta'];
        $kategori = $_POST['kategori'];
        // Status tidak lagi diinput, akan digenerate otomatis di frontend
        $status = 'Akan Datang'; // Default status, akan dihitung otomatis di frontend

        // Escape input untuk keamanan
        $name = $conn->real_escape_string($_POST['name']);
        $tanggal_event = $conn->real_escape_string($_POST['tanggal_event']);
        $tanggal_pendaftaran_awal = $conn->real_escape_string($_POST['tanggal_pendaftaran_awal']);
        $tanggal_pendaftaran_akhir = $conn->real_escape_string($_POST['tanggal_pendaftaran_akhir']);
        $jam_event = $conn->real_escape_string($_POST['jam_event']);
        $lokasi = $conn->real_escape_string($_POST['lokasi']);
        $link = $conn->real_escape_string($_POST['link']);
        $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
        $peserta = $conn->real_escape_string($peserta);
        $kategori = $conn->real_escape_string($kategori);

        // Handle logo upload
        $logo = '';
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name = time() . '_' . basename($_FILES['logo']['name']);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
                $logo = $target_file;
            }
        }

        $sql = "INSERT INTO events (name, logo, tanggal_event, tanggal_pendaftaran_awal, tanggal_pendaftaran_akhir, jam_event, lokasi, link, deskripsi, biaya, peserta, status, kategori) 
                VALUES ('$name', '$logo', '$tanggal_event', '$tanggal_pendaftaran_awal', '$tanggal_pendaftaran_akhir', '$jam_event', '$lokasi', '$link', '$deskripsi', '$biaya', '$peserta', '$status', '$kategori')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Event berhasil ditambahkan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        }
        break;

    case 'PUT':
        // Update event (handled by update.php)
        break;

    case 'DELETE':
        // Delete or move to history (kode ini tetap)
        $id = $_GET['id'];

        $sql = "SELECT status FROM events WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_status = $row['status'];

            if ($current_status === 'Selesai') {
                $sql = "DELETE FROM events WHERE id = $id";
                $message = "Event berhasil dihapus permanen";
            } else {
                $sql = "UPDATE events SET status = 'Selesai' WHERE id = $id";
                $message = "Event berhasil dipindahkan ke history";
            }

            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true, 'message' => $message]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Event tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Metode tidak didukung']);
        break;
}

$conn->close();
?>