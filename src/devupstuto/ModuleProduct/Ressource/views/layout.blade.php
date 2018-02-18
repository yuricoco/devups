@extends('layout.layout')
@section('title', 'Page Title')

@section('content')
  
    <div class="row">
            <div class="col-lg-12">
                    <ol class="breadcrumb">
                            <li class="active">
                                    <i class="fa fa-dashboard"></i> ModuleProduct
                            </li>
                    </ol>
            </div>
    </div>
    <div class="row">
                  
                        <?php //if($moi->is_anable('category')){ ?> 
            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                    <div class="panel-heading">
                                            <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 ">
                                                            <h4>Gestion Category</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href="index.php?path=category/index">
                                            <div class="panel-footer">
                                                    <?php 
                                                            //$action = 'category';
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
                            
                        <?php //if($moi->is_anable('subcategory')){ ?> 
            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                    <div class="panel-heading">
                                            <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 ">
                                                            <h4>Gestion Subcategory</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href="index.php?path=subcategory/index">
                                            <div class="panel-footer">
                                                    <?php 
                                                            //$action = 'subcategory';
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
                            
                        <?php //if($moi->is_anable('product')){ ?> 
            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                    <div class="panel-heading">
                                            <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 ">
                                                            <h4>Gestion Product</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href="index.php?path=product/index">
                                            <div class="panel-footer">
                                                    <?php 
                                                            //$action = 'product';
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
                            
                        <?php //if($moi->is_anable('image')){ ?> 
            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                    <div class="panel-heading">
                                            <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 ">
                                                            <h4>Gestion Image</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href="index.php?path=image/index">
                                            <div class="panel-footer">
                                                    <?php 
                                                            //$action = 'image';
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
    