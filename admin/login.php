<?php

require '../config/constante.php';
define('VENDOR', __env . 'admin/vendors/');
define('assets', __env . 'admin/assets/');

$action = 'index.php?path=connexion';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin2 </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= __admin; ?>vendors/feather/feather.css">
    <link rel="stylesheet" href="<?= __admin; ?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= __admin; ?>vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?= __admin; ?>vendors/typicons/typicons.css">
    <link rel="stylesheet" href="<?= __admin; ?>vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?= __admin; ?>vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= __admin; ?>css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= __admin; ?>images/favicon.png" />
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                            <img class="img-fluid" src="<?= __env; ?>logo-long.png" alt="Logo">

                        <h4>Hello! let's get started</h4>
                        <h6 class="fw-light">Sign in to continue.</h6>

                        <?php if (isset($_GET["err"])){ ?>
                            <div class="alert alert-warning"><?= $_GET["err"] ?></div>
                        <?php } ?>
                        <form role="form" method="post" action="<?= $action; ?>">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Login" name="login" type="text"
                                           autofocus/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password"
                                           type="password"
                                           value=""/>
                                </div>
                                <div class="remember">
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember_me" type="checkbox">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-success btn-block">Se
                                    connecter
                                </button>
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="<?= __admin; ?>vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="<?= __admin; ?>vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?= __admin; ?>js/off-canvas.js"></script>
<script src="<?= __admin; ?>js/hoverable-collapse.js"></script>
<script src="<?= __admin; ?>js/template.js"></script>
<script src="<?= __admin; ?>js/settings.js"></script>
<script src="<?= __admin; ?>js/todolist.js"></script>
<!-- endinject -->
</body>

</html>
