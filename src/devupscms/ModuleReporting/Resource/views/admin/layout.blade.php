@extends('layout.layout')
@section('title', 'Page Title')

<?php function style(){ ?>

<?php foreach (dclass\devups\Controller\Controller::$cssfiles as $cssfile){ ?>
<link href="<?= $cssfile ?>" rel="stylesheet">
<?php } ?>

<?php } ?>

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        @tt('SMTP configuration ')
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!!
                        ConfigurationTable::init(new Configuration())
                            ->buildconfigtable()
                            ->setModel("config")
                            ->Qb(Configuration::where("_key")->in(["sm_port", "sm_smtp", "sm_username", "sm_password", "sm_from", "sm_name", "sm_smtpsecurity", ]))
                            ->render()
                    !!}
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class='col-lg-12'>
        <div class='alert alert-info row'>
            <div class='col-lg-4'>
                a sample of code that shows how to use Emailmodel class.
                <pre class=' '>
        Reportingmodel::init("subscription")
            ->addReceiver($user->getEmail(), $user->getFirstname())
            ->sendMail([
                "username"=>$user->getFirstname(),
                "number"=>$subscription->getNumber(),
                "emailto"=> "info@sunshine-advisory.com",
                "phonenumber"=> "xxxxxxx",
                "login"=> route("login"),
            ]);

    </pre>
                Note: for pdf we use mpdf
                <pre class=' '>composer require mpdf/mpdf </pre>
                to install
            </div>
            <div class='col-lg-8'>
                <table class="table">
                    <tr>
                        <th>init()</th>
                        <th>name of the emailmodel :string</th>
                        <td>static method that wait the name of the email model and return an instance of the entity
                            model
                        </td>
                    </tr>
                    <tr>
                        <th>addReceiver()</th>
                        <th>email receiver: str, name receiver: str (opt)</th>
                        <td>instance method that wait the email and name of the receiver of the mail. we can add ass
                            many
                            receiver as we wish
                        </td>
                    </tr>
                    <tr>
                        <th>sendMail()</th>
                        <th>data :array</th>
                        <td>instance method that wait the data to compute the mail with. it must be an array key =>
                            value
                            else
                            empty array to say no data to compute
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @include("default.moduleheaderwidget")
    <hr>

    @yield('layout_content')


@endsection

<?php function script(){ ?>

<script src="<?= CLASSJS ?>devups.js"></script>
<script src="<?= CLASSJS ?>model.js"></script>
<script src="<?= CLASSJS ?>ddatatable.js"></script>
<?php foreach (dclass\devups\Controller\Controller::$jsfiles as $jsfile){ ?>
<script src="<?= $jsfile ?>"></script>
<?php } ?>

<?php } ?>

	