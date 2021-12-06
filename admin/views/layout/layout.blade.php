<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!-- iso-8859-1  -->
    <meta name="author" content="spacekola">
    <title class="mdi mdi-sort-variant">Dashboard | Dvups Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <!-- inject:css -->
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin2 </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ __admin }}vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ __admin }}vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ __admin }}vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{ __admin }}vendors/typicons/typicons.css">
    <link rel="stylesheet" href="{{ __admin }}vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="{{ __admin }}vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ __admin }}css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ __env }}logo.png" />
    
    <link rel="stylesheet" href="<?= assets ?>plugins/sweetalert2/sweetalert2.min.css">

    <link rel="stylesheet" href="<?= assets; ?>css/dv_style.css">

    @yield('cssimport')

    <?php
    if (function_exists("style"))
        style();
    ?>

    <script>
        var __env = '<?= __env ?>';
        var __lang = '<?= __lang ?>';
        var langs = {!! json_encode(Dvups_lang::allrows()) !!};
    </script>
</head>

<body>

<div class="container-scroller">

    @include("layout.navbartop")

    <div class="container-fluid page-body-wrapper">

        @if(\dclass\devups\Controller\Controller::$sidebar)
            @include("layout.navbar")
        @endif

        <div class="{{\dclass\devups\Controller\Controller::$sidebar ? 'main-panel' : ""}}">
            <div id="dv_main_container" class="content-wrapper">
                @yield('content')
            </div>
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Copyright © {{date("Y")}} {{PROJECT_NAME}}. All rights reserved.</span>
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Développé par <a href="https://www.spacekola.com/" target="_blank">Spacekola</a>.</span>
                </div>
            </footer>

        </div>
    </div>

</div>

<div id="dialog-container"></div>

<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{ __admin }}vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ __admin }}vendors/chart.js/Chart.min.js"></script>
<script src="{{ __admin }}vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ __admin }}js/off-canvas.js"></script>
<script src="{{ __admin }}js/hoverable-collapse.js"></script>
<script src="{{ __admin }}js/template.js"></script>
<script src="{{ __admin }}js/settings.js"></script>
<script src="{{ __admin }}js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ __admin }}js/chart.js"></script>
<!-- End custom js for this page-->

<!-- End custom js for this page-->
<script src="<?= assets; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= assets; ?>plugins/notify.min.js"></script>
<script src="<?= CLASSJS; ?>Request.js"></script>
<script src="<?= CLASSJS; ?>dialogbox.js"></script>

<?php
if (function_exists("script"))
    script();
?>
<script >
    setTimeout(()=> {
        $(".sidebar").find("li").removeClass("active")
        $(".sidebar").find("div").removeClass("show")
    }, 300)
</script>
@yield('jsimport')

</body>

</html>


