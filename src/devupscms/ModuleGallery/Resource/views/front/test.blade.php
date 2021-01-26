<div id="image-{{$dv_image->getId()}}" class="col-md-6 col-xl-3 image-item">
    <div class="card mb-3 widget-content">
        <div class="widget-content-outer">
            <div class="widget-content-wrapper">
                <div class="widget-content-left">
                    <div class="widget-heading">{{$dv_image->getId()}}</div>
                    <div class="widget-subheading">
                        <img width="100px" src="{{$dv_image->srcImage()}}" />
                    </div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-success">
                        {!! AdminTemplateGenerator::dt_btn_action_builder($defaultactions, $customactions) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>