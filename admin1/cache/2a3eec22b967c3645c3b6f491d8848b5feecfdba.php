<?php $dvups_navigation = unserialize($_SESSION['navigation']); ?>

<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="<?= __env ?>admin/" >
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    <?php foreach($dvups_navigation as $key => $module): ?>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#nav-<?php echo e($module["module"]->getName()); ?>" aria-expanded="false" aria-controls="nav-<?php echo e($module["module"]->getName()); ?>">
                <i class="mdi mdi-circle-outline menu-icon"></i>
                <span class="menu-title"><?php echo e($module["module"]->getLabel()); ?></span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="nav-<?php echo e($module["module"]->getName()); ?>">
                <ul class="nav flex-column sub-menu">
                    <?php foreach($module["entities"] as $entity): ?>
                    <li class="nav-item"> <a class="nav-link" href="<?= path( 'src/'. strtolower($module["module"]->getProject()) .'/'. $module["module"]->getName() . '/' . $entity->getUrl() .'/index') ?>"><?= $entity->getLabel() ?> | manage <span class="fa fa-angle-right"></span></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </li>
    <?php endforeach; ?>
</ul>