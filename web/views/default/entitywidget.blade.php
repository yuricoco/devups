<div class="col-md-6 col-xl-3">
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">
                {{$entity->getLabel()}}
            </div>
            <a href="{{ $entity->route() }}">
                <i class="fa fa-external-link-alt"></i> {{t("Details")}}
            </a>
            <div class="widget-numbers text-success">{{ucfirst($entity->getName())::count()}}</div>
        </div>
    </div>
</div>