<?php
                
define('PROJECT_NAME', 'devupstuto');

define ('dbname', 'devupstuto_bd');
define ('dbuser', 'root');
define ('dbpassword',  '');
define ('dbhost',  'localhost');
        
// base url
/**
 * config environment
 */
// in production, replace by "/"
define('__v', '4.3');

define('__env', '/devupstuto/');
define('__prod', false);


define('ROOT', __DIR__  . '/../');
define('UPLOAD_DIR', __DIR__. '/../uploads/');
define('RESSOURCE', __DIR__ . '/../admin/Ressource/');
define('admin_dir', __DIR__ . '/../admin/');
define('web_dir', __DIR__ . '/../web/');

define('SRC_FILE', __env. 'uploads/');
define('RESSOURCE2', __env. 'admin/Ressource/');
define('VENDOR', __env. 'admin/vendor/');
define('UPLOAD_DIR_SRC', __env. 'admin/Ressource/js/');
define('JS', __env. 'admin/Ressource/js/');
define('IMG', __env. 'admin/Ressource/img/');
define('CSS', __env. 'admin/Ressource/css/');
define('IHM', __env. 'admin/Ressource/ihm/');

define('ENTITY', 0);
define('VIEW', 1);
define('ADMIN', 'admin_devups');
define('ENTERPRISE', 'entreprise_devups');


function asset($src){
    return __env .'web/' . $src;
}

function path($src){
    return __env . $src;
}

