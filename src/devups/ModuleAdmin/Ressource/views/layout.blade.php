@extends('layout.layout')
@section('title', 'Page Title')

<?php function style(){ ?>

<?php foreach (dclass\devups\Controller\Controller::$cssfiles as $cssfile){ ?>
<link href="<?= $cssfile ?>" rel="stylesheet">
<?php } ?>

<?php };?>

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $moduledata->getName() }}</h1>
    </div>

    <ul class="nav nav-justified">
        @foreach ($moduledata->dvups_entity as $entity)
            <li class="nav-item page-item">
                <a class="nav-link  page-link " href="<?= path('src/' . strtolower($moduledata->getProject()) . '/' . $moduledata->getName() . '/' . $entity->getUrl() . '/index') ?>">
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

