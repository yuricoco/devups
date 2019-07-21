<?php

require '../config/constante.php';
define('VENDOR', __env . 'admin/vendors/');
define('assets', __env . 'admin/assets/');

$action = 'index.php?path=connexion';

?>

<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="<?= __env; ?>admin/main.css">
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

    <div class="app-main">
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="login-panel panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Please Sign In </h3>
                                </div>
                                <div class="panel-body">
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

                                            <button type="submit" class="btn btn-lg btn-success btn-block">Se
                                                connecter
                                            </button>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= assets; ?>scripts/main.js"></script>
<!-- End custom js for this page-->

<!-- endinject -->
</body>

</html>
