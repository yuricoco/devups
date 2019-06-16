<?php $dvups_navigation = unserialize($_SESSION['navigation']); ?>

<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="<?= __env ?>admin/" >
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    @foreach ($dvups_navigation as $key => $module)
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#nav-{{$module["module"]->getName()}}" aria-expanded="false" aria-controls="nav-{{$module["module"]->getName()}}">
                <i class="mdi mdi-circle-outline menu-icon"></i>
                <span class="menu-title">{{$module["module"]->getLabel()}}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="nav-{{$module["module"]->getName()}}">
                <ul class="nav flex-column sub-menu">
                    @foreach ($module["entities"] as $entity)
                    <li class="nav-item">
                        <a class="nav-link" href="<?= path( 'src/'. strtolower($module["module"]->getProject()) .'/'. $module["module"]->getName() . '/' . $entity->getUrl() .'/index') ?>"><?= $entity->getLabel() ?> | manage <span class="fa fa-angle-right"></span></a></li>
                    @endforeach
                </ul>
            </div>
        </li>
    @endforeach
</ul>