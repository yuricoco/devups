@extends('layout.layout')
@section('title', 'Page Title')

@section('content')
  
    <div class="row">
            <div class="col-lg-12">
                    <ol class="breadcrumb">
                            <li class="active">
                                    <i class="fa fa-dashboard"></i> ModuleTranslate
                            </li>
                    </ol>
            </div>
    </div>
	<div class="row">
                  
                            <?php //if($moi->is_anable('dvups_lang')){ ?> 
            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                    <div class="panel-heading">
                                            <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 ">
                                                            <h4>Gestion Dvups_lang</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href="index.php?path=dvups_lang/index">
                                            <div class="panel-footer">
                                                    <?php 
                                                            //$action = 'dvups_lang';
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
				
                            <?php //if($moi->is_anable('dvups_contentlang')){ ?> 
            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                    <div class="panel-heading">
                                            <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 ">
                                                            <h4>Gestion Dvups_contentlang</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href="index.php?path=dvups_contentlang/index">
                                            <div class="panel-footer">
                                                    <?php 
                                                            //$action = 'dvups_contentlang';
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
	