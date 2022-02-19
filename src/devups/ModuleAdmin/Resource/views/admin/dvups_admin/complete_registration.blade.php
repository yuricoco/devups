<!DOCTYPE html>
<html lang="en">

<head>
    <!-- iso-8859-1  -->
    <meta name="author" content="spacekola">
    <title class="mdi mdi-sort-variant">Dashboard | Dvups Admin</title>
    <!-- Favicons -->
    <link href="<?= __env; ?>favicon.png" rel="icon">
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
        <div class="container">
            <div style="width: 400px; margin: auto" class="loginbox">

                <div class="login-left">
                    <img class="img-fluid" src="<?= __env; ?>logo-long.png" alt="Logo">
                </div><hr >
                <div class="login-panel panel panel-default">

                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                        <h1>Bonjour, <?= $admin->getName(); ?></h1>
                        <p class="account-subtitle">Complete your account credential</p>

                        <?php if (isset($error)){ ?>
                        <div class="alert alert-warning"><?= $error ?></div>
                        <?php } ?>

                        <form role="form" method="post" action="{{$action}}">
                            <fieldset>
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input class="form-control" placeholder="Current Password" name="currentpwd" type="password" autocomplete="false" value=""  autofocus />
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control" placeholder="New Password" name="newpwd" type="password" autocomplete="false"  value="" />
                                </div>

                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input class="form-control" placeholder="Confirm New Password" name="confimnewpwd" type="password" autocomplete="false"  value="" />
                                </div>

                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                    End Creation
                                </button>
                            </fieldset>
                        </form>
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

