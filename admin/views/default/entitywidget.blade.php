<div class="col-md-6 col-xl-3">
    <div class="card mb-3 widget-content">
        <div class="widget-content-outer">
            <div class="widget-content-wrapper">
                <div class="widget-content-left">
                    <div class="widget-heading">
                        {{$entity->getLabel()}}
                    </div>
                    <div class="widget-subheading"><a href="{{ $entity->route() }}">
                            <i class="fa fa-external-link-alt"></i> {{t("Details")}}
                        </a></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-success">{{ucfirst($entity->getLabel())::count()}}</div>
                </div>
            </div>
        </div>
    </div>
</div>