<?php

require '../config/constante.php';
define('VENDOR', __env. 'admin/vendor/');
define('assets', __env. 'admin/assets/');

$action = 'index.php?path=connexion';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- iso-8859-1  -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Sunhosting">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="vendor/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="vendor/dist/css/jquery-ui.css" rel="stylesheet">

    <title>app v2.7.5 release </title>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In
                        <!--a href="<?=  $translate ?>fr">fr</a>
                        <a href="<?=  $translate ?>en">en</a-->
                    </h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?= $action; ?>">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Login" name="login" type="text" autofocus/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password"
                                       value=""/>
                            </div>

                            <button type="submit" class="btn btn-lg btn-success btn-block">Se connecter</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#wrapper -->
<div id="log_erreur"></div>
<!-- jQuery -->
<!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="vendor/dist/js/sb-admin-2.js"></script>

</body>

</html>
