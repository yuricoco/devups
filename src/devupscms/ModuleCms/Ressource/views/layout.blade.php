@extends('layout.layout')
@section('title', 'Page Title')

<?php function style(){ ?>

<?php foreach (dclass\devups\Controller\Controller::$cssfiles as $cssfile){ ?>
<link href="<?= $cssfile ?>" rel="stylesheet">
<?php } ?>

<?php } ?>

@section('content')
 
            <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-car icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ $moduledata->getName() }}
                    <div class="page-title-subheading">Some text</div>
                </div>
            </div>
            <div class="page-title-actions">

            </div>
        </div>
    </div>
    <ul class="nav nav-justified">
        <li class="nav-item">
            <a class="nav-link active" href="<?= path('src/' . strtolower($moduledata->getProject()) . '/' . $moduledata->getName() . '') ?>">
                <i class="metismenu-icon"></i> <span>Dashboard</span>
            </a>
        </li>
        @foreach ($moduledata->dvups_entity as $entity)
            <li class="nav-item">
                <a class="nav-link active" href="<?= path('src/' . strtolower($moduledata->getProject()) . '/' . $moduledata->getName() . '/' . $entity->getUrl() . '/index') ?>">
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

	