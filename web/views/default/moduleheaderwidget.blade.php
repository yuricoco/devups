<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class=" ">
                    {!! $moduledata->getPrinticon() !!}
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
        <a class="nav-link active"
           href="<?= $moduledata->route() ?>">
            <i class="metismenu-icon"></i> <span>Dashboard</span>
        </a>
    </li>
    @foreach ($moduledata->dvups_entity as $entity)
        <li class="nav-item">
            <a class="nav-link active"
               href="<?=  $entity->route() ?>">
                <i class="metismenu-icon"></i> <span><?= $entity->getLabel() ?></span>
            </a>
        </li>
    @endforeach
</ul>