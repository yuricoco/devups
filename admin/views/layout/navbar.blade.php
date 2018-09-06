<div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li class="active" >
                                <a href="<?= __env ?>admin/"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        
                        <?php 
                                
        $dvups_navigation = unserialize($_SESSION['navigation']);
        
                        ?>
                            
                        <?php foreach ($dvups_navigation as $key => $module) {
//                                if(is_object($module)){?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> <?= $module["module"]->getLabel() ?> <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href='<?= path( 'src/'. strtolower($module["module"]->getProject()) .'/'. $module["module"]->getName() . '/index.php') ?>' > Overview<span class="fa arrow"></span></a>
                                    </li>
                                    <?php foreach ($module["entities"] as $entity) { ?>
                                    <li>
                                        <a href='#' > <?= $entity->getLabel() ?><span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="<?= path( 'src/'. strtolower($module["module"]->getProject()) .'/'. $module["module"]->getName() . '/index.php?path=' . strtolower($entity->getName()) .'/index') ?>">manage</a>
                                            </li>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php }?>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        <?php } ?>

                    </ul>
                </div>