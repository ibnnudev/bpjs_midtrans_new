<?php $this->load->view('template/header'); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            <?php $this->load->view('template/sidebar'); ?>
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php $this->load->view('template/navbar'); ?>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Main content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php $this->load->view($content); ?>
                    </div>
                    <!-- Footer -->
                    <?php $this->load->view('template/footer'); ?>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- Core JS -->
    <script src="<?php echo base_url('asset/vendor/libs/jquery/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('asset/vendor/libs/popper/popper.js'); ?>"></script>
    <script src="<?php echo base_url('asset/vendor/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
    <script src="<?php echo base_url('asset/vendor/js/menu.js'); ?>"></script>
    <!-- Vendors JS -->
    <script src="<?php echo base_url('asset/vendor/libs/apex-charts/apexcharts.js'); ?>"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url('asset/js/main.js'); ?>"></script>
    <!-- Page JS -->
    <script src="<?php echo base_url('asset/js/dashboards-analytics.js'); ?>"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Initialization Script -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>

    <script>
        $(document).ready(function() {
            $('#barangTable').DataTable({
                "pagingType": "full_numbers",
                "responsive": true,
                "order": [
                    [0, 'asc']
                ]
            });
            $('#blokFilter').on('change', function() {
                var filterValue = $(this).val();
                var table = $('#pedagangTable').DataTable();
                table.column(2).search(filterValue).draw();
            });
        });
    </script>
</body>

</html>