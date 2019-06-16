<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- iso-8859-1  -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Sunhosting">
    <title>app v3</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= VENDOR; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= VENDOR; ?>metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= assets; ?>../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?= VENDOR; ?>morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= VENDOR; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?= assets; ?>css/css_add.css" rel="stylesheet"/>

    <?php $__env->startSection('cssimport'); ?>

    <?php echo $__env->yieldSection(); ?>

    <?php
    if (function_exists("style"))
        style();
    ?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand">
                Devups Admin v<?php echo e(__v); ?> | Bonjour <b><?php echo e(getadmin()->getName()); ?></b>
                <a href="<?php echo e(__env); ?>" target="__blank"></a>
            </span>

        </div>
        <!-- /.navbar-header -->

    <?php echo $__env->make("layout.navbartop", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
        <?php echo $__env->make("layout.navbar", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php //include admin_dir . "views/navbar.blade.php"; ?>

        <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">

        <?php echo $__env->yieldContent('content'); ?>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<div id="log_erreur"></div>

<!-- jQuery -->
<script src="<?= VENDOR ?>jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= VENDOR ?>bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?= VENDOR ?>metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?= assets ?>../dist/js/sb-admin-2.js"></script>

<?php
if (function_exists("script"))
    script();
?>
<?php $__env->startSection('jsimport'); ?>

    <!-- Morris Charts JavaScript -->
    <script src="<?= VENDOR ?>raphael/raphael.min.js"></script>
    <script src="<?= VENDOR ?>morrisjs/morris.min.js"></script>
    <script src="<?= assets ?>../data/morris-data.js"></script>

<?php echo $__env->yieldSection(); ?>

</body>

</html>


