<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- iso-8859-1  -->
    <meta name="author" content="spacekola">
    <title class="mdi mdi-sort-variant">Dashboard | Dvups Admin</title>
    <meta charset="utf-8">
    <link href="<?= __admin; ?>images/favicon.png" rel="icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= __env; ?>admin/main.css">
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
        var langs = <?php Genesis::json_encode2(Dvups_lang::all()) ?>;

        var _admin_id = '{{getadmin()->id}}';
        var _role = '{{getadmin()->dvups_role->name}}';
        /*
        var _local_content = = Local_contentController::getdatajs() ?>;
         */
    </script>
</head>

<body>

<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

    @include("layout.navbartop")

    <div class="app-main">

        @if(\dclass\devups\Controller\Controller::$sidebar)
            @include("layout.navbar")
        @endif

        <div class="{{\dclass\devups\Controller\Controller::$sidebar ? 'app-main__outer' : ""}}">
            <div id="dv_main_container" class="app-main__inner">
                @yield('content')
            </div>
            <div class="app-wrapper-footer">
                <div class="app-footer">
                    <div class="app-footer__inner">
                        <div class="app-footer-left">
                            <ul class="nav">
                                <li class="nav-item">
                                    Copyright © {{date("Y")}} {{PROJECT_NAME}} All rights reserved.
                                </li>
                            </ul>
                        </div>
                        <div class="app-footer-right">
                            <ul class="nav">
                                <li class="nav-item">
                                    {{t('Developed by ')}}
                                </li>
                                <li class="nav-item ml-3">
                                    <a href="https://spacekola.com/" target="_blank" >
                                         Spacekola
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-container"></div>

<script src="<?= assets; ?>scripts/main.js"></script>
<!-- End custom js for this page-->
<script src="<?= assets; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= assets; ?>plugins/notify.min.js"></script>
<script src="<?= CLASSJS; ?>Request.js"></script>
<script src="<?= CLASSJS; ?>devups.js"></script>
<script src="<?= CLASSJS; ?>dialogbox.js"></script>
<script >
    devups.timerNotification(_admin_id, '{{date("Y-m-d H:i:s")}}')
</script>

<?php
if (function_exists("script"))
    script();
?>
@yield('jsimport')

</body>

</html>


