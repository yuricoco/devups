@extends('layout.layout')
@section('title', 'Page Title')

<?php function style(){ ?>

<?php foreach (dclass\devups\Controller\Controller::$cssfiles as $cssfile){ ?>
<link href="<?= $cssfile ?>" rel="stylesheet">
<?php } ?>

<?php } ?>

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">{{ $moduledata->getLabel() }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= __env ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $moduledata->getLabel() }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <ul class="nav nav-justified">

        @foreach ($moduledata->dvups_entity as $entity)
            <li class="nav-item">
                <a class="nav-link active"
                   href="<?= path('src/' . strtolower($moduledata->getProject()) . '/' . $moduledata->getName() . '/' . $entity->getUrl() . '/index') ?>">
                    <i class="metismenu-icon"></i> <span><?= $entity->getLabel() ?></span>
                </a>
            </li>
        @endforeach
    </ul>
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

	