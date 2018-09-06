<?php
            //ModuleTest
        
        require '../../../admin/header.php';
        
        global $views;
        $views = __DIR__ . '/Ressource/views';
                


    
    define('CHEMINMODULE', ' <a href="index.php" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleTest</a> ');

    
        		$testentityCtrl = new TestentityController();		

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderBladeView("layout");
        break;
        
    case 'testentity/index':
        Genesis::renderView('testentity.index',  $testentityCtrl->listAction());
        break;					
    case 'testentity/create':
        Genesis::renderView( 'testentity.form', $testentityCtrl->createAction(), true);
        break;					
    case 'testentity/update':
        Genesis::renderView( 'testentity.form',  $testentityCtrl->updateAction($_GET['id']), true);
        break;


		
    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    