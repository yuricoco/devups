<?php
            //ModuleTranslate
		
        require '../../../admin/header.php';
        
        global $views;
        $views = __DIR__ . '/Ressource/views';
                



    define('CHEMINMODULE', ' <a href="index.php" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleTranslate</a> ');



    $controllers = [
			'dvups_langCtrl' => new Dvups_langController(),
		];

            if(isset($_GET['path'])){

                    $path = explode('/', $_GET['path']);

                    switch ($path[ENTITY]) {

                            case 'layout':
                                    Genesis::renderBladeView("layout");
                                    break;
                                            
                            case 'dvups_lang':
                                    Dvups_langGenesis::genesis($path[VIEW], $controllers);
                                    break;

                            case 'dvups_lang.rest':
                                    Dvups_langGenesis::restGenesis($path[VIEW], $controllers);
                                    break;

		
                            default:
                                    echo 'la route n\'existe pas!';
                                    break;
                    }

            }else{
                    Genesis::renderBladeView("layout");
            }		
        