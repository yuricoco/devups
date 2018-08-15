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
define('__default_lang', "fr");
define('__project_id', 'devupstuto');


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
define('CLASSJS', __env. 'class/devupsjs/');
define('IMG', __env. 'admin/Ressource/img/');
define('CSS', __env. 'admin/Ressource/css/');
define('IHM', __env. 'admin/Ressource/ihm/');

define('ENTITY', 0);
define('VIEW', 1);
define('ADMIN', __project_id.'_devups');

/**
 * NOTIFIACTION DEFINE
 */
define('LANG', "lang");
define('JSON_ENCODE_DEPTH', 512);


