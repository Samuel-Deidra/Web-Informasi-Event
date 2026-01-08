<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Mulai output buffering untuk menangkap error
ob_start();

// Load database connection 
$dbConnPath = __DIR__ . '/../Database/koneksi.php';
if (!file_exists($dbConnPath)) {
    ob_clean();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection file not found at: ' . $dbConnPath]);
    exit();
}
require_once $dbConnPath;

// Cek koneksi database
if ($conn->connect_error) {
    ob_clean();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

// Error handler 
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    ob_clean();
    http_response_code(500);
    $errorMsg = 'Error: ' . $errstr . ' (File: ' . basename($errfile) . ', Line: ' . $errline . ')';
    echo json_encode(['success' => false, 'message' => $errorMsg]);
    exit();
});

/**
 *
 * @param array $event Array data event.
 * @return string Status event.
 */
function getEventStatus($event)
{
    $regStartKey = isset($event['tanggal_pendaftaran_awal']) ? 'tanggal_pendaftaran_awal' : 'registrationDate';
    $regEndKey = isset($event['tanggal_pendaftaran_akhir']) ? 'tanggal_pendaftaran_akhir' : 'registrationEndDate';
    $eventStartKey = isset($event['tanggal_event']) ? 'tanggal_event' : 'date';
    $eventEndKey = isset($event['tanggal_event_akhir']) ? 'tanggal_event_akhir' : 'endDate';

    // Cegah error jika data tanggal tidak lengkap
    if (empty($event[$regStartKey]) || empty($event[$regEndKey]) || empty($event[$eventStartKey])) {
        return "Data Tanggal Tidak Lengkap";
    }

    try {
        $now = new DateTime();
        $now->setTime(0, 0, 0);

        $regStart = new DateTime($event[$regStartKey]);
        $regEnd = new DateTime($event[$regEndKey]);
        $eventStart = new DateTime($event[$eventStartKey]);
        $eventEnd = !empty($event[$eventEndKey]) ? new DateTime($event[$eventEndKey]) : clone $eventStart;

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
    } catch (Exception $e) {
        return "Status Tidak Dapat Ditentukan";
    }
}

