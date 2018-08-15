<?php
            //ModuleTest
        
        require '../../../admin/header.php';
        
        global $views;
        $views = __DIR__ . '/Ressource/views';
                


    
    define('CHEMINMODULE', ' <a href="index.php" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleTest</a> ');

    
        		$testentityCtrl = new TestentityController();		

        if(isset($_GET['path'])){

            $path = explode('/', $_GET['path']);

            switch ($_GET['path']) {

                case 'layout':
                    Genesis::renderBladeView("layout");
                    break;
                        
				case 'testentity/index':
					Genesis::renderView('testentity.index',  $testentityCtrl->listAction(), 'list');
					break;
                case 'testentity/_new':
                    Genesis::renderView( 'testentity.form',  $testentityCtrl->__newAction(), 'new');
                    break;
				case 'testentity/create':
                    Genesis::renderView( 'testentity.form', $testentityCtrl->createAction(), 'error creation', true);
					break;					
				case 'testentity/update':
					Genesis::renderView( 'testentity.form',  $testentityCtrl->updateAction($_GET['id']),'error updating', true);
					break;


		
                default:
                    echo 'la route "'.$_GET['path'].'" n\'existe pas!';
                    break;
            }
    
        }else{
            Genesis::renderBladeView("layout");
        }		
        