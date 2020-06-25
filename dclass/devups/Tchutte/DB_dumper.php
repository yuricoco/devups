<?php


namespace dclass\devups\Tchutte;

use DBAL;
use Ifsnop\Mysqldump as IMysqldump;
use Bugmanager;

class DB_dumper extends \Database
{

    public function dump($isrollbackprocess = false)
    {

        $file = ROOT . 'database/dump/dump_' . date("Ymd") . '.sql';
        if($isrollbackprocess)
            $file = ROOT . 'database/dump/dump_' . date("YmdHis") . '.sql';

        //$dir = dirname(__FILE__) . '/dump_' . date("Ymd") . '.sql';

        if(file_exists($file))
            return;

        $user = dbuser;
        $pass = dbpassword;
        $database = dbname;
        $host = dbhost;

        try {
            $dump = new IMysqldump\Mysqldump("mysql:host=$host;dbname=$database", dbuser, dbpassword);
            $dump->start($file);
        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage();
        }
        // exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$file} 2>&1", $output);

//        $moddepend = fopen($file, "a+");
//        fputs($moddepend, $output );
//        fclose($moddepend);
        // var_dump($output);

    }

    public function transaction($table, $sql, $values)
    {

        $transaction = [
            "hour" => date("H:i:s"),
            "table" => $table,
            "sql" => $sql,
            "values" => $values,
            "status" => false,
        ];
        $file = ROOT . 'database/transaction/transaction_' . date("Ymd") . '.data';

        $moddepend = fopen($file, "a+");
        fputs($moddepend, json_encode($transaction) . "\n");
        fclose($moddepend);

    }

    public static function migration($sql)
    {

        $file = ROOT . 'database/migration/migration_' . date("Ymd") . '.sql';

        $moddepend = fopen($file, "a+");
        fputs($moddepend, $sql . "\n");
        fclose($moddepend);

    }

    public function rollback($date)
    {

        $root_path = ROOT . 'database/transaction/transaction_'.$date. '.data';

        //$files = scandir($root_path);

        //for ($i = 2; $i < count($files); $i++) {

            //if (($handle = fopen($root_path . "/" . $files[$i], "r")) !== FALSE) {
            if (($handle = fopen($root_path, "r")) !== FALSE) {
                while (($buffer = fgets($handle, 4096)) !== false) {
                    $transaction = json_decode($buffer);
                    $query = $this->link->prepare($transaction->sql);
                    $result = $query->execute($transaction->values);
                    if (!$result) {

                        $debug = [
                            "success" => false,
                            'class' => __CLASS__,
                            'entity' => $transaction->table,
                            'error' => $query->errorInfo(),
                            'request' => $transaction->sql,
                            'values' => $transaction->values,
                        ];

                        $file = ROOT . 'database/log/log_' . date("Ymd") . '.log';

                        $moddepend = fopen($file, "a+");
                        fputs($moddepend, json_encode($debug) . "\n");
                        fclose($moddepend);

                        echo $transaction->sql." failed with error: ". implode(",", $query->errorInfo()) ."\n";
                    }else
                        echo $transaction->sql." succeed \n";
                    //$dbal->executeDbal($transaction->sql, $transaction->values, $transaction->action);
                }
            }

        //}

    }

}