<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - BPJS</title>
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

		.login-container {
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		/* Bagian kiri full hijau */
		.login-left {
			background-color: #d2f2fd;
			/* Warna hijau BPJS */
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}

		.login-left img {
			max-width: 200px;
			height: auto;
		}

		/* Bagian kanan form login */
		.login-right {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}

		.login-card {
			padding: 2rem;
			border: none;
			border-radius: 0.5rem;
			box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
			width: 100%;
			max-width: 400px;
		}

		/* Responsif: Hilangkan bagian kiri di layar kecil */
		@media (max-width: 767.98px) {
			.login-left {
				display: none;
			}

			.login-right {
				width: 100%;
			}
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="row no-gutters">
			<!-- Bagian kiri dengan warna hijau & logo -->
			<!-- Bagian kiri dengan warna hijau & logo -->
			<div class="col-md-8 login-left">
				<a href="<?php echo site_url('home/index'); ?>">
					<img src="<?php echo base_url('assets/images/bpjsn.png'); ?>" alt="Logo BPJS">
				</a>
			</div>

			<!-- Bagian kanan dengan form login -->
			<div class="col-md-4 login-right">
				<div class="card login-card">
					<div class="card-body">
						<h3 class="card-title text-center mb-4">Login</h3>
						<?php if ($this->session->flashdata('error')): ?>
							<div class="alert alert-danger">
								<?php echo $this->session->flashdata('error'); ?>
							</div>
						<?php endif; ?>

						<?php if ($this->session->flashdata('success')): ?>
							<div class="alert alert-success">
								<?php echo $this->session->flashdata('success'); ?>
							</div>
						<?php endif; ?>


						<!-- Form Login -->
						<form action="<?php echo site_url('auth/process_login'); ?>" method="post">
							<div class="form-group">
								<label for="email">Email:</label>
								<input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email" required>
							</div>
							<div class="form-group">
								<label for="password">Password:</label>
								<input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
							</div>
							<button type="submit" class="btn btn-primary btn-block">Login</button>
						</form>
						<hr>
						<p class="text-center">Belum punya akun? <a href="<?php echo site_url('auth/register'); ?>">Register</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS dan dependensi -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>