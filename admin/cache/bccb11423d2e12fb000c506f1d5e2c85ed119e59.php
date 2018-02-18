
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- iso-8859-1  -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Sunhosting">
            <link href="<?php echo IHM; ?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>

            <title>app v3</title>
            <!-- DataTables CSS -->
            <link href="<?php echo IHM; ?>datatables/css/dataTables.responsive.css" rel="stylesheet"/>

            <!-- MetisMenu CSS -->
            <link href="<?php echo IHM; ?>metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>

            <!-- Timeline CSS -->
            <link href="<?php echo IHM; ?>dist/css/timeline.css" rel="stylesheet"/>

            <!-- Custom CSS -->
            <link href="<?php echo IHM; ?>dist/css/sb-admin-2.css" rel="stylesheet"/>

            <!-- Custom Fonts -->
            <link href="<?php echo IHM; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

            <link href="<?php echo IHM; ?>dist/css/jquery-ui.css" rel="stylesheet"/>
            <link href="<?php echo RESSOURCE2; ?>css_add/css_add.css" rel="stylesheet"/>

            <?php $__env->startSection('cssimport'); ?>

            <?php echo $__env->yieldSection(); ?>

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
                    <a class="navbar-brand" href="<?php echo e(__env); ?>" target="__blank">Devups Admin v<?php echo e(__v); ?> | go to <?php echo e(PROJECT_NAME); ?></a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>Read All Messages</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-tasks">
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 1</strong>
                                            <span class="pull-right text-muted">40% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Tasks</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-tasks -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">

                            <!--                        <li>
                                                        <a href="<?= __DIR__ ?>/../../src/devups/ModuleAdmin/index.php?path=admin/changerpwd"><i class="fa fa-fw fa-user"></i> mot de passe</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= __DIR__ ?>/../../src/devups/ModuleAdmin/index.php?path=admin/changerphoto"><i class="fa fa-gear fa-fw"></i> Photo</a>
                                                    </li>-->
                            <li class="divider"></li>
                            <li>
                                <a href="<?= path('src/devups/ModuleAdmin/index.php?path=deconnexion') ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <?php include admin_dir . "views/navbar.blade.php"; ?>
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
        <!-- jQuery -->
        <script src="<?php echo JS ?>jquery.js" ></script>
        <!-- Angular -->
        <script src="<?php echo JS ?>angular.min.js" ></script>
        <!--<script src="<?php echo JS ?>angular-route.min.js" ></script>-->
        <script src="<?php echo JS ?>angular-file-model.js" ></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo IHM; ?>bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo IHM; ?>metisMenu/dist/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="<?php echo IHM; ?>raphael/raphael-min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo IHM; ?>dist/js/sb-admin-2.js"></script>

        <script src="<?php echo JS ?>jquery-ui.js" ></script>
        <script src="<?php echo JS ?>main.js" ></script>

        <!-- Morris Charts JavaScript -->
        <script src="<?= VENDOR ?>raphael/raphael.min.js"></script>

            <?php $__env->startSection('jsimport'); ?>
            
        <script src="<?= VENDOR ?>morrisjs/morris.min.js"></script>
        <script src="<?= VENDOR ?>data/morris-data.js"></script>

            <?php echo $__env->yieldSection(); ?>

    </body>

</html>


