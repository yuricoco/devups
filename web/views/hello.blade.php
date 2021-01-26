<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ PROJECT_NAME }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <?php foreach (dclass\devups\Controller\Controller::$cssfiles as $cssfile){ ?>
    <link href="<?= $cssfile ?>" rel="stylesheet">
<?php } ?>

<!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">

    <div class="top-right links">
        <a href="{{ __env }}admin">Go to the backend</a>
    </div>

    <div class="content">
        <div class="title m-b-md">
            <form class="">
                <div class="">
                    <label class="">
                        select a file:
                    </label>
                    {!! Form::file("image", "", ["id"=>"imageinput"]) !!}
                </div>
                <button onclick="model.uploadfile(this)" type="button" class="">submit</button>
            </form>
        </div>

        <div class="content">

        </div>
        <div class="content">

        </div>

        <div class="links">
            <a href="#">Documentation</a>
            <a href="#">Contribut</a>
            <a href="#">News</a>
            <a href="#">Forge</a>
            <a href="#">GitHub</a>
        </div>
    </div>
</div>

{!! Form::addJquery() !!}
{!! Form::addDevupsjs() !!}
<script>
    var __env = '{{__env}}';
    model.uploadfile = function (el){
        var file = $("#imageinput")[0].files[0];
        console.log(file);
        var fd = new FormData();
        fd.append("image", file);
        model._apipost("uploadfile", fd, function (response) {
            console.log(response);
        })
    }
</script>
</body>
</html>
