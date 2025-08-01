<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo">
		<a href="<?= base_url('/dashboard') ?>" class="app-brand-link">
			<div class="app-brand-logo demo d-flex align-items-center">
				<img src="<?php echo base_url('assets/images/bpjs.png'); ?>" alt="Logo" width="50" class="me-2">
				<span class="fw-semibold">BPJS</span>
			</div>

		</a>

		<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
			<i class="fas fa-chevron-left"></i>
		</a>
	</div>
	<div class="menu-inner-shadow"></div>
	<ul class="menu-inner py-1">
		<!-- Dashboard -->
		<li class="menu-item">
			<a href="<?= site_url('dashboard') ?>" class="menu-link">
				<i class="menu-icon fas fa-home"></i>
				<span>Dashboard</span>
			</a>
		</li>

		<!-- Data Kepesertaan -->
		<li class="menu-item">
			<a href="<?= site_url('kepesertaan') ?>" class="menu-link">
				<i class="menu-icon fas fa-user"></i>
				<span>Data Kepesertaan</span>
			</a>
		</li>

		<?php if ($this->session->userdata('role') !== 'pengguna') : ?>
			<!-- Menu Faskes -->
			<li class="menu-item">
				<a href="<?= site_url('faskes') ?>" class="menu-link">
					<i class="menu-icon fas fa-hospital"></i>
					<span>Data Faskes</span>
				</a>
			</li>

			<!-- Data Kelas -->
			<li class="menu-item">
				<a href="<?= site_url('kelas') ?>" class="menu-link">
					<i class="menu-icon fas fa-school"></i>
					<span>Data Kelas</span>
				</a>
			</li>
			<li class="menu-item">
				<a href="<?= site_url('tunggakan'); ?>" class="menu-link">
					<i class="menu-icon fas fa-dollar"></i>
					<span>Data Tunggakan</span>
				</a>
			</li>
		<?php endif; ?>
		<!-- Data Pembayaran -->
		<li class="menu-item">
			<a href="<?= site_url('pembayaran'); ?>" class="menu-link">
				<i class="menu-icon fas fa-dollar"></i>
				<span>Pembayaran</span>
			</a>
		</li>


		<?php if ($this->session->userdata('role') !== 'pengguna') : ?>
			<!-- Data Pengguna -->
			<li class="menu-item">
				<a href="<?= site_url('user') ?>" class="menu-link">
					<i class="menu-icon fas fa-users"></i>
					<span>Data Pengguna</span>
				</a>
			</li>
		<?php endif; ?>

	</ul>

</aside>
