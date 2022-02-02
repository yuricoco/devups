<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin2 </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= __env; ?>admin/main.css">
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
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
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->

<script src="<?= assets; ?>scripts/main.js"></script>

<!-- endinject -->
</body>

</html>