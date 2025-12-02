<?php
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM loginadmin WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="../css/Admin.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    </head>
    <body>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Toast Success
        function showSuccessToast(title, message) {
            const c = document.getElementById("toastContainer");
            const t = document.createElement("div");
            t.className = "success-toast";

            t.innerHTML =
                "<div class=\"toast-icon\"><i class=\"fa-solid fa-check\"></i></div>" +
                "<div class=\"toast-content\">" +
                    "<div class=\"toast-title\">" + title + "</div>" +
                    "<div class=\"toast-message\">" + message + "</div>" +
                "</div>";

            c.appendChild(t);

            setTimeout(function() {
                window.location = "../Admin/Admin.php";
            }, 1200);
        }

        showSuccessToast("Berhasil", "Login berhasil!");
    </script>

    </body>
    </html>
    ';

    exit();
}

// ================================
// LOGIN GAGAL
// ================================
else {

    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="../css/Admin.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    </head>
    <body>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Toast Error
        function showErrorToast(message) {
            const c = document.getElementById("toastContainer");
            const t = document.createElement("div");
            t.className = "success-toast";

            t.innerHTML =
                "<div class=\"toast-icon\" style=\"background:#fee2e2;\">" +
                    "<i class=\"fa-solid fa-exclamation-triangle\" style=\"color:#dc2626;\"></i>" +
                "</div>" +
                "<div class=\"toast-content\">" +
                    "<div class=\"toast-title\">Error</div>" +
                    "<div class=\"toast-message\">" + message + "</div>" +
                "</div>";

            c.appendChild(t);

            setTimeout(function() {
                window.location = "../Admin/Login_page.php";
            }, 1500);
        }

        showErrorToast("Username atau password salah!");
    </script>

    </body>
    </html>
    ';

    exit();
}
?>