<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - BPJS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Bagian kiri full hijau */
        .register-left {
            background-color: #d2f2fd;
            /* Warna hijau BPJS */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .register-left img {
            max-width: 200px;
            height: auto;
        }

        /* Bagian kanan form register */
        .register-right {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .register-card {
            padding: 2rem;
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Responsif: Hilangkan bagian kiri di layar kecil */
        @media (max-width: 767.98px) {
            .register-left {
                display: none;
            }

            .register-right {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row no-gutters">
            <!-- Bagian kiri dengan warna hijau & logo -->
            <div class="col-md-8 register-left">
                <a href="<?php echo site_url('home/index'); ?>">
                    <img src="<?php echo base_url('assets/images/bpjsn.png'); ?>" alt="Logo BPJS">
                </a>
            </div>
            <!-- Bagian kanan dengan form register -->
            <div class="col-md-4 register-right">
                <div class="card register-card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Register</h3>
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php elseif ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Form Register -->
                        <form action="<?php echo site_url('auth/process_register'); ?>" method="post">
                            <div class="form-group">
                                <label for="name">Nama Lengkap:</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <div id="passwordError" style="color: red;"></div>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required oninput="validatePasswordInput()">
                            </div>
                            
                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password:</label>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Ulangi password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                        <hr>
                        <p class="text-center">Sudah punya akun? <a href="<?php echo site_url('auth/login'); ?>">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
function validatePasswordInput() {
    const password = document.getElementById("password").value;
    const errorDiv = document.getElementById("passwordError");
    const huruf = /[a-zA-Z]/;
    const angka = /[0-9]/;

    if (!huruf.test(password) || !angka.test(password)) {
        errorDiv.textContent = "Password harus mengandung huruf dan angka!";
    } else {
        errorDiv.textContent = "";
    }
}
</script>
<script>
function validatePasswordForm() {
    const password = document.getElementById("password").value;
    const errorDiv = document.getElementById("passwordError");
    const huruf = /[a-zA-Z]/;
    const angka = /[0-9]/;

    if (!huruf.test(password) || !angka.test(password)) {
        errorDiv.textContent = "Password harus mengandung huruf dan angka!";
        return false; // menghentikan form submit
    }
    return true; // lanjut submit
}
</script>



    <!-- Bootstrap JS dan dependensi -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>