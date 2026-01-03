<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #2C71D6;
            --submit-color: #21539e;
            --white-transparent: rgba(255, 255, 255, 0.85);
            --text-dark: #1a1a1a;
        }

        body {
            background: url('../Foto/Ucapan\ Selamat\ Datang\ di\ Kelas\ Pendidikan\ Kewarganegaraan\ PPKN\ Dekorasi\ Hia_20251010_130904_0000.png') no-repeat center center/cover;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            animation: fadeIn 1s ease-in-out;
        }

        .login_container {
            position: relative;
            width: 400px;
            padding: 40px 30px;
            border-radius: 15px;
            background: var(--white-transparent);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            text-align: center;
            color: var(--text-dark);
            animation: popIn 0.6s ease-out;
        }

        .back-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            background: transparent;
            border: none;
            color: var(--primary-color);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.3s;
        }

        .back-btn:hover {
            color: var(--submit-color);
        }

        .login_title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 30px;
            margin-top: 15px;
        }

        .input_wrapper {
            position: relative;
            margin-bottom: 20px;
            border-radius: 30px;
            border: 1px solid #ccc;
            background: white;
            transition: all 0.3s ease;
        }

        .input_wrapper:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(44, 113, 214, 0.4);
        }

        .input_wrapper input {
            width: 100%;
            padding: 12px 45px 12px 40px;
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            color: var(--text-dark);
            position: relative;
            z-index: 2;

            /* PERBAIKAN: Terapkan border-radius pada input itu sendiri */
            border-radius: 30px;
        }

        .input_wrapper input::placeholder {
            color: #999;
        }

        /* PERBAIKAN: Atur ulang gaya saat browser mengisi otomatis (autofill) */
        .input_wrapper input:-webkit-autofill,
        .input_wrapper input:-webkit-autofill:hover,
        .input_wrapper input:-webkit-autofill:focus {
            /* Gunakan inset shadow untuk "mengecat" latar belakang dengan warna putih */
            -webkit-box-shadow: 0 0 0 1000px white inset;
            /* Pastikan warna teks tetap terlihat */
            -webkit-text-fill-color: var(--text-dark);
            /* Kembalikan border dan radiusnya seperti semula */
            border: 1px solid #ccc;
            border-radius: 30px;
            /* Berikan transisi yang sangat panjang untuk "menahan" perubahan warna background dari browser */
            transition: background-color 5000s ease-in-out 0s;
        }

        .input_wrapper i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            z-index: 3;
        }

        .input_wrapper i:not(.toggle-pass) {
            left: 15px;
        }

        .toggle-pass {
            right: 15px;
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            height: 45px;
            border-radius: 30px;
            border: none;
            background: var(--primary-color);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: var(--submit-color);
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .success-toast,
        .error-toast {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 10px;
            min-width: 250px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media only screen and (max-width: 480px) {
            .login_container {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login_container">

        <button class="back-btn" onclick="window.location.href='../Mahasiswa/Mahasiswa.php'">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </button>

        <h2 class="login_title">Admin Login</h2>

        <form id="loginForm" action="../Database/cek_login.php" method="POST">

            <div class="input_wrapper">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>

            <div class="input_wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required autocomplete="off">
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
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePass.classList.remove('fa-eye-slash');
                togglePass.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                togglePass.classList.remove('fa-eye');
                togglePass.classList.add('fa-eye-slash');
            }
        });
    </script>

</body>

</html>