<?php
                
define('PROJECT_NAME', 'devupstuto');

define ('dbname', 'devupstest6_bd');
//define ('dbname', 'devupstest3_bd');

//define ('dbname', 'devupstest_bd');
//define ('dbname', 'devupstuto_bd');
define ('dbuser', 'root');
define ('dbpassword',  '');//BD20Devupstuto18
define ('dbhost',  'localhost');
define ('dbdumper',  false);
define ('dbtransaction',  false);

// base url
/**
 * config environment
 */
// in production, replace by "/"
define('__v', '4.3');

define('__server', 'http://127.0.0.1');
define('__env', __server.'/devupstuto/');
define('__front', __env.'web/assets/');
define('__admin', __env.'admin/assets/');
define('__prod', false);
define('__default_lang', "fr");
define('__lang', 'fr');

/**
 * mode debug
 *
 * display error
 */
define('__debug_front', false);
define('__debug_admin', false);

/**
 * config toolrad sync
 */
define('__project_id', 'devupstuto');
define('__toolrad_server', 'http://127.0.0.1/toolrad2/api/');
define('__toolrad_api_key', 'ynwE33SgT');


define('ROOT', __DIR__  . '/../');
define('CLASS_EXTEND', ROOT . "dclass/extends");
// define('CLASS_LANG', ROOT . "dclass/lang");
define('UPLOAD_DIR', __DIR__. '/../uploads/');
define('RESSOURCE', __DIR__ . '/../admin/Ressource/');
define('admin_dir', __DIR__ . '/../admin/');
define('web_dir', __DIR__ . '/../web/');

define('SRC_FILE', __env. 'uploads/');
define('RESSOURCE2', __env. 'admin/Ressource/');
define('CLASSJS', __env. 'dclass/devupsjs/');
define('node_modules', __env . 'node_modules/');

define('ENTITY', 0);
define('VIEW', 1);

define('ADMIN', __project_id.'_devups');
define('CSRFTOKEN', __project_id.'_csrf_token');
define('dv_role_navigation', __project_id.'_navigation');
define('dv_role_permission', __project_id.'_permission');

/**
 * NOTIFIACTION DEFINE
 */
define('LANG', "lang");
define('PREVIOUSPAGE', "previous_page");
define('JSON_ENCODE_DEPTH', 512);



