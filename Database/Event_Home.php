<section class="event-container">
    <div class="event-list">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Event</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>

                <!-- Jangan diganti lagi -->
                <?php
                include '../Database/koneksi.php';

                $where = [];

                $sql = "SELECT * FROM event";
                if (count($where) > 0) {
                    $sql .= " WHERE " . implode(" AND ", $where);
                }

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $Date = $row["ID"];
                        $Date = $row["Date"];
                        $Event = $row["Event"];
                        $Fee = $row["Fee"];
                        $Status = $row["Status"];
                        $Type = $row["Type"];
                        $Description = $row["Description"];

                        echo "
          <tr class='data-row' data-desc='$Description'>
            <td>$Date</td>
            <td>$Event</td>
            <td>$Fee</td>
            <td>$Status</td>
            <td>$Type</td>
          </tr>
          <tr class='desc-row'>
            <td colspan='6'>
              <div class='desc-box'>$Description</div>
            </td>
          </tr>";

                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>Event Tidak Ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
</section>