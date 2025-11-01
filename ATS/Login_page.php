<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Hegarty&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="login_container">
        <button class="back-btn" onclick="window.history.back()">
            <i class="fa-solid fa-arrow-left"></i> Back
        </button>

        <h2 class="login_title">Admin Login</h2>

        <form id="loginForm">
            <div class="input_wrapper">
                <i class="fa-solid fa-user"></i>
                <input type="text" id="username" placeholder="Username" required>
            </div>

            <div class="input_wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" placeholder="Password" required>
                <i class="fa-solid fa-eye-slash toggle-pass" id="togglePass"></i>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fa-solid fa-right-to-bracket"></i> Login
            </button>
        </form>
    </div>

    <script>
    const togglePass = document.getElementById('togglePass');
    const passwordField = document.getElementById('password');

    togglePass.addEventListener('click', () => {
    const isPasswordVisible = passwordField.type === 'text';

    if (isPasswordVisible) {
        passwordField.type = 'password';
        togglePass.classList.remove('fa-eye');
        togglePass.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'text';
        togglePass.classList.remove('fa-eye-slash');
        togglePass.classList.add('fa-eye');
    }
});


        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (username === "" || password === "") {
                alert(" Username dan password tidak boleh kosong!");
                return;
            }
            if (username === "Admin" && password === "Admin123") {
                alert(" Login berhasil! Selamat datang, " + username + "!");
                window.location.href = "DashboardAdmin.php";
            } else {
                alert(" Username atau password salah!");
            }
        });
    </script>
</body>
</html>
