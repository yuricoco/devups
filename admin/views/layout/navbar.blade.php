<?php $dvups_navigation = unserialize($_SESSION[dv_role_navigation]); ?>
<!-- partial:../../partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="<?= __env ?>admin/">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @foreach ($dvups_navigation as $key => $component)
            <li class="nav-item nav-category">{{$component["component"]->getLabel()}}</li>

            @foreach ($component["modules"] as $key => $module)
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#{{$module["module"]->getName()}}-basic"
                       aria-expanded="false" aria-controls="{{$module["module"]->getName()}}-basic">
                        <i class="menu-icon {{$module["module"]->getFavicon()}}"></i>
                        <span class="menu-title">{{$module["module"]->getLabel()}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="{{$module["module"]->getName()}}-basic">
                        <ul class="nav flex-column sub-menu">
                            <li>
                                <a href="{{ $module["module"]->route() }}">
                                    <i class="metismenu-icon"></i> {{t("Dashboard")}}
                                </a>
                            </li>
                            @foreach ($module["entities"] as $entity)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $entity->route() }}">
                                        <i class="metismenu-icon"></i> {{$entity->getLabel()}}
                                        @if($nb = $entity->alert())
                                            (  {{$nb}} )
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        @endforeach

    </ul>
</nav>
<!-- partial -->
