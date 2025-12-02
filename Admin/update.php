<?php
// update.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../Database/koneksi.php';

// Check if it's an update request
if (isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
    $id = $_GET['id'];

    $name = $_POST['name'];
    $tanggal_event = $_POST['tanggal_event'];
    $tanggal_event_akhir = $_POST['tanggal_event_akhir'] ?? '';
    $tanggal_pendaftaran_awal = $_POST['tanggal_pendaftaran_awal'];
    $tanggal_pendaftaran_akhir = $_POST['tanggal_pendaftaran_akhir'];
    $jam_event = $_POST['jam_event'];
    $lokasi = $_POST['lokasi'];
    $link = $_POST['link'];
    $deskripsi = $_POST['deskripsi'];
    $biaya = $_POST['biaya'];
    $peserta = $_POST['peserta'];
    $kategori = $_POST['kategori'];
    // Status tidak diperbarui, akan digenerate otomatis di frontend

    // Escape input untuk keamanan
    $id = $conn->real_escape_string($id);
    $name = $conn->real_escape_string($name);
    $tanggal_event = $conn->real_escape_string($tanggal_event);
    $tanggal_event_akhir = $conn->real_escape_string($tanggal_event_akhir);
    $tanggal_pendaftaran_awal = $conn->real_escape_string($tanggal_pendaftaran_awal);
    $tanggal_pendaftaran_akhir = $conn->real_escape_string($tanggal_pendaftaran_akhir);
    $jam_event = $conn->real_escape_string($jam_event);
    $lokasi = $conn->real_escape_string($lokasi);
    $link = $conn->real_escape_string($link);
    $deskripsi = $conn->real_escape_string($deskripsi);
    $peserta = $conn->real_escape_string($peserta);
    $kategori = $conn->real_escape_string($kategori);

    // Get current event data to preserve logo if not changed
    $sql = "SELECT logo FROM events WHERE id = $id";
    $result = $conn->query($sql);
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
            // Delete old logo if exists
            if ($logo && file_exists($logo)) {
                unlink($logo);
            }
            $logo = $target_file;
        }
    }

    $sql = "UPDATE events SET 
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
            kategori = '$kategori' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Event berhasil diperbarui']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode tidak diizinkan']);
}

$conn->close();
?>