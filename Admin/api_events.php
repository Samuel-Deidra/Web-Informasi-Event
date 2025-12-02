<?php
// Atur header untuk respons JSON dan CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../Database/koneksi.php';

 $method = $_SERVER['REQUEST_METHOD'];

/**
 * Menghitung status event secara otomatis berdasarkan tanggal.
 * Fungsi ini fleksibel untuk menangani nama kolom asli (admin) dan yang sudah di-alias (mahasiswa).
 *
 * @param array $event Array data event.
 * @return string Status event.
 */
function getEventStatus($event) {
    // Tentukan kunci kolom yang akan digunakan (fleksibel)
    $regStartKey = isset($event['tanggal_pendaftaran_awal']) ? 'tanggal_pendaftaran_awal' : 'registrationDate';
    $regEndKey = isset($event['tanggal_pendaftaran_akhir']) ? 'tanggal_pendaftaran_akhir' : 'registrationEndDate';
    $eventStartKey = isset($event['tanggal_event']) ? 'tanggal_event' : 'date';
    $eventEndKey = isset($event['tanggal_event_akhir']) ? 'tanggal_event_akhir' : 'endDate';

    // Cegah error jika data tanggal tidak lengkap
    if (empty($event[$regStartKey]) || empty($event[$regEndKey]) || empty($event[$eventStartKey])) {
        return "Data Tanggal Tidak Lengkap";
    }

    $now = new DateTime();
    $now->setTime(0, 0, 0); // Abaikan waktu untuk perbandingan

    $regStart = new DateTime($event[$regStartKey]);
    $regEnd = new DateTime($event[$regEndKey]);
    $eventStart = new DateTime($event[$eventStartKey]);
    $eventEnd = !empty($event[$eventEndKey]) ? new DateTime($event[$eventEndKey]) : $eventStart;

    if ($now < $regStart) {
        return "Akan Datang";
    } elseif ($now >= $regStart && $now <= $regEnd) {
        return "Pendaftaran Dibuka";
    } elseif ($now > $regEnd && $now < $eventStart) {
        return "Pendaftaran Ditutup";
    } elseif ($now >= $eventStart && $now <= $eventEnd) {
        return "Sedang Berlangsung";
    } elseif ($now > $eventEnd) {
        return "Selesai";
    }
    return "Akan Datang";
}

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $conn->real_escape_string($_GET['id']);
            $sql = "SELECT * FROM events WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $event = $result->fetch_assoc();
                $event['status'] = getEventStatus($event);
                echo json_encode(['success' => true, 'data' => $event]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Event tidak ditemukan']);
            }
        } else {
            $requestFor = isset($_GET['for']) ? $_GET['for'] : 'admin';
            
            if ($requestFor === 'mahasiswa') {
                // Query khusus untuk Mahasiswa dengan alias
                $sql = "SELECT 
                            id, 
                            name AS title, 
                            logo AS image, 
                            tanggal_event AS date, 
                            tanggal_event_akhir AS endDate, 
                            tanggal_pendaftaran_awal AS registrationDate, 
                            tanggal_pendaftaran_akhir AS registrationEndDate, 
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
                // Query default untuk Admin
                $sql = "SELECT * FROM events ORDER BY tanggal_event DESC";
            }

            $result = $conn->query($sql);
            $events = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Hitung status menggunakan fungsi yang fleksibel
                    $row['status'] = getEventStatus($row);

                    if ($requestFor === 'mahasiswa') {
                        // Tambahkan path untuk gambar dan format harga
                        if (!empty($row['image'])) {
                            $row['image'] = '../Admin/' . $row['image'];
                        }
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
        // Cek apakah ini adalah permintaan UPDATE (dengan _method=PUT) atau CREATE
        if (isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
            // --- LOGIKA UPDATE EVENT ---
            $id = $_GET['id'];
            // Escape input untuk keamanan
            $name = $conn->real_escape_string($_POST['name']);
            $tanggal_event = $conn->real_escape_string($_POST['tanggal_event']);
            $tanggal_event_akhir = $conn->real_escape_string($_POST['tanggal_event_akhir']);
            $tanggal_pendaftaran_awal = $conn->real_escape_string($_POST['tanggal_pendaftaran_awal']);
            $tanggal_pendaftaran_akhir = $conn->real_escape_string($_POST['tanggal_pendaftaran_akhir']);
            $jam_event = $conn->real_escape_string($_POST['jam_event']);
            $lokasi = $conn->real_escape_string($_POST['lokasi']);
            $link = $conn->real_escape_string($_POST['link']);
            $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
            $biaya = $conn->real_escape_string($_POST['biaya']);
            $peserta = $conn->real_escape_string($_POST['peserta']);
            $kategori = $conn->real_escape_string($_POST['kategori']);

            // Get current event data to preserve logo if not changed
            $sql_select = "SELECT logo FROM events WHERE id = $id";
            $result = $conn->query($sql_select);
            $current_event = $result->fetch_assoc();
            $logo = $current_event['logo'];

            // Handle logo upload if new file is provided
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_name = time() . '_' . basename($_FILES['logo']['name']);
                $target_file = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
                    if ($logo && file_exists($logo)) {
                        unlink($logo);
                    }
                    $logo = $target_file;
                }
            }
            
            $eventDataForStatus = ['tanggal_pendaftaran_awal' => $tanggal_pendaftaran_awal, 'tanggal_pendaftaran_akhir' => $tanggal_pendaftaran_akhir, 'tanggal_event' => $tanggal_event, 'tanggal_event_akhir' => $tanggal_event_akhir];
            $status = getEventStatus($eventDataForStatus);

            $sql_update = "UPDATE events SET 
                    name = '$name', 
                    logo = '$logo', 
                    tanggal_event = '$tanggal_event', 
                    tanggal_event_akhir = '$tanggal_event_akhir', 
                    tanggal_pendaftaran_awal = '$tanggal_pendaftaran_awal', 
                    tanggal_pendaftaran_akhir = '$tanggal_pendaftaran_akhir', 
                    jam_event = '$jam_event', 
                    lokasi = '$lokasi', 
                    link = '$link', 
                    deskripsi = '$deskripsi', 
                    biaya = '$biaya', 
                    peserta = '$peserta', 
                    kategori = '$kategori',
                    status = '$status'
                    WHERE id = $id";

            if ($conn->query($sql_update) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Event berhasil diperbarui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
            }
        } else {
            // --- LOGIKA CREATE EVENT ---
            $name = $conn->real_escape_string($_POST['name']);
            $tanggal_event = $conn->real_escape_string($_POST['tanggal_event']);
            $tanggal_event_akhir = $conn->real_escape_string($_POST['tanggal_event_akhir']);
            $tanggal_pendaftaran_awal = $conn->real_escape_string($_POST['tanggal_pendaftaran_awal']);
            $tanggal_pendaftaran_akhir = $conn->real_escape_string($_POST['tanggal_pendaftaran_akhir']);
            $jam_event = $conn->real_escape_string($_POST['jam_event']);
            $lokasi = $conn->real_escape_string($_POST['lokasi']);
            $link = $conn->real_escape_string($_POST['link']);
            $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
            $biaya = $conn->real_escape_string($_POST['biaya']);
            $peserta = $conn->real_escape_string($_POST['peserta']);
            $kategori = $conn->real_escape_string($_POST['kategori']);
            
            $eventDataForStatus = ['tanggal_pendaftaran_awal' => $tanggal_pendaftaran_awal, 'tanggal_pendaftaran_akhir' => $tanggal_pendaftaran_akhir, 'tanggal_event' => $tanggal_event, 'tanggal_event_akhir' => $tanggal_event_akhir];
            $status = getEventStatus($eventDataForStatus);

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

            $sql_insert = "INSERT INTO events (name, logo, tanggal_event, tanggal_event_akhir, tanggal_pendaftaran_awal, tanggal_pendaftaran_akhir, jam_event, lokasi, link, deskripsi, biaya, peserta, status, kategori) 
                    VALUES ('$name', '$logo', '$tanggal_event', '$tanggal_event_akhir', '$tanggal_pendaftaran_awal', '$tanggal_pendaftaran_akhir', '$jam_event', '$lokasi', '$link', '$deskripsi', '$biaya', '$peserta', '$status', '$kategori')";

            if ($conn->query($sql_insert) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Event berhasil ditambahkan']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
            }
        }
        break;

    case 'DELETE':
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
                echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
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