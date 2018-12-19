
@extends('layout')
@section('title', 'Show')


@section('content')
                
                    <div class="row">
                            <div class="col-lg-12">
                                    <ol class="breadcrumb">
                                            <li class="active">
                                                    <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Detail 
                                            </li>
                                    </ol>
                            </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 ">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 ">
                                <h5>Detail Testentity</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-md-offset-6 col-lg-3">
                <?= Genesis::top_action(Testentity::class); ?>
            </div>
        </div>
    </div>
                    </div>
                    <div class="row">
                                            
                    <div class="col-lg-12 col-md-12">
                    
			<?php TestentityForm::__renderDetailWidget($testentity); ?>
			
	<div class="form-group text-center">
		<?php //echo Genesis::actionListView("testentity", $testentity->getId()); ?>
	</div>
	
	</div>
					
                    </div>        
         
@endsection