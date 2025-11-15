<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page Admin</title>
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Hegarty&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="btn-back">
        <a href="HomeN.html"><input type="submit" class="back-btn" value="Back"></a>
    </div>
    <div class="container">
        <div class="login_container">
            <div class="login_title">
                <span>Admin Login</span>
            </div>
            <div class="input_wrapper">
                <input type="text" id="user" class="input_field" required>
                <label for="user" class="label"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>Username</label>   
            </div>
            <div class="input_wrapper">
                <input type="Password" id="pass" class="input_field" required>
                <label for="pass" class="label"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="15" viewBox="0 0 640 640"><<path d="M256 160L256 224L384 224L384 160C384 124.7 355.3 96 320 96C284.7 96 256 124.7 256 160zM192 224L192 160C192 89.3 249.3 32 320 32C390.7 32 448 89.3 448 160L448 224C483.3 224 512 252.7 512 288L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 288C128 252.7 156.7 224 192 224z"/></svg>Password</label>
                <i class="fa-solid fa-eye-slash toggle-pass" id="togglePass"></i>

            </div>
            <div class="remember_me">
                <input type="checkbox" id="remember">
                <label for="remember">Remember Me</label>
            </div>
            <div class="submit">
                <a href="DashboardAdmin.php"><input type="submit" class="submit-btn" value="Login" required></a>
            </div>
        </div>
    </div>

    <script>
    const togglePass = document.getElementById('togglePass');
    const passwordField = document.getElementById('pass');

    togglePass.addEventListener('click', () => {
        const isPasswordVisible = passwordField.type === 'text';

        // kalau sedang terlihat (text), ubah jadi password
        if (isPasswordVisible) {
            passwordField.type = 'password';
            togglePass.classList.remove('fa-eye');
            togglePass.classList.add('fa-eye-slash');
        } else {
            // kalau disembunyikan, tampilkan password
            passwordField.type = 'text';
            togglePass.classList.remove('fa-eye-slash');
            togglePass.classList.add('fa-eye');
        }
    });
</script>

</body>
</html>