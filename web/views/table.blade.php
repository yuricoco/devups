
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Foundation &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700|Anton" rel="stylesheet">


    <link rel="stylesheet" href="{{__env}}web/assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{__env}}web/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{__env}}web/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="{{__env}}web/assets/css/jquery-ui.css">
    <link rel="stylesheet" href="{{__env}}web/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{__env}}web/assets/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="{{__env}}web/assets/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="{{__env}}web/assets/fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="{{__env}}web/assets/css/aos.css">

    <link rel="stylesheet" href="{{__env}}web/assets/css/style.css">

</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

<div class="site-wrap"  id="home-section">
    <h1>table demo</h1>
    <div class="site-section counter" id="discover-section">

{!! $datatable->render() !!}

    </div>
</div>

{!! Form::addJquery() !!}
{!! Form::addDevupsjs() !!}
</body>
</html>
