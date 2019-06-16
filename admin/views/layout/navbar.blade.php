<div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
        <li class="sidebar-search">
            <h2 class="input-group custom-search-form">
                <?= PROJECT_NAME ?>
            </h2>
            <!-- /input-group -->
        </li>
        <li class="active">
            <a href="<?= __env ?>admin/"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>

        <?php

        $dvups_navigation = unserialize($_SESSION['navigation']);

        ?>

        <?php foreach ($dvups_navigation as $key => $module) {
        //                                if(is_object($module)){?>
        <li>
            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> <?= $module["module"]->getLabel() ?> <span
                        class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <?php foreach ($module["entities"] as $entity) { ?>
                <li>
                    <a href='<?= path('src/' . strtolower($module["module"]->getProject()) . '/' . $module["module"]->getName() . '/' . $entity->getUrl() . '/index') ?>'>
                        <?= $entity->getLabel() ?> | manage <span class="fa fa-angle-right"></span>
                    </a>
                </li>
                <?php }?>
            </ul>
            <!-- /.nav-second-level -->
        </li>
        <?php } ?>

    </ul>
</div>