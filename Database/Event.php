<section id="Home" class="filter-bar">
            <form action="" method="GET">

                <select name="year">
                    <option value="">Year</option>
                    <?php
                    for ($y = 2020; $y <= 2030; $y++) {
                        $selected = (isset($_GET['year']) && $_GET['year'] == $y) ? 'selected' : '';
                        echo "<option value='$y' $selected>$y</option>";
                    }
                    ?>
                </select>

                <select name="status">
                    <option value="">Status</option>
                    <option value="Open Registration" <?= (isset($_GET['status']) && $_GET['status'] == "Open Registration") ? "selected" : "" ?>>Open Registration</option>
                    <option value="Close" <?= (isset($_GET['status']) && $_GET['status'] == "Close") ? "selected" : "" ?>>
                        Close</option>
                    <option value="Upcoming" <?= (isset($_GET['status']) && $_GET['status'] == "Upcoming") ? "selected" : "" ?>>Upcoming</option>
                </select>

                <select name="type">
                    <option value="">Type</option>
                    <option value="Festival" <?= (isset($_GET['type']) && $_GET['type'] == "Festival") ? "selected" : "" ?>>Festival</option>
                    <option value="Seminar" <?= (isset($_GET['type']) && $_GET['type'] == "Seminar") ? "selected" : "" ?>>
                        Seminar</option>
                    <option value="Workshop" <?= (isset($_GET['type']) && $_GET['type'] == "Workshop") ? "selected" : "" ?>>Workshop</option>
                    <option value="Competition" <?= (isset($_GET['type']) && $_GET['type'] == "Competition") ? "selected" : "" ?>>Competition</option>
                </select>

                <input type="text" name="search" placeholder="Search Event by Name" value="<?php if (isset($_GET['search'])) {
                    echo $_GET['search'];
                } ?>">
                <button type="submit" class="btn-primary">Search</button>
            </form>
        </section>

        <section id="event" class="event-container">
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

                        if (!empty($_GET['year'])) {
                            $year = $_GET['year'];
                            $where[] = "YEAR(Date) = '$year'";
                        }

                        if (!empty($_GET['status'])) {
                            $status = $_GET['status'];
                            $where[] = "Status = '$status'";
                        }

                        if (!empty($_GET['type'])) {
                            $type = $_GET['type'];
                            $where[] = "Type = '$type'";
                        }

                        if (!empty($_GET['search'])) {
                            $search = $_GET['search'];
                            $where[] = "Event LIKE '%$search%'";
                        }

                        $sql = "SELECT * FROM event";
                        if (count($where) > 0) {
                            $sql .= " WHERE " . implode(" AND ", $where);
                        }

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
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
