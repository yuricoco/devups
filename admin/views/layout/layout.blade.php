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
    <link rel="stylesheet" href="<?= __env; ?>admin/main.css">
    <link rel="stylesheet" href="<?= assets ?>plugins/sweetalert2/sweetalert2.min.css">

    <link rel="stylesheet" href="<?= assets; ?>css/dv_style.css">

    @section('cssimport')

    @show

    <?php
    if (function_exists("style"))
        style();
    ?>

    <script>
        var __env = '<?= __env ?>';
        var __lang = '<?= __lang ?>';
        var _t = <?= json_encode([]) ?>;

        var __name = "";
        var __phone = "";
        var __location = "";
        var __bp = "";
        var __rc = "";
        var __contrib = "";
        var __description = "";
    </script>
</head>

<body>

<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

    @include("layout.navbartop")

    <div class="app-main">
        @include("layout.navbar")
        <div class="app-main__outer">
            <div id="dv_main_container" class="app-main__inner">
                @yield('content')
            </div>
            <div class="app-wrapper-footer">
                <div class="app-footer">
                    <div class="app-footer__inner">
                        <div class="app-footer-left">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        Footer Link 1
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        Footer Link 2
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="app-footer-right">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        Footer Link 3
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        <div class="badge badge-success mr-1 ml-0">
                                            <small>NEW</small>
                                        </div>
                                        Footer Link 4
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

<script src="<?= assets; ?>scripts/main.js"></script>
<!-- End custom js for this page-->
<script src="<?= assets; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= assets; ?>plugins/notify.min.js"></script>

<!-- <script src="<?= node_modules ?>bootstrap/js/bootstrap.min.js"></script> -->
{{----}}

<?php
if (function_exists("modalview"))
    modalview($entity);
?>
<?php
if (function_exists("script"))
    script();
?>
@section('jsimport')

@show

</body>

</html>


