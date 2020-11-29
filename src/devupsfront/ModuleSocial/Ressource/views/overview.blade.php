 @extends('layout')
@section('title', 'List')

@section('layout_content')

	<div class="row">
                  
                            <?php //if($moi->is_anable('social_network')){ ?> 
            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                    <div class="panel-heading">
                                            <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 ">
                                                            <h4>Gestion Social_network</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href="index.php?path=social_network/index">
                                            <div class="panel-footer">
                                                    <?php 
                                                            //$action = 'social_network';
                                                            //include RESSOURCE.'navigation.php'; 
                                                    ?>
                                                    <span class="pull-left">View Details</span>
                                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                            </div>
                                    </a>
                            </div>
                    </div>  
                <?php //} ?> 			
				 
            </div>
            @endsection 
            