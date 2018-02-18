@extends('layout.layout')
@section('title', 'Page Title')

@section('content')
  
    <div class="row">
            <div class="col-lg-12">
                    <ol class="breadcrumb">
                            <li class="active">
                                    <i class="fa fa-dashboard"></i> ModuleStock
                            </li>
                    </ol>
            </div>
    </div>
    <div class="row">
                  
                        <?php //if($moi->is_anable('storage')){ ?> 
            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                    <div class="panel-heading">
                                            <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 ">
                                                            <h4>Gestion Storage</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href="index.php?path=storage/index">
                                            <div class="panel-footer">
                                                    <?php 
                                                            //$action = 'storage';
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
    