switch ($method) {
    case 'GET':
        // Handler untuk test koneksi
        if (isset($_GET['test']) && $_GET['test'] === 'connection') {
            ob_clean();
            echo json_encode([
                'success' => true,
                'message' => 'Database connection successful',
                'database' => 'db_event',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            exit();
        }

        if (isset($_GET['id'])) {
            $id = $conn->real_escape_string($_GET['id']);
            $sql = "SELECT * FROM events WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $event = $result->fetch_assoc();
                // Jangan timpa status 'Selesai' yang sengaja diset untuk history
                if (!isset($event['status']) || $event['status'] !== 'Selesai') {
                    $event['status'] = getEventStatus($event);
                }
                echo json_encode(['success' => true, 'data' => $event]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Event tidak ditemukan']);
            }
        } else {
            $requestFor = isset($_GET['for']) ? $_GET['for'] : 'admin';

            if ($requestFor === 'mahasiswa') {
                // Query khusus untuk Mahasiswa - hanya gunakan field yang ada
                $sql = "SELECT 
                            id, 
                            name, 
                            logo, 
                            tanggal_event, 
                            tanggal_event_akhir, 
                            tanggal_pendaftaran_awal, 
                            tanggal_pendaftaran_akhir, 
                            lokasi, 
                            status, 
                            peserta, 
                            kategori, 
                            jam_event, 
                            biaya, 
                            deskripsi, 
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
                    // Hitung status menggunakan fungsi yang fleksibel, tapi jangan timpa
                    // status 'Selesai' yang menandakan event dipindahkan ke history.
                    if (!isset($row['status']) || $row['status'] !== 'Selesai') {
                        $row['status'] = getEventStatus($row);
                    }

                    if ($requestFor === 'mahasiswa') {
                        // Format gambar path untuk mahasiswa
                        if (!empty($row['logo'])) {
                            // Jika logo sudah ada path uploads, jangan tambahkan lagi
                            if (strpos($row['logo'], 'uploads/') === 0) {
                                $row['image'] = $row['logo'];
                            } else {
                                $row['image'] = 'uploads/' . $row['logo'];
                            }
                        } else {
                            $row['image'] = '';
                        }
                        // Format harga dengan currency
                        if (!empty($row['biaya']) && $row['biaya'] > 0) {
                            $row['price'] = 'Rp ' . number_format($row['biaya'], 0, ',', '.');
                        } else {
                            $row['price'] = 'Gratis';
                        }
                        // Pastikan tanggal_event_akhir ikut dikirim ke frontend mahasiswa
                        $row['tanggal_event_akhir'] = isset($row['tanggal_event_akhir']) ? $row['tanggal_event_akhir'] : $row['tanggal_event'];
                    }
                    $events[] = $row;
                }
            }
            echo json_encode(['success' => true, 'data' => $events]);
        }
        break;

    case 'POST':
        if (isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
            // --- LOGIKA UPDATE EVENT ---
            $id = $_GET['id'];
            // Escape input untuk keamanan
            $name = $conn->real_escape_string($_POST['name']);
            $tanggal_event = $conn->real_escape_string($_POST['tanggal_event']);
            $tanggal_event_akhir = isset($_POST['tanggal_event_akhir']) ? $conn->real_escape_string($_POST['tanggal_event_akhir']) : '';
            $tanggal_pendaftaran_awal = $conn->real_escape_string($_POST['tanggal_pendaftaran_awal']);
            $tanggal_pendaftaran_akhir = $conn->real_escape_string($_POST['tanggal_pendaftaran_akhir']);
            $jam_event = $conn->real_escape_string($_POST['jam_event']);
            $lokasi = $conn->real_escape_string($_POST['lokasi']);
            $link = isset($_POST['link']) ? $conn->real_escape_string($_POST['link']) : '';
            $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
            $biaya = $conn->real_escape_string($_POST['biaya']);
            $peserta = $conn->real_escape_string($_POST['peserta']);
            $kategori = $conn->real_escape_string($_POST['kategori']);

            // Get current event data to preserve logo if not changed
            $sql_select = "SELECT logo FROM events WHERE id = $id";
            $result = $conn->query($sql_select);
            if (!$result || $result->num_rows === 0) {
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Event tidak ditemukan']);
                exit();
            }
            $current_event = $result->fetch_assoc();
            $logo = $current_event['logo'];

            // Handle logo upload if new file is provided dengan error handling
            if (isset($_FILES['logo'])) {
                $upload_error = $_FILES['logo']['error'];

                // Jika ada file upload
                if ($upload_error === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/';
                    if (!is_dir($upload_dir)) {
                        if (!mkdir($upload_dir, 0777, true)) {
                            ob_clean();
                            echo json_encode(['success' => false, 'message' => 'Gagal membuat direktori uploads']);
                            exit();
                        }
                    }

                    $file_name = time() . '_' . basename($_FILES['logo']['name']);
                    $target_file = $upload_dir . $file_name;

                    if (!move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
                        ob_clean();
                        echo json_encode(['success' => false, 'message' => 'Gagal memindahkan file logo ke server']);
                        exit();
                    }

                    // Delete old logo jika ada
                    if ($logo && file_exists($logo)) {
                        unlink($logo);
                    }
                    $logo = $target_file;
                } else if ($upload_error !== UPLOAD_ERR_NO_FILE) {
                    // Ada error upload (bukan "no file" karena itu opsional untuk update)
                    ob_clean();
                    $errorMessages = [
                        UPLOAD_ERR_INI_SIZE => 'File terlalu besar (exceeded INI size)',
                        UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (exceeded form size)',
                        UPLOAD_ERR_PARTIAL => 'File hanya ter-upload sebagian',
                        UPLOAD_ERR_NO_TMP_DIR => 'Temporary directory tidak tersedia',
                        UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                        UPLOAD_ERR_EXTENSION => 'Upload file dihentikan oleh extension'
                    ];
                    $errorMsg = $errorMessages[$upload_error] ?? 'Upload error tidak diketahui';
                    echo json_encode(['success' => false, 'message' => 'Error upload: ' . $errorMsg]);
                    exit();
                }
            }

            $eventDataForStatus = ['tanggal_pendaftaran_awal' => $tanggal_pendaftaran_awal, 'tanggal_pendaftaran_akhir' => $tanggal_pendaftaran_akhir, 'tanggal_event' => $tanggal_event];
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
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
            }
        } else {
            // --- CREATE EVENT ---
            $name = $conn->real_escape_string($_POST['name']);
            $tanggal_event = $conn->real_escape_string($_POST['tanggal_event']);
            $tanggal_event_akhir = isset($_POST['tanggal_event_akhir']) ? $conn->real_escape_string($_POST['tanggal_event_akhir']) : '';
            $tanggal_pendaftaran_awal = $conn->real_escape_string($_POST['tanggal_pendaftaran_awal']);
            $tanggal_pendaftaran_akhir = $conn->real_escape_string($_POST['tanggal_pendaftaran_akhir']);
            $jam_event = $conn->real_escape_string($_POST['jam_event']);
            $lokasi = $conn->real_escape_string($_POST['lokasi']);
            $link = isset($_POST['link']) ? $conn->real_escape_string($_POST['link']) : '';
            $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
            $biaya = $conn->real_escape_string($_POST['biaya']);
            $peserta = $conn->real_escape_string($_POST['peserta']);
            $kategori = $conn->real_escape_string($_POST['kategori']);

            $eventDataForStatus = ['tanggal_pendaftaran_awal' => $tanggal_pendaftaran_awal, 'tanggal_pendaftaran_akhir' => $tanggal_pendaftaran_akhir, 'tanggal_event' => $tanggal_event];
            $status = getEventStatus($eventDataForStatus);

            // Handle logo upload dengan error handling yang lebih baik
            $logo = '';
            if (isset($_FILES['logo'])) {
                $upload_error = $_FILES['logo']['error'];

                // Cek upload error
                if ($upload_error !== UPLOAD_ERR_OK) {
                    ob_clean();
                    $errorMessages = [
                        UPLOAD_ERR_INI_SIZE => 'File terlalu besar (exceeded INI size)',
                        UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (exceeded form size)',
                        UPLOAD_ERR_PARTIAL => 'File hanya ter-upload sebagian',
                        UPLOAD_ERR_NO_FILE => 'Tidak ada file yang ter-upload',
                        UPLOAD_ERR_NO_TMP_DIR => 'Temporary directory tidak tersedia',
                        UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                        UPLOAD_ERR_EXTENSION => 'Upload file dihentikan oleh extension'
                    ];
                    $errorMsg = $errorMessages[$upload_error] ?? 'Upload error tidak diketahui (error code: ' . $upload_error . ')';
                    echo json_encode(['success' => false, 'message' => 'Error upload: ' . $errorMsg]);
                    exit();
                }

                // Jika ada file
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    if (!mkdir($upload_dir, 0777, true)) {
                        ob_clean();
                        echo json_encode(['success' => false, 'message' => 'Gagal membuat direktori uploads']);
                        exit();
                    }
                }

                $file_name = time() . '_' . basename($_FILES['logo']['name']);
                $target_file = $upload_dir . $file_name;

                if (!move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
                    ob_clean();
                    echo json_encode(['success' => false, 'message' => 'Gagal memindahkan file logo ke server. Pastikan direktori uploads/ memiliki permission write']);
                    exit();
                }
                $logo = $target_file;
            }

            $sql_insert = "INSERT INTO events (name, logo, tanggal_event, tanggal_event_akhir, tanggal_pendaftaran_awal, tanggal_pendaftaran_akhir, jam_event, lokasi, link, deskripsi, biaya, peserta, status, kategori) 
                    VALUES ('$name', '$logo', '$tanggal_event', '$tanggal_event_akhir', '$tanggal_pendaftaran_awal', '$tanggal_pendaftaran_akhir', '$jam_event', '$lokasi', '$link', '$deskripsi', '$biaya', '$peserta', '$status', '$kategori')";

            if ($conn->query($sql_insert) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Event berhasil ditambahkan']);
            } else {
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $permanent = isset($_GET['permanent']) && ($_GET['permanent'] == '1' || $_GET['permanent'] === 'true');
        $sql = "SELECT status FROM events WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_status = $row['status'];
            if ($permanent) {
                // Only delete permanently when explicit permanent flag is provided
                $sql = "DELETE FROM events WHERE id = $id";
                $message = "Event berhasil dihapus permanen";
            } else {
                // Otherwise, always move to history by setting status to 'Selesai'
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

// Clean up output buffer and restore error handler
ob_end_flush();
restore_error_handler();

$conn->close();
?>