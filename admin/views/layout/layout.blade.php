
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

            @section('cssimport')

            @show

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
                    <span  class="navbar-brand" >
                        Devups Admin v{{ __v }} | Bonjour <b>{{ getadmin()->getName() }}</b>
                        <a href="{{ __env }}" target="__blank"></a>

                        <!--a href="<?= Dvups_lang::classroot() ?>changelang&lang=fr">fr</a>
                        <a href="<?= Dvups_lang::classroot() ?>changelang&lang=en">en</a-->

                    </span>

                </div>
                <!-- /.navbar-header -->

                @include("layout.navbartop")
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    @include("layout.navbar")
                    <?php //include admin_dir . "views/navbar.blade.php"; ?>

                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper">
                
            @yield('content')
            
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

        <?php
        if (function_exists("script"))
        script();
        ?>
            @section('jsimport')
            
        <script src="<?= VENDOR ?>morrisjs/morris.min.js"></script>
        <script src="<?= VENDOR ?>data/morris-data.js"></script>

            @show

    </body>

</html>


