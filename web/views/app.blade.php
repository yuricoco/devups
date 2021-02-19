<!doctype html>
<html lang="en"><head>
    <!-- important for compatibility charset -->
    <base href="{{__env}}"/>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield("page_title", "Home") </title>

    <meta name="author" content="spacekola">

    <!-- important for responsiveness remove to make your site non responsive. -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
@yield("page_meta")
<!-- FavIcon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ assets }}image/favicon.png">
    <link rel="stylesheet" type="text/css" href="{{ assets }}js/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ assets   }}css/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ assets   }}css/stylesheet.css" />
    <link rel="stylesheet" type="text/css" href="{{ assets   }}css/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="{{ assets   }}css/owl.transitions.css" />
    <link rel="stylesheet" type="text/css" href="{{ assets }}css/responsive.css" />

    <!-- Theme Styles CSS File -->
    <link rel="stylesheet" type="text/css" href="{{ assets   }}css/customstyle.css" media="all" />

    <!-- Google Fonts -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans' type='text/css'>

    <?php foreach (App::$cssfiles as $cssfile){ ?>
    <link href="<?= $cssfile ?>" rel="stylesheet">
    <?php } ?>

    @yield("cssimport")

    <script >
        var __lang = '<?= local() ?>';
        var __env = '<?= __env ?>';
        var __assets = "<?= __env; ?>web/assets/";
        var __asset = "<?= __env; ?>web/assets/";

    </script>

</head>

<body >
<div class="wrapper-wide">

    <div id="header">
        <!-- Top Bar Start-->
        <nav id="top" class="htop">
            <div class="container">
                <div class="row"><span class="drop-icon visible-sm visible-xs"><i class="fa fa-align-justify"></i></span>
                    <div class="pull-left flip left-top">
                        <div class="links">
                            <ul>
                                <li class="mobile"><i class="fa fa-phone"></i>{!! tt("bs24.telephone") !!}</li>
                                <li class="email"><a href="mailto:info@marketshop.com"><i class="fa fa-envelope"></i>{!! tt("bs24.email")  !!}</a>
                                </li>
                            </ul>
                        </div>
                        <div id="language" class="btn-group">
                            <button class="btn-link dropdown-toggle" data-toggle="dropdown">
                        <span>
                        <?php if(local() == "fr"){ ?>
                        <img width="20px" src="<?= assets . 'image/flags/fr.png' ?>"/> Français
                        <?php }else{ ?>
                        <img width="20px" src="<?= assets . ('image/flags/gb.png') ?>" alt="English" title="English"/> English
                        <?php } ?>
                         <i class="fa fa-caret-down"></i></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?= __env . "changelang?lang=fr" ?>"
                                       class="btn btn-link btn-block language-select" type="button" name="GB"><img
                                                src="{{ assets }}image/flags/fr.png" alt="English" title="English"/> Français</a>
                                </li>
                                <li>
                                    <a href="<?= __env . "changelang?lang=en" ?>"
                                       class="btn btn-link btn-block language-select" type="button" name="GB"><img
                                                src="{{ assets   }}image/flags/gb.png" alt="English" title="English"/>
                                        English</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Top Bar End-->

        <!-- Top Bar End-->
        <!-- Header Start-->
        <header class="header-row">
            <div class="container">
                <div class="table-container">
                    <!-- Logo Start -->
                    <div class="col-table-cell col-lg-3 col-md-3 col-sm-12 col-xs-6 inner">
                        <div id="logo"><a href="{{ __env   }}">
                                <img width="150" class="img-responsive" alt="{{ PROJECT_NAME   }}" src="<?= __env; ?>logo-long.png"
                                     title="{{ PROJECT_NAME   }}"/>
                            </a>
                        </div>
                    </div>
                    <!-- Logo End -->

                </div>
            </div>
        </header>
        <!-- Header End-->

    </div>

<!-- Header Ends /-->

    @yield('content')

    <div id="productquickviewbox" class="swal2-container swal2-fade swal2-shown"
         style="display:none; overflow-y: auto;">
        <div role="dialog" aria-labelledby="swal2-title" aria-describedby="swal2-content"
             class="swal2-modal swal2-show dv_modal" tabindex="1"
             style="">
            <div class="main-card mb-3 card  box-container">
                <div class="card-header">.

                    <button onclick="model._dismissmodal()" type="button" class="swal2-close"
                            aria-label="Close this dialog" style="display: block;">×
                    </button>
                </div>
                <div class="card-body"></div>
            </div>

        </div>
    </div>

    <!--Footer Start-->
    <footer id="footer">
        <div class="fpart-second">
            <div class="container">
                <div id="powered" class="clearfix">
                    <div class="powered_text pull-left flip">
                        <p>{!! tt("copyright", "BuyamSellam24 | Copyright © :year buyamsellam24.com", ["year"=>date("Y")])   !!} | Develop By <a href="http://spacekola.com" target="_blank">Spacekola</a></p>
                    </div>
                    <div class="social pull-right flip">
                        <a href="https://www.facebook.com/BuyamSellam-24-100742745094521/" target="_blank">
                            <img data-toggle="tooltip" src="{{ assets   }}image/socialicons/facebook.png" alt="Facebook" title="Facebook"></a>
                        <a href="https://twitter.com/Buyamsellam2" target="_blank">
                            <img data-toggle="tooltip" src="{{ assets   }}image/socialicons/twitter.png" alt="Twitter" title="Twitter"> </a>
                        <a hidden href="#" target="_blank"> <img data-toggle="tooltip" src="{{ assets   }}image/socialicons/google_plus.png" alt="Google+" title="Google+"> </a>
                        <a hidden href="#" target="_blank"> <img data-toggle="tooltip" src="{{ assets   }}image/socialicons/pinterest.png" alt="Pinterest" title="Pinterest"> </a>
                        <a hidden href="#" target="_blank"> <img data-toggle="tooltip" src="{{ assets   }}image/socialicons/rss.png" alt="RSS" title="RSS"> </a> </div>
                </div>

            </div>
        </div>
        <div id="back-top"><a data-toggle="tooltip" title="Back to Top" href="javascript:void(0)" class="backtotop"><i class="fa fa-chevron-up"></i></a></div>
    </footer>
</div>


@yield("jsimport")

</body>
</html>
