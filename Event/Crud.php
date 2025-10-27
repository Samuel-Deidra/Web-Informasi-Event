<?php
session_start();
include '../Database/koneksi.php';

// Aktifkan error reporting (matikan di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ==============================
// FUNGSI PENDUKUNG
// ==============================
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function handleFileUpload($file) {
    $targetDir = "../uploads/"; // folder upload
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['status' => true, 'filename' => null]; // tidak upload logo
    }

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $fileName = basename($file["name"]);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedTypes)) {
        return ['status' => false, 'message' => "File type not allowed. Only JPG, PNG, GIF"];
    }

    $newFileName = time() . "_" . uniqid() . "." . $fileExt;
    $targetFile = $targetDir . $newFileName;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return ['status' => true, 'filename' => $newFileName];
    } else {
        return ['status' => false, 'message' => "Failed to upload file"];
    }
}

function deleteFile($filename) {
    $filePath = "../uploads/" . $filename;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// ==============================
// READ DATA EVENT
// ==============================
$query = "SELECT * FROM event WHERE is_deleted = 0 ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// ==============================
// CREATE - TAMBAH EVENT BARU
// ==============================
if (isset($_POST['add-event'])) {
    try {
        $Date        = sanitizeInput($_POST['Date']);
        $Event       = sanitizeInput($_POST['Event']);
        $Fee         = sanitizeInput($_POST['Fee']);
        $Status      = sanitizeInput($_POST['Status']);
        $Type        = sanitizeInput($_POST['Type']);
        $StartEvent  = sanitizeInput($_POST['Start']);
        $Location    = sanitizeInput($_POST['Location']);
        $Link        = sanitizeInput($_POST['Link']);
        $Description = sanitizeInput($_POST['Description']);

        if (empty($Date) || empty($Event) || empty($Fee) || empty($Status) || empty($Type)) {
            throw new Exception("All required fields must be filled");
        }

        $uploadResult = handleFileUpload($_FILES['Logo']);
        if (!$uploadResult['status']) {
            throw new Exception($uploadResult['message']);
        }
        $logoFilename = $uploadResult['filename'];

        $stmt = $conn->prepare("
            INSERT INTO event (`Date`, `Logo`, `Event`, `Fee`, `Status`, `Type`, `Start Event`, `Location`, `Link`, `Description`, `is_deleted`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)
        ");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssssss", 
            $Date, $logoFilename, $Event, $Fee, $Status, $Type, $StartEvent, $Location, $Link, $Description
        );

        if ($stmt->execute()) {
            $_SESSION['success'] = "Event added successfully!";
            header("Location: DashboardAdmin.php");
            exit();
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: DashboardAdmin.php");
        exit();
    }
}

// ==============================
// UPDATE - EDIT EVENT
// ==============================
if (isset($_POST['updateevent'])) {
    try {
        $ID     = intval($_POST['ID']);
        $Date        = sanitizeInput($_POST['Date']);
        $Event       = sanitizeInput($_POST['Event']);
        $Fee         = sanitizeInput($_POST['Fee']);
        $Status      = sanitizeInput($_POST['Status']);
        $Type        = sanitizeInput($_POST['Type']);
        $StartEvent  = sanitizeInput($_POST['Start']);
        $Location    = sanitizeInput($_POST['Location']);
        $Link        = sanitizeInput($_POST['Link']);
        $Description = sanitizeInput($_POST['Description']);

        if (empty($Date) || empty($Event) || empty($Fee) || empty($Status) || empty($Type)) {
            throw new Exception("All required fields must be filled");
        }

        // Jika ada logo baru di-upload
        if (isset($_FILES['Logo']) && $_FILES['Logo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $stmt = $conn->prepare("SELECT `Logo` FROM event WHERE ID = ?");
            $stmt->bind_param("i", $eventId);
            $stmt->execute();
            $result = $stmt->get_result();
            $oldEvent = $result->fetch_assoc();
            $stmt->close();

            $uploadResult = handleFileUpload($_FILES['Logo']);
            if (!$uploadResult['status']) {
                throw new Exception($uploadResult['message']);
            }
            $logoFilename = $uploadResult['filename'];

            // hapus logo lama
            if ($oldEvent && !empty($oldEvent['Logo'])) {
                deleteFile($oldEvent['Logo']);
            }

            $stmt = $conn->prepare("
                UPDATE event 
                SET `Date`=?, `Logo`=?, `Event`=?, `Fee`=?, `Status`=?, `Type`=?, `Start Event`=?, `Location`=?, `Link`=?, `Description`=? 
                WHERE ID=?
            ");
            $stmt->bind_param("ssssssssssi", 
                $Date, $logoFilename, $Event, $Fee, $Status, $Type, $StartEvent, $Location, $Link, $Description, $eventId
            );
        } else {
            // Tidak ubah logo
            $stmt = $conn->prepare("
                UPDATE event 
                SET `Date`=?, `Event`=?, `Fee`=?, `Status`=?, `Type`=?, `Start Event`=?, `Location`=?, `Link`=?, `Description`=? 
                WHERE ID=?
            ");
            $stmt->bind_param("sssssssssi", 
                $Date, $Event, $Fee, $Status, $Type, $StartEvent, $Location, $Link, $Description, $eventId
            );
        }

        if ($stmt->execute()) {
            $_SESSION['success'] = "Event updated successfully!";
            header("Location: DashboardAdmin.php");
            exit();
        } else {
            throw new Exception("Update failed: " . $stmt->error);
        }

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: DashboardAdmin.php");
        exit();
    }
}

// ==============================
// DELETE - HAPUS EVENT
// ==============================
if (isset($_GET['delete'])) {
    try {
        $eventId = intval($_GET['delete']);

        $stmt = $conn->prepare("SELECT `Logo` FROM event WHERE ID = ?");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        $stmt->close();

        if ($event) {
            $stmt = $conn->prepare("UPDATE event SET is_deleted = 1 WHERE ID = ?");
            $stmt->bind_param("i", $eventId);
            if ($stmt->execute()) {
                if (!empty($event['Logo'])) {
                    deleteFile($event['Logo']);
                }
                $_SESSION['success'] = "Event deleted successfully!";
            } else {
                throw new Exception("Delete failed: " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Event not found");
        }

        header("Location: DashboardAdmin.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: DashboardAdmin.php");
        exit();
    }
}

// ==============================
// GET SINGLE EVENT (AJAX EDIT)
// ==============================
if (isset($_GET['edit'])) {
    try {
        $eventId = intval($_GET['edit']);
        $stmt = $conn->prepare("SELECT * FROM event WHERE ID = ? AND is_deleted = 0");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        $stmt->close();

        if ($event) {
            header('Content-Type: application/json');
            echo json_encode($event);
            exit();
        } else {
            throw new Exception("Event not found");
        }

    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
        exit();
    }
}

$conn->close();
?>
