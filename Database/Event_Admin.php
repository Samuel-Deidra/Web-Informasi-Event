<?php
include '../Database/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Query dengan nama table dan kolom yang benar
$query = "SELECT * FROM event WHERE is_deleted = 0 ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

echo "<!-- Total rows: " . $result->num_rows . " -->";
?>

<section class="event-container" id="eventSection" enctype="multipart/form-data">
    <div class="event-list">
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
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Gunakan nama kolom yang EXACT dari database
                        $eventId = htmlspecialchars($row['ID']);
                        $date = htmlspecialchars($row['Date']);
                        $logo = htmlspecialchars($row['Logo']);
                        $eventName = htmlspecialchars($row['Event']);
                        $fee = htmlspecialchars($row['Fee']);
                        $status = htmlspecialchars($row['Status']);
                        $type = htmlspecialchars($row['Type']);
                        $startEvent = htmlspecialchars($row['Start_event']);
                        $location = htmlspecialchars($row['Location']);
                        $link = htmlspecialchars($row['Link']);
                        $description = htmlspecialchars($row['Description']);
                        
                        // Logo path
                        $logoPath = '../uploads/' . $logo;
                        if (!file_exists($logoPath) || empty($logo)) {
                            $logoPath = 'logopoltektransparan.png';
                        }
                ?>
                
                <!-- Event Row -->
                <tr class="data-row" data-event-id="<?php echo $eventId; ?>">
                    <td><?php echo $eventId; ?></td>
                    <td><?php echo $date; ?></td>
                    <td><img src="<?php echo $logoPath; ?>" alt="<?php echo $eventName; ?>"></td>
                    <td><?php echo $eventName; ?></td>
                    <td><?php echo $fee; ?></td>
                    <td><?php echo $status; ?></td>
                    <td><?php echo $type; ?></td>
                    <td>
                        <button class="edit" 
                                data-id="<?php echo $eventId; ?>"
                                data-date="<?php echo $date; ?>"
                                data-logo="<?php echo $logo; ?>"
                                data-event="<?php echo $eventName; ?>"
                                data-fee="<?php echo $fee; ?>"
                                data-status="<?php echo $status; ?>"
                                data-type="<?php echo $type; ?>"
                                data-start="<?php echo $startEvent; ?>"
                                data-location="<?php echo $location; ?>"
                                data-link="<?php echo $link; ?>"
                                data-description="<?php echo $description; ?>">
                            Edit
                        </button>
                        <button class="delete" data-id="<?php echo $eventId; ?>">Delete</button>
                    </td>
                </tr>
                
                <!-- Description Row -->
                <tr class="desc-row">
                    <td colspan="8">
                        <div class="desc-box">
                            <?php if (!empty($startEvent)): ?>
                            <p><strong>Start Event:</strong> <?php echo $startEvent; ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($location)): ?>
                            <p><strong>Location:</strong> <?php echo $location; ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($link)): ?>
                            <p><strong>Link:</strong> <a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($description)): ?>
                            <p><strong>Description:</strong> <?php echo $description; ?></p>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                
                <?php
                    }
                } else {
                    echo '<tr><td colspan="8" style="text-align: center; padding: 20px;">No events found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<?php
$conn->close();
?>
