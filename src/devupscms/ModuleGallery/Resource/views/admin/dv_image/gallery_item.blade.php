
<div id="image-{{$dv_image->getId()}}"
     class="col-md-3 col-xl-2 image-item ">
    <div class="card mb-3 widget-content">
        <div class="widget-content-outer">
            <div class="widget-content-wrapper">
                <div class="widget-content-left">
                    <div class="widget-heading">
                        {{$dv_image->folder->getName()}}/
                        <button onclick="model.dvimage._delete(this, {{$dv_image->getId()}}, this)"
                                class="btn btn-danger">delete
                        </button>
                        <button onclick="model.dvimage._edit({{$dv_image->getId()}})"
                                class="btn btn-info">edit
                        </button>
                    </div>
                    <div class="">
                        <img src="{{$dv_image->srcImage('150_')}}" />
                    </div>
                    {{$dv_image->getId()}} - {{$dv_image->getImage()}}
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-success">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>