<?php
    //ModuleProduct
		
        require '../../../admin/header.php';
        
        global $views;
        $views = __DIR__ . '/Ressource/views';
        

           // require 'devupstuto.moduleproduct.php';		
    define('CHEMINMODULE', ' <a href="'. __env .'admin" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleProduct</a> ');


    $controllers = [
			'storageCtrl' => new StorageController(),
		'categoryCtrl' => new CategoryController(),
		'subcategoryCtrl' => new SubcategoryController(),
		'productCtrl' => new ProductController(),
		'imageCtrl' => new ImageController(),
		 ];
			
		if(isset($_GET['path'])){
			
			$path = explode('/', $_GET['path']);
		
			switch ($path[ENTITY]) {
				
				case 'layout':
                                                                                                              Genesis::renderBladeView("layout");
					break;
						
				case 'category':
					CategoryGenesis::genesis($path[VIEW], $controllers);
					break;

				case 'category.rest':
					CategoryGenesis::restGenesis($path[VIEW], $controllers);
					break;

				case 'subcategory':
					SubcategoryGenesis::genesis($path[VIEW], $controllers);
					break;

				case 'subcategory.rest':
					SubcategoryGenesis::restGenesis($path[VIEW], $controllers);
					break;

				case 'product':
					ProductGenesis::genesis($path[VIEW], $controllers);
					break;

				case 'product.rest':
					ProductGenesis::restGenesis($path[VIEW], $controllers);
					break;

				case 'image':
					ImageGenesis::genesis($path[VIEW], $controllers);
					break;

				case 'image.rest':
					ImageGenesis::restGenesis($path[VIEW], $controllers);
					break;

		
				default:
					echo 'la route n\'existe pas!';
					break;
			}

		}else{
                        Genesis::renderBladeView("layout");
                }		
    