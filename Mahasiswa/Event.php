<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Event.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="">Event</a></li>
                <li><a href="calender.php">Calendar</a></li>
            </ul>
            <div class="icon-user">
                <a href="Login_page.php"><i class="fa-solid fa-user"></i></a>
            </div>
        </div>
    </nav>

    <section>
        <!-- Filter Bar -->
        <?php include '../Database/Event.php'; ?>

            <footer class="footer">
            <div class="footer-content">
                <img src="logopoltektransparan.png" alt="logo" class="footer-logo">
                <div class="footer-info">
                    <h2>Contact Us</h2>
                        <p>Politeknik Negeri Batam</p>
                        <p>Jl. Ahmad Yani Batam Kota, Kota Batam, Kepulauan Riau, Indonesia.</p>
                        <p>Whats App 0821-7255-7099</p>
                        <p>Fax : +62-778-463620</p>
                        <p>Email : info@polibatam.ac.id atau humas@polibatam.ac.id</p>
                    </div>
                </div>
            </footer>
                    
</body>
<!-- jangan diganti lagi -->
<script>
    const rows = document.querySelectorAll('.data-row');

    rows.forEach((row, index) => {
        row.addEventListener('click', () => {
            const descRow = row.nextElementSibling;
            const descBox = descRow.querySelector('.desc-box');

            document.querySelectorAll('.desc-box').forEach(box => {
                if (box !== descBox) box.classList.remove('active');
            });

            descBox.classList.toggle('active');
        });
    });
</script>
</html>