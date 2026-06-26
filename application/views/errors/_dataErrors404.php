<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>assets/images/logo-light-icon3.png">
    <title>Not Found!</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>assetsadmin/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>assetsadmin/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url() ?>assetsadmin/css/colors/blue.css" id="theme" rel="stylesheet">

</head>
<body class="fix-header card-no-border logo-center">
 <!-- ============================================================== -->
 <!-- Main wrapper - style you can find in pages.scss -->
 <!-- ============================================================== -->
 <section id="wrapper" class="error-page">
    <div class="error-box">
        <div class="error-body text-center">
            <h1>404</h1>
            <h3 class="text-uppercase">Data yang anda cari tidak ada</h3>
            <!-- <p class="text-muted m-t-30 m-b-30"></p> -->
            <footer class="footer text-center">© <span id="current-year"></span> Dinas Kebudayaan Pariwisata Pemuda dan Olah Raga</footer>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url() ?>assetsadmin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url() ?>assetsadmin/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assetsadmin/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url() ?>assetsadmin/js/waves.js"></script>
    <script>
        // Ambil elemen span dan isi dengan tahun sekarang
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
</body>
</html>