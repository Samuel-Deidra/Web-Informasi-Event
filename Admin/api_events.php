<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../Database/koneksi.php';

 $method = $_SERVER['REQUEST_METHOD'];
 $input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Get single event
            $id = $_GET['id'];
            $sql = "SELECT * FROM events WHERE id = $id";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $event = $result->fetch_assoc();
                echo json_encode(['success' => true, 'data' => $event]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Event tidak ditemukan']);
            }
        } else {
            // Get all events
            $sql = "SELECT * FROM events ORDER BY tanggal_event DESC";
            $result = $conn->query($sql);
            
            $events = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $events[] = $row;
                }
            }
            
            echo json_encode(['success' => true, 'data' => $events]);
        }
        break;
        
    case 'POST':
        // Create new event
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
        $status = $_POST['status'];
        $kategori = $_POST['kategori'];
        
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
        // Delete or move to history
        $id = $_GET['id'];
        
        // Check if event is in history or not
        $sql = "SELECT status FROM events WHERE id = $id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_status = $row['status'];
            
            if ($current_status === 'Selesai') {
                // Permanently delete from history
                $sql = "DELETE FROM events WHERE id = $id";
                $message = "Event berhasil dihapus permanen";
            } else {
                // Move to history by changing status to 'Selesai'
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