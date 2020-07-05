<?php

//require __DIR__ . '/../../config/constante.php';

require __DIR__ . '/../../config/dependanceInjection.php';

require __DIR__ . '/BackendGenerator.php';
require __DIR__ . '/android/BackendGeneratorJava.php';
require __DIR__ . '/RequestGenerator.php';
require __DIR__ . '/Traitement.php';
require __DIR__ . '/__Generator.php';
require __DIR__ . '/android/__Generatorjava.php';


global $separator, $isWindows;
$isWindows = false;
$separator = '/';

//If the first three characters PHP_OS are equal to "WIN",
//then PHP is running on a Windows operating system.
if(strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0){
    $isWindows = true;
    $separator = '\\';
}

$module_entities = [];

function getproject($namespace) {
    global $separator;
    // get all components building the global project
    $components = Core::buildOriginCore();

    $ns = explode($separator, $namespace);
    return __Generator::findproject($components, $ns[0]);
}

function getcomponent($namespace) {
    global $separator;
    // get all components building the global project
    $components = Core::getComponentCore();

    $ns = explode($separator, $namespace);
    return __Generator::findproject($components, $ns[0]);

}

if ($argv[1] === 'schema:update') {

    $result = [];
    exec("bin\doctrine orm:schema:update --dump-sql", $result);

    $action = "--dump-sql";
    if(isset($argv[2]))
        $action = $argv[2];

    switch ($action) {
        case '--dump-sql':

            echo implode("\n ", $result);
            break;

        case '--force':

            echo " Updating database schema...\n ";

            $dbal = new DBAL();
            for ($i = 3; $i < count($result); $i++) {
                if(!isset($result[$i]))
                    break;

                $query = $result[$i];
                if ($query){
                    $dbal->executeDbal($query);
                    \dclass\devups\Tchutte\DB_dumper::migration($query);
                }
            }
            echo "\n \e[42m \e[1m\e[30m \n[OK] Database schema updated successfully!\n ";
            echo  "\e[0m";
            break;
        default:
            echo " \n Enter the option --force to persist the query ";

            echo implode("\n ", $result);
            break;

            break;
    }
    echo  "\n";
    die;

}

if ($argv[1] === 'transaction:rollback') {

    $lastdump = ROOT . 'database/dump/dump_' . $argv[2] . '.sql';
    if (!file_exists($lastdump)) {
        echo "\n > dump_" . $argv[2] . " file not exist! rollback aborded!!!\n";
        die;
    }
    $root_path = ROOT . 'database/transaction/transaction_' . $argv[2] . '.data';
    if (!file_exists($root_path)) {
        echo "\n > transaction_" . $argv[2] . " file not exist! rollback aborded!!!\n";
        die;
    }

    $db_dump = new \dclass\devups\DB_dumper();
    $db_dump->dump(true);
    echo " > current version of .\n\n" . dbname . " has been dumped successfully ...\n";

    RequestGenerator::databasecreate(dbname); //,
    echo " > Creating Database.\n\n" . dbname . ": created with success ...\n";

    $rqg = new Database();
    $dvupsadminsql = file_get_contents($lastdump);
    $rqg->link()->prepare($dvupsadminsql)->execute();

    echo "\n\n > Last stable version of database has been imported successfully ... \n\n";

    //$db_dump = new \dclass\devups\DB_dumper();
    $db_dump->rollback($argv[2]);
    echo "\n\n > " . $argv[2] . "'s transaction successfully rollback :) \n\n";

    die;
}

