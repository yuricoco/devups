<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- iso-8859-1  -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Sunhosting">
    <title class="mdi mdi-sort-variant">Dashboard | Dvups Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= VENDOR; ?>mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= VENDOR; ?>base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="<?= VENDOR; ?>datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= assets; ?>css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= assets; ?>favicon.png"/>

    <?php $__env->startSection('cssimport'); ?>

    <?php echo $__env->yieldSection(); ?>

    <script >
        var __env = '<?= __env ?>';
        var __lang = '<?= __lang ?>';
        var translate = <?= json_encode(translatecollection()) ?>;
    </script>
</head>

<body>

<div id="container-scroller">

    <!-- Navigation -->

    <!-- Navigation -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
            <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand brand-logo" href="index.html"><img src="<?php echo e(assets); ?>images/logo.svg" alt="logo"/></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="<?php echo e(assets); ?>images/logo-mini.svg" alt="logo"/></a>
                <button id="dbody" class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-sort-variant"></span>
                </button>
            </div>
        </div>

    <?php echo $__env->make("layout.navbartop", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </nav>

    <div class="container-fluid page-body-wrapper">

        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <?php echo $__env->make("layout.navbar", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </nav>

        <div class="main-panel">
            <div class="content-wrapper">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
                </div>
            </footer>
        </div>

    </div>

</div>

<!-- plugins:js -->
<script src="<?= VENDOR; ?>base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="<?= VENDOR; ?>chart.js/Chart.min.js"></script>
<script src="<?= VENDOR; ?>datatables.net/jquery.dataTables.js"></script>
<script src="<?= VENDOR; ?>datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="<?= assets; ?>js/off-canvas.js"></script>
<script src="<?= assets; ?>js/hoverable-collapse.js"></script>
<script src="<?= assets; ?>js/template.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="<?= assets; ?>js/dashboard.js"></script>
<script src="<?= assets; ?>js/data-table.js"></script>
<script src="<?= assets; ?>js/jquery.dataTables.js"></script>
<script src="<?= assets; ?>js/dataTables.bootstrap4.js"></script>
<!-- End custom js for this page-->

<?php
if (function_exists("script"))
    script();
?>
<?php $__env->startSection('jsimport'); ?>

<?php echo $__env->yieldSection(); ?>

</body>

</html>