$project = null;
if (isset($argv[2])) {
    $project = getproject($argv[2]);

    chdir('src/' . $project->name);

    switch ($argv[1]) {

        case 'entity:g:core':
            __Generator::core($argv[2], $project); //,
            echo $argv[2] . ": Core generated with success";
            break;

        case 'core:g:views':
            __Generator::views($argv[2], $project); //,
            echo $argv[2] . ": Views generated with success";
            break;

        case 'core:g:genesis':
            __Generator::genesis($argv[2], $project); //, 
            echo $argv[2] . ": Genesis generated with success";
            break;

        case 'core:g:controller':
            __Generator::controller($argv[2], $project); //, 
            echo $argv[2] . ": Controller generated with success";
            break;

        case 'core:g:frontcontroller':
            __Generator::frontcontroller($argv[2], $project); //,
            echo $argv[2] . ": Front Controller generated with success";
            break;

        case 'core:g:form':
            __Generator::form($argv[2], $project); //, 
            echo $argv[2] . ": Form generated with success";
            break;

        case 'core:g:table':
            __Generator::table($argv[2], $project); //,
            echo $argv[2] . ": Table generated with success";
            break;

        case 'core:g:formwidget':
            __Generator::formwidget($argv[2], $project); //,
            echo $argv[2] . ": Form widget generated with success";
            break;

        case 'core:g:viewswidget':
            __Generator::detailwidget($argv[2], $project); //,
            echo $argv[2] . ": Detail widget generated with success";
            break;

        case 'core:g:entity':
            if(isset($argv[3])){
                if(isset($argv[4])){
                    __Generatorjava::entity($argv[2], $project, $argv[4]); //,$argv[4] for package
                    echo $argv[2] . ": Entity java generated with success";
                }else
                    echo "warning: package missing!";
            }else{
                __Generator::entity($argv[2], $project); //,
                echo $argv[2] . ": Entity generated with success";
            }
            break;

        case 'core:g:crud':
            if(isset($argv[3])){
                if(isset($argv[4])){
                    __Generatorjava::crud($argv[2], $project, $argv[4]); //,$argv[4] for package
                    echo $argv[2] . ": Entity java generated with success";
                }else
                    echo "warning: package missing!";
            }else {
                __Generator::crud($argv[2], $project); //,
                echo $argv[2] . ": CRUD generated with success";
            }
            break;

        case 'core:g:dependencies':
            __Generator::__entitydependencies($argv[2], $project); //,
            echo $argv[2] . ": Dependencies generated with success";
            break;

        case 'core:g:module':
            __Generator::module($project, $argv[2]); //, 
            echo $argv[2] . ": Module generated with success";
            break;

        case 'core:g:moduleendless':
            __Generator::__moduleendless($project, $argv[2]); //, 
            echo $argv[2] . ": Moduleendless generated with success";
            break;

        case 'core:g:moduledependencies':
            __Generator::__dependencies($project, $argv[2]); //,
            echo $argv[2] . ": Dependencies generated with success";
            break;

        case 'core:g:moduleindex':
            __Generator::__index($project, $argv[2]); //,
            echo $argv[2] . ": Index generated with success";
            break;

        case 'core:g:moduleservices':
            __Generator::__services($project, $argv[2]); //,
            echo $argv[2] . ": Services generated with success";
            break;

        case 'core:g:moduleressources':
            __Generator::__ressources($project, $argv[2]); //,
            echo $argv[2] . ": Ressources generated with success";
            break;

        case 'core:g:component':
            __Generator::component(Core::getComponentCore($argv[2])); //, 
            echo $project->name . ": component generated with success";
            break;

        default :
            __Generator::help();
            break;
    }

    chdir('../../');
} else {

    require __DIR__ . '/../../src/devups/ModuleAdmin/Entity/Dvups_module.php';
    require __DIR__ . '/../../src/devups/ModuleAdmin/Entity/Dvups_role.php';
    require __DIR__ . '/../../src/devups/ModuleAdmin/Entity/Dvups_right.php';
    require __DIR__ . '/../../src/devups/ModuleAdmin/Entity/Dvups_entity.php';
    require __DIR__ . '/../../src/devups/ModuleAdmin/Entity/Dvups_role_dvups_entity.php';
    require __DIR__ . '/../../src/devups/ModuleAdmin/Entity/Dvups_role_dvups_module.php';
    require __DIR__ . '/../../src/devups/ModuleAdmin/Entity/Dvups_right_dvups_entity.php';

    switch ($argv[1]) {

        case 'install':

            if (!file_exists("cache")) {
                echo " > /cache folders created with success ...\n";
                mkdir('cache', 0777);
                mkdir('cache/views', 0777);
                mkdir('cache/local', 0777);
            }

            if (!file_exists("database")) {
                echo " > /database folders created with success ...\n";
                mkdir('database', 0777);
                mkdir('database/dump', 0777);
                mkdir('database/log', 0777);
                mkdir('database/migration', 0777);
                mkdir('database/transaction', 0777);
            }

            RequestGenerator::databasecreate(dbname); //, 
             echo " > Creating Database.\n\n". dbname . ": created with success ...\n";
            $result = [];
            exec("bin\doctrine orm:schema:create", $result);

            echo "\n > Update database schema (DOCTRINE ORM).\n\n" . implode("\n", $result);

            $rqg = new Database();
            $path = __DIR__ . '/dvupsadmin.sql';
            $dvupsadminsql = file_get_contents($path);
            $rqg->link()->prepare($dvupsadminsql)->execute();

            echo "\n\n > Set the master admin.\n\nData master admin initialized with success.\ncredential\nlogin: dv_admin\npassword: admin\n\nYour project is ready to use. Do your best :)";
            break;

        case 'database:create':
            RequestGenerator::databasecreate(dbname); //, 
            $result = [];
            exec("bin\doctrine orm:schema:create", $result);

            echo dbname . ": created with success\n\n " . implode("\n", $result);
            break;

        case 'dvups_:admin':
            $rqg = new DBAL();
            $path = __DIR__ . '/dvupsadmin.sql';
            $dvupsadminsql = file_get_contents($path);
            $rqg->executeDbal($dvupsadminsql);
            echo "Data admin initialized with success";
            break;

        case 'dvups_:implement':
            Core::updateDvupsTable();
            echo "Data admin updated with success";
            break;

        case 'dvups_:update':
            if (Core::updateDvupsTable())
                echo "Data admin updated with success";
            else
                echo "Data admin already uptodate";
            break;

        default :
            __Generator::help();
            break;
    }
}

echo "\n";